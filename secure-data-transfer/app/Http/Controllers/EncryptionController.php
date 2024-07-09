<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class EncryptionController extends Controller
{
    private $twilioSid;
    private $twilioAuthToken;
    private $twilioPhoneNumber;

    public function __construct()
    {
        $this->twilioSid = env('TWILIO_ACCOUNT_SID');
        $this->twilioAuthToken = env('TWILIO_AUTH_TOKEN');
        $this->twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');
    }

    public function showEncryptForm()
    {
        return view('encrypt');
    }

    public function showDecryptForm()
    {
        return view('decrypt');
    }

    public function encrypt(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'mobile_number' => 'required|string|regex:/^\+?[1-9]\d{1,14}$/',
        ]);

        $message = $request->input('message');
        $mobileNumber = $request->input('mobile_number');

        // Generate a random key
        $key = openssl_random_pseudo_bytes(16);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));

        // Encrypt the message
        $encryptedMessage = openssl_encrypt($message, 'aes-128-cbc', $key, 0, $iv);
        $encryptedMessage = base64_encode($iv . $encryptedMessage);

        // Send the key via SMS
        $otp = bin2hex($key);
        $this->sendSms($mobileNumber, "Your OTP is: $otp");

        return view('encrypt', ['encryptedMessage' => $encryptedMessage]);
    }

    public function decrypt(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'mobile_number' => 'required|string|regex:/^\+[1-9]\d{1,14}$/',
        ]);

        $encryptedMessage = base64_decode($request->input('encrypted_message'));
        $otp = hex2bin($request->input('otp'));

        // Extract the IV and the encrypted message
        $ivLength = openssl_cipher_iv_length('aes-128-cbc');
        $iv = substr($encryptedMessage, 0, $ivLength);
        $encryptedMessage = substr($encryptedMessage, $ivLength);

        // Decrypt the message
        $decryptedMessage = openssl_decrypt($encryptedMessage, 'aes-128-cbc', $otp, 0, $iv);

        return view('decrypt', ['decryptedMessage' => $decryptedMessage]);
    }

    private function sendSms($to, $message)
    {
        $client = new Client($this->twilioSid, $this->twilioAuthToken);
        $client->messages->create($to, [
            'from' => $this->twilioPhoneNumber,
            'body' => $message,
        ]);
    }
}
