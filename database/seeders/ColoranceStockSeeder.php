<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ColoranceStock;

class ColoranceStockSeeder extends Seeder
{
    public function run(): void
    {
        $codes = ['DA','RO','NO','VI','BE','VR','PV','JP','JV','OV','RP','RV','BP','VBK','JO'];

        // Prepare rows
        $now  = now();
        $rows = array_map(fn ($code) => [
            'name'       => $code,
            'can_size'   => '1L',   // per your spec
            'unit'       => 100,    // initial stock
            'created_at' => $now,
            'updated_at' => $now,
        ], $codes);

        // Upsert by name so you can re-run safely
        ColoranceStock::upsert($rows, ['name'], ['can_size', 'unit', 'updated_at']);
        // If you prefer not to update existing entries, use this instead:
        // foreach ($rows as $row) {
        //     ColoranceStock::firstOrCreate(['name' => $row['name']], $row);
        // }
    }
}

