<?php

namespace App\Livewire\Public\Forms;

use App\Mail\HandsOnRegistrationMail;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Form;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Milon\Barcode\DNS2D;

class HandsOnForm extends Component
{
    public $name_str, $name_ktp, $nik, $npa, $email, $pdgi_cabang, $no_telepon;
    public $code, $coupon, $couponCode, $messageSuccess, $messageFailed;
    public $discountedPrice = 0,
        $finalTotalAmount = 0,
        $seminarTotal = 0,
        $handsOnTotal = 0,
        $totalAmount = 0;
    public $isHandsOnChecked = [],
        $otherHandsOnSelected = false,
        $enableHO5andHO7 = false,
        $selectedSeminarId,
        $handsOn,
        $seminars;
    #[
        Validate([
            'name_str' => 'required',
            'name_ktp' => 'required',
            'nik' => 'required|max:20',
            'npa' => 'required|max:6',
            'email' => 'required',
            'phone_number' => 'required',
        ]),
    ]
    public function mount()
    {
        $this->handsOn = Product::where('type', 'Hands-On')->get();
        $this->seminars = Product::where('type', 'Seminar')->get();
    }
    public function updatedSelectedSeminars()
    {
        $this->calculateTotalAmount();
    }

    public function updatedIsHandsOnSelected()
    {
        $this->calculateTotalAmount();
    }

    public function calculateTotalAmount()
    {
        // Reset the total amount before recalculating
        $this->totalAmount = 0;
        $this->seminarTotal = 0;
        $this->handsOnTotal = 0;

        // Check if any other hands-on is selected
        $this->enableHO5andHO7 = false;
        foreach ($this->isHandsOnChecked as $optionId => $isSelected) {
            if ($isSelected) {
                $selectedHandsOnOption = $this->handsOn->find($optionId);
                if ($selectedHandsOnOption && !in_array($selectedHandsOnOption->code, ['HO5', 'HO7', 'HO10'])) {
                    $this->enableHO5andHO7 = true;
                    break;
                }
            }
        }
        // Calculate total for selected seminars
        if ($this->selectedSeminarId) {
            $selectedSeminar = $this->seminars->find($this->selectedSeminarId);
            if ($selectedSeminar) {
                $this->seminarTotal += $selectedSeminar->price;
            }
        }

        // Calculate total for selected hands-on options
        foreach ($this->isHandsOnChecked as $optionId => $isSelected) {
            if ($isSelected) {
                $selectedHandsOnOption = $this->handsOn->find($optionId);
                // if ($selectedHandsOnOption) {
                //     $this->handsOnTotal += $selectedHandsOnOption->price;
                // }
                if ($selectedHandsOnOption) {
                // Skip HO5 and HO7 if they should be free
                if (in_array($selectedHandsOnOption->code, ['HO5', 'HO7']) && $this->enableHO5andHO7) {
                    continue;
                }
                // Add price for other hands-on options
                $this->handsOnTotal += $selectedHandsOnOption->price;
            }
            }
        }
        $this->totalAmount = $this->seminarTotal + $this->handsOnTotal;
        $this->applyDiscount();
    }
    public function updatedCouponCode($value)
    {
        $this->validateCouponCode($value);
    }
    public function validateCouponCode($value)
    {
        $coupon = Coupon::where('code', $value)->where('valid_from', '<=', Carbon::now())->where('valid_to', '>=', Carbon::now())->first();
        if ($coupon) {
            if($coupon->quantity <1){
                $this->coupon = null;
                $this->messageFailed = 'Coupon code is no longer available.';
                return;
            }
            // Ensure coupon applies to the selected seminar or hands-on option
            $isCouponApplicable = false;
            if ($coupon->product_id) {
                if ($coupon->product_id == $this->selectedSeminarId) {
                    $isCouponApplicable = true;
                } else {
                    foreach ($this->isHandsOnChecked as $optionId => $isSelected) {
                        if ($isSelected && $coupon->product_id == $optionId) {
                            $isCouponApplicable = true;
                            break;
                        }
                    }
                }
            }
            if ($isCouponApplicable) {
                $this->coupon = $coupon;
                $this->messageSuccess = 'Coupon successfully applied';
            } else {
                $this->coupon = null;
                $this->messageFailed = 'Coupon code does not apply to the selected product.';
            }
        } else {
            $this->coupon = null;
            $this->messageFailed = 'Coupon code either invalid or not existed';
        }
        $this->calculateTotalAmount();
    }
    protected function applyDiscount()
    {
        if ($this->coupon) {
            $discountOnSeminar = 0;
            $discountOnHandsOn = 0;

            // Apply discount only to the relevant product
            if ($this->coupon->product_id == $this->selectedSeminarId) {
                // Discount on seminar
                $discountOnSeminar = $this->coupon->type === 'Fixed' ? min($this->coupon->amount, $this->seminarTotal) : ($this->coupon->amount / 100) * $this->seminarTotal;
            } elseif (in_array($this->coupon->product_id, array_keys($this->isHandsOnChecked, true))) {
                // Discount on hands-on option
                $discountOnHandsOn = $this->coupon->type === 'Fixed' ? min($this->coupon->amount, $this->handsOnTotal) : ($this->coupon->amount / 100) * $this->handsOnTotal;
            }
            // Total discount and final total amount
            $this->discountedPrice = $discountOnSeminar + $discountOnHandsOn;
            $this->finalTotalAmount = $this->totalAmount - $this->discountedPrice;
        } else {
            // if coupon is not inputted
            $this->discountedPrice = 0;
            $this->finalTotalAmount = $this->totalAmount;
        }
    }
    public function submit()
    {
        // Before proceeding, check if the coupon still has quantity available
        if ($this->coupon && $this->coupon->quantity <= 0) {
            $this->messageFailed = 'Coupon code is no longer available.';
        }
        $seminar = $this->seminars->find($this->selectedSeminarId);
        $selectedOptionCodes = [];
        foreach ($this->isHandsOnChecked as $optionId => $isSelected) {
            if ($isSelected) {
                // Find the corresponding hands-on option by ID
                $selectedOption = $this->handsOn->firstWhere('id', $optionId);
                if ($selectedOption) {
                    $selectedOptionCodes[] = $selectedOption->code;
                } else {
                    $selectedOptionCodes[] = null;
                }
            }
        }
        $code = implode(', ', $selectedOptionCodes);
        $uuid = Str::orderedUuid();
        $qr = new DNS2D();
        $qr = base64_decode($qr->getBarcodePNG(route('forms.hands-on.detail', $uuid), 'QRCODE'));
        $path = 'img/forms/hands-on/' . $uuid . '.png';
        Storage::disk('public')->put($path, $qr);
        $handsOn = Form::create([
            'formId' => $uuid,
            'name_str' => $this->name_str,
            'full_name' => $this->name_ktp,
            'email' => $this->email,
            'nik' => $this->nik,
            'npa' => $this->npa,
            'cabang_pdgi' => $this->pdgi_cabang,
            'phone_number' => $this->no_telepon,
            'seminar' => $seminar->name ?? '',
            'attended' => $code ?? '',
            'amount' => $this->finalTotalAmount,
            'barcode' => $path,
            'applied_coupon' => $this->couponCode,
            'submitted_date' => Carbon::now(),
        ]);
        $trxForm = Transaction::create([
            'transactionId' => Str::orderedUuid(),
            'participant_name' => $this->name_ktp,
            'phone_number' => $this->no_telepon,
            'amount' => $this->finalTotalAmount,
            'submitted_date' => Carbon::now(),
        ]);
        // Decrement coupon quantity only after form is successfully submitted
        if ($this->coupon) {
            $this->coupon->decrement('quantity');
        }
        Cache::put('handsOnForm', $handsOn);
        Cache::put('trxDataForm', $trxForm);
        Mail::to($this->email)->send(new HandsOnRegistrationMail($handsOn));
        $amount = base64_encode($this->finalTotalAmount);
        return $this->redirectRoute('generate_qr', ['amount' => $amount]);
    }
    #[Layout('components.layouts.public')]
    #[Title('Hands-On Registration')]
    public function render()
    {
        // dd($this->selectedSeminarId);
        return view('livewire.public.forms.hands-on-form');
    }
}
