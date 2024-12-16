<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{
    public static function decrypt_id(string $value) 
    {
        try {
            $decrypted_value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }

        return $decrypted_value;
    }
}