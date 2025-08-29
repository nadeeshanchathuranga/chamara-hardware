<?php

namespace App\Traits;

trait PrinterTrait
{
    /**
     * Send a raw ESC/POS command to the printer to open the cash drawer.
     *
     * @param string $printerName
     * @return bool|string
     */
    
    // public function openCashDrawer()
    // {
    //     // ESC/POS command to open cash drawer
    //     $openDrawerCommand = "\x1B\x70\x00\x19\xFA"; // ESC/POS command in hexadecimal

    //     // Printer share name
    //     $printerName = "\\\\localhost\\XP-58C"; // Replace with your printer's share name

    //     // Create a temporary file with the raw ESC/POS command
    //     $tempFile = tempnam(sys_get_temp_dir(), 'escpos');
    //     file_put_contents($tempFile, $openDrawerCommand);

    //     // Send the raw file to the printer
    //     exec("copy /b $tempFile $printerName", $output, $result);

    //     // Clean up the temporary file
    //     unlink($tempFile);

    //     if ($result === 0) {
    //         echo "Cash drawer opened successfully!";
    //     } else {
    //         echo "Failed to open cash drawer. Error: " . implode("\n", $output);
    //     }
    // }

    public function openCashDrawer()
    {
        // ESC/POS command to open cash drawer
        $openDrawerCommand = "\x1B\x70\x00\x19\xFA"; // ESC/POS command in hexadecimal

        // Printer name as configured in CUPS
        $printerName = "XP-58C"; // Replace with your actual printer name

        // Create a temporary file with the raw ESC/POS command
        $tempFile = tempnam(sys_get_temp_dir(), 'escpos');
        file_put_contents($tempFile, $openDrawerCommand);

        // Send the raw file to the printer
        exec("lp -o raw -d $printerName $tempFile", $output, $result);

        // Clean up the temporary file
        unlink($tempFile);

        if ($result === 0) {
            echo "Cash drawer opened successfully!";
        } else {
            echo "Failed to open cash drawer. Error: " . implode("\n", $output);
        }
    }
}
