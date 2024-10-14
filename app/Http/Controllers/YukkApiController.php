<?php

namespace App\Http\Controllers;

use DateTime;
use GuzzleHttp\Client;
use Milon\Barcode\DNS2D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class YukkApiController extends Controller
{
    private $baseUrl = 'https://snapqris.yukk.co.id';

    public function generateTimestamp()
    {
        $time = new DateTime('now', new \DateTimeZone('Asia/Jakarta'));
        $timestamp = $time->format('c');
        return $timestamp;
    }
    public function generateAccessToken()
    {
        $privateKeyFile = asset('private/pk.pem');
        $baseUrl = $this->baseUrl;
        $endpoint = "/1.0/access-token/b2b";
        $clientId = env('YUKK_CLIENT_ID');

        // String to sign
        $stringToSign = $clientId . '|' . $this->generateTimestamp();

        // Get private key contents
        $privKeyContent = file_get_contents($privateKeyFile);
        $privateKey = openssl_pkey_get_private($privKeyContent);

        // Create signature
        openssl_sign($stringToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $base64Signature = base64_encode($signature);

        // setup client
        $headers = [
            'Content-Type' => 'application/json',
            'X-TIMESTAMP' => $this->generateTimestamp(),
            'X-CLIENT-KEY' => env('YUKK_CLIENT_ID'),
            'X-SIGNATURE' => $base64Signature,
        ];

        $body = [
            'grantType' => 'client_credentials'
        ];

        $response = Http::withHeaders($headers)->post($baseUrl.$endpoint, $body);

        return $response->json();
    }

    public function generateQR()
    {
        $generateToken = $this->generateAccessToken();
        $accessToken = $generateToken['accessToken'];
        $amount = request()->input('amount') ?? '';
        $requestBody = [
            'partnerReferenceNo' => "SNAP_QRIS_JADE_".uniqid(),
            'amount' => [
                'value' => '1.00',
                'currency' => 'IDR'
            ],
            'feeAmount' => [
                'value' => '0.00',
                'currency' => 'IDR'
            ],
            'storeId' => env('YUKK_STORE_ID'),
            'additionalInfo' => [
                'additionalField' => [
                    "merchantId" => "SAI"
                ]
            ]
        ];

        $minifiedRequestBody = json_encode($requestBody);

        $urlGenerateQR = $this->baseUrl."/1.0/qr/qr-mpm-generate";

        // HTTPMethod+”:“+ EndpointUrl +":"+ AccessToken+":“+ Lowercase(HexEncode(SHA256(minify(RequestBody))))+ ":“ +TimeStamp
        $stringToSign = "POST:"."/1.0/qr/qr-mpm-generate:".$accessToken.":".strtolower(hash("sha256", $minifiedRequestBody)).":".$this->generateTimestamp();
        $symmetricSignature = base64_encode(hash_hmac('sha512', $stringToSign, env('YUKK_CLIENT_SECRET'), true));
        $unique = random_int(12,12).round(microtime(true)*10000);
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$accessToken,
            'X-TIMESTAMP' => $this->generateTimestamp(),
            'X-SIGNATURE' => $symmetricSignature,
            'X-PARTNER-ID' => env('YUKK_CLIENT_ID'),
            'X-EXTERNAL-ID' => $unique,
            'CHANNEL-ID' => '00001'
        ];
        $sendRequestQR = Http::withHeaders($headers)->post($urlGenerateQR, $requestBody);
        $result = $sendRequestQR->json();
        $partnerReferenceNo = $result['partnerReferenceNo'];
        $qr = new DNS2D();
        $qr = $qr->getBarcodeHTML($result['qrContent'], 'QRCODE', 4, 4);
        // Pass same variable to queryPayment function
        $this->queryPayment($generateToken, $accessToken, $amount, $requestBody, $minifiedRequestBody, $partnerReferenceNo);
        return view('generated-qr', compact('result', 'qr'));
        // return $result;
    }

    public function queryPayment($generateToken, $accessToken, $amount, $requestBody, $minifiedRequestBody, $partnerReferenceNo)
    {

    }
    // YUKK hit API to JADE
    public function generateAccessTokenForYUKK()
    {
        // GET Header and Body
        $signature = request()->header('X-SIGNATURE') ?? '';
        $clientID = request()->header('X-CLIENT-KEY') ?? '';
        $timestamp = request()->header('X-TIMESTAMP') ?? '';
        $body = request()->input('grantType') ?? '';
        $clientId = env('JADE_CLIENT_ID');

        $timestampFormat = date('c');
        // String to sign
        $stringToSign = $clientId . '|' . $this->generateTimestamp();

        // Get private key contents
        $publicKeyFile = asset('private/rsa_public_key_yukk.pem');
        $pubKeyContent = file_get_contents($publicKeyFile);
        $publicKey = openssl_pkey_get_public($pubKeyContent);

        // Verify the signature sent from YUKK to JADE
        $verify = openssl_verify($stringToSign, $signature, $publicKey, OPENSSL_ALGO_SHA256);
        $realSignature = base64_decode($verify);
        $accessToken = str()->random(983);

        // return $verify;
        if($signature === $realSignature)
        {
            Cache::put('accessToken',$accessToken, now()->addSeconds(900));
            return response()->json([
                'responseCode' => '2007300',
                'responseMessage' => 'Successful',
                'accessToken' => $accessToken,
                'tokenType' => 'Bearer',
                'expiresIn' => '900'
            ]);
        }
        elseif($timestamp !== $timestampFormat){
            return response()->json([
                'responseCode' => '4007301',
                'responseMessage' => 'Invalid Field Format X-TIMESTAMP'
            ]);
        }
        elseif($clientID !== env('JADE_CLIENT_ID')){
            return response()->json([
                'responseCode' => '4007300',
                'responseMessage' => 'Unauthorized. Invalid Client ID'
            ]);
        }else{
            return response()->json([
                'responseCode' => '4007300',
                'responseMessage' => 'Unauthorized. Invalid Signature'
            ]);
        }
        // return $accessToken;
    }

    public function paymentNotification()
    {
        $generateToken = $this->generateAccessTokenForYUKK();
        $accessToken = $generateToken['accessToken'];
        $timestamp = request()->header('X-TIMESTAMP') ?? '';
        $signature = request()->header('X-SIGNATURE') ?? '';
        $partnerId = request()->header('X-PARTNER-ID') ?? '';
        $externalId = request()->header('X-EXTERNAL-ID') ?? '';
        $channelId = request()->header('CHANNEL-ID') ?? '';
        $body = request()->all();
        $timestampFormat = date('c');

        return response()->json([
            'responseCode' => '2005200',
            'responseMessage' => 'Request has been processed successfully'
        ]);
    }
}
