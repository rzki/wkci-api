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

    public function generatePartnerReferenceNo()
    {
        $partnerRefNo = 'SNAP_QRIS_JADE_'.uniqid();
        Cache::put('partnerRefNo', $partnerRefNo, now()->addSeconds(120));
        return $partnerRefNo;
    }
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
        $amount = request()->input('amount') ?? '1';
        $this->generatePartnerReferenceNo();
        $requestBody = [
            'partnerReferenceNo' => Cache::get('partnerRefNo'),
            'amount' => [
                'value' => $amount.'.00',
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
        Cache::put('generateQrResult', $result, now()->addSeconds(900));
        $cachedResult = Cache::get('generateQrResult');
        $qr = new DNS2D();
        $qr = $qr->getBarcodeHTML($result['qrContent'], 'QRCODE', 4, 4);
        // Pass same variable to queryPayment function
        return view('generated-qr', compact('result', 'qr'));
        // return $cachedResult;
    }

    public function queryPayment()
    {
        $generateAccessToken = $this->generateAccessToken();
        $accessToken = $generateAccessToken['accessToken'];
        $resultCache = Cache::get('generateQrResult');
        $unique = random_int(12,12).round(microtime(true)*10000);
        $endpoint = "/1.0/qr/qr-mpm-query";
        // $qr = new DNS2D();
        // $qr = $qr->getBarcodeHTML($resultCache['qrContent'], 'QRCODE', 4, 4);
        $body = [
            'originalPartnerReferenceNo' => $resultCache['partnerReferenceNo'],
            'serviceCode' => '47',
            'externalStoreID' => env('YUKK_STORE_ID')
        ];
        $minifyRequestBody = json_encode($body);
        $stringToSign = "POST:"."/1.0/qr/qr-mpm-query:".$accessToken.":".strtolower(hash("sha256", $minifyRequestBody)).":".$this->generateTimestamp();
        $symmetricSignature = base64_encode(hash_hmac('sha512', $stringToSign, env('YUKK_CLIENT_SECRET'), true));
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$accessToken,
            'X-TIMESTAMP' => $this->generateTimestamp(),
            'X-SIGNATURE' => $symmetricSignature,
            'X-PARTNER-ID' => env('YUKK_CLIENT_ID'),
            'X-EXTERNAL-ID' => $unique,
            'CHANNEL-ID' => '00001'
        ];

        $sendQueryPayment = Http::withHeaders($headers)->post($this->baseUrl.$endpoint, $body);
        $queryResult = $sendQueryPayment->json();
        if($queryResult['transactionStatusDesc'] == 'Paid'){
            return to_route('notify_payment');
        }else{
            // return view('query-payment', compact('queryResult', 'qr', 'resultCache'));
            return $queryResult;
        }
        // return $queryResult;
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
            Cache::put('accessTokenYUKK',$accessToken, now()->addSeconds(900));
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
        }elseIf(!$body){
            return response()->json([
                "responseCode" => "4007302",
                "responseMessage" => "Invalid Mandatory Field grantType"
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
        $this->generateAccessTokenForYUKK();
        $accessToken = Cache::get('accessTokenYUKK');
        $timestamp = $this->generateTimestamp();
        $queryResult = $this->queryPayment();
        $body = [
            'originalReferenceNo' => $queryResult['originalReferenceNo'],
            'latestTransactionStatus' => $queryResult['latestTransactionStatus'],
            'transactionStatusDesc' => $queryResult['transactionStatusDesc'],
            'amount' => [
                'value' => $queryResult['amount']['value'],
                'currency' => 'IDR',
            ],
            'externalStoreID' => env('YUKK_STORE_ID'),
            'additionalInfo' => [
                'additionalField' => $queryResult['additionalInfo']['additionalField'],
                'rrn' => '210430233071'
                ]
            ];
            $minifyRequestBody = json_encode($body);
            $stringToSign = "POST:"."/1.0/qr/qr-mpm-notify:".$accessToken.":".strtolower(hash("sha256", $minifyRequestBody)).":".$this->generateTimestamp();
            $symmetricSignature = base64_encode(hash_hmac('sha512', $stringToSign, env('JADE_CLIENT_SECRET'), true));
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$accessToken,
                'X-TIMESTAMP' => $timestamp,
                'X-SIGNATURE' => $symmetricSignature
            ];

//        return [$headers, $body];
        // return $accessToken;
        if(!$body['originalReferenceNo']){
            return response()->json([
                "responseCode" => "4005202",
                "responseMessage" => "Invalid Mandatory Field originalReferenceNo"
            ]);
        }elseif (!$body['latestTransactionStatus']){
            return response()->json([
                "responseCode" => "4005202",
                "responseMessage" => "Invalid Mandatory Field latestTransactionStatus"
            ]);
        }elseif (!$body['transactionStatusDesc']){
            return response()->json([
                "responseCode" => "4005202",
                "responseMessage" => "Invalid Mandatory Field transactionStatusDesc"
            ]);
        }elseif (!$body['amount']['value']){
            return response()->json([
                "responseCode" => "4005202",
                "responseMessage" => "Invalid Mandatory Field amount.value"
            ]);
        }elseif ($body['externalStoreID'] !== env('YUKK_STORE_ID')){
            return response()->json([
                "responseCode" => "4005202",
                "responseMessage" => "Invalid Mandatory Field externalStoreID"
            ]);
        }elseif (!$body['additionalInfo']['rrn']){
            return response()->json([
                "responseCode" => "4005202",
                "responseMessage" => "Invalid Mandatory Field additionalInfo.rrn"
            ]);
        }else{
            $response = response()->json([
                'responseCode' => '2005200',
                'responseMessage' => 'Request has been processed successfully'
            ]);
//            return [$headers, $body, $response];
            return $response;
        }
    }
}
