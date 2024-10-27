<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Registering - {{ env('APP_NAME') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5; color: #333; height: 100vh;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px; height: 100vh;">
    <tr>
        <td align="center" style="vertical-align: middle;">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border: 2px solid #333; border-radius: 8px; overflow: hidden;">

                <!-- Logo -->
                <tr>
                    <td align="center" style="padding: 20px; padding-top: 2em;">
                        <img src="{{ asset('images/icons/logo_new.png') }}" alt="Company Logo" width="120" style="border: 0; display: block; margin: 0 auto;">
                    </td>
                </tr>

                <!-- Heading -->
                <tr>
                    <td align="center" style="padding: 10px 20px;">
                        <h1 style="font-size: 24px; color: #333; margin: 0;">Thank you for registering!</h1>
                    </td>
                </tr>

                <!-- Welcome Message -->
                <tr>
                    <td style="padding: 10px 20px;">
                        <p style="font-size: 16px; color: #555; margin: 0; text-align: center;">
                            Hi! Thank you for registering to Jakarta Dental Exhibition (JADE) 2024! <br><br> Here are your registration details:
                        </p>
                    </td>
                </tr>

                <!-- Data Table -->
                <tr>
                    <td style="padding: 20px;">
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                <td style="padding: 8px; text-align: center; font-weight: bold;">Name</td>
                                <td style="padding: 8px;">{{ $handsOn->full_name }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; text-align: center; font-weight: bold;">Email</td>
                                <td style="padding: 8px;">{{ $handsOn->email }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; text-align: center; font-weight: bold;">NIK</td>
                                <td style="padding: 8px;">{{ $handsOn->nik }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; text-align: center; font-weight: bold;">NPA</td>
                                <td style="padding: 8px;">{{ $handsOn->npa }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; text-align: center; font-weight: bold;">PDGI Cabang</td>
                                <td style="padding: 8px;">{{ $handsOn->cabang_pdgi ?? '' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; text-align: center; font-weight: bold;">Phone Number</td>
                                <td style="padding: 8px;">{{ $handsOn->phone_number }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; text-align: center; font-weight: bold;">Seminar & HO</td>
                                <td style="padding: 8px;">{{ $handsOn->attended }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Farewell Message -->
                <tr>
                    <td style="padding: 10px 20px;">
                        <p style="font-size: 16px; color: #555; margin: 0; text-align: center;">
                            See you at the venue!
                        </p>
                    </td>
                </tr>

                <!-- Button -->
                <tr>
                    <td align="center" style="padding: 20px;">
                        <a href="{{ route('forms.detail', $handsOn->formId) }}" target="_blank" style="background-color: #885694; color: #ffffff; text-decoration: none; padding:
                        12px 24px;
                        font-size:
                        16px;
                        border-radius: 5px; display: inline-block;">
                            More details
                        </a>
                    </td>
                </tr>

                <!-- Social Media Links -->
                <tr>
                    <td align="center" style="padding: 20px; padding-bottom: 2em;">
                        <table cellpadding="0" cellspacing="0" style="width: auto;">
                            <tr>
                                <td style="padding: 0 10px;">
                                    <a href="https://www.instagram.com/jktdental.id" target="_blank" style="text-decoration: none;">
                                        <img src="{{ asset('images/icons/instagram-brands-solid.svg') }}" alt="Instagram" width="24" style="display: block;">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
