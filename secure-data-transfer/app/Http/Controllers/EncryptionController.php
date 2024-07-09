<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class EncryptionController extends Controller
{
    public function showEncryptForm()
    {
        return view('encrypt');
    }

    public function encrypt(Request $request)
    {
        $message = $request->input('message');
        $mobileNumber = $request->input('mobile_number');

        // Encrypt the message
        $encryptedMessage = encrypt($message);

        // Initialize Twilio client
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = env('TWILIO_PHONE_NUMBER');

        $twilio = new Client($sid, $token);

        // Send the encrypted message via SMS using Twilio
        try {
            $twilio->messages->create(
                $mobileNumber,
                [
                    'from' => $twilioPhoneNumber,
                    'body' => $encryptedMessage
                ]
            );
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return view('encrypt', ['encryptedMessage' => $encryptedMessage]);
    }

    public function showDecryptForm()
    {
        return view('decrypt');
    }

    public function decrypt(Request $request)
    {
        $encryptedMessage = $request->input('encrypted_message');
        $otp = $request->input('otp');

        // Decrypt the message
        $decryptedMessage = decrypt($encryptedMessage);

        return view('decrypt', ['decryptedMessage' => $decryptedMessage]);
    }
}