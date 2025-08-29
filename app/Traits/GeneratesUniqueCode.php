<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GeneratesUniqueCode
{
    /**
     * Generate a unique code.
     *
     * @param int $length Length of the unique code.
     * @return string
     */
    public function generateUniqueCode($length = 12)
    {
        // Generate the base code with 12 digits (timestamp + random numeric string)
        $timestamp = substr(now()->timestamp, -6); // Use the last 6 digits of the current timestamp
        $random = str_pad(mt_rand(0, pow(10, $length - strlen($timestamp)) - 1), $length - strlen($timestamp), '0', STR_PAD_LEFT); // Generate the remaining random digits

        $codeWithoutChecksum = $timestamp . $random; // Combine timestamp and random digits to get 12 digits

        // Ensure the code is exactly 12 digits
        $codeWithoutChecksum = substr($codeWithoutChecksum, 0, 12);

        // Calculate the checksum for EAN-13
        $checksum = $this->calculateEAN13Checksum($codeWithoutChecksum);

        // Return the full 13-digit EAN-13 code
        return $codeWithoutChecksum . $checksum;
    }

    private function calculateEAN13Checksum($code)
    {
        $sum = 0;

        // EAN-13 checksum algorithm
        for ($i = 0; $i < strlen($code); $i++) {
            $digit = (int)$code[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3; // Multiply every second digit by 3
        }

        // Calculate the checksum digit
        return (10 - ($sum % 10)) % 10;
    }
}
