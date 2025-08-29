<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert a record into company_infos table
        DB::table('company_infos')->insert([
            'id' => 1,
            'name' => 'JAAN Network (Pvt) Ltd.',
            'address' => 'No 163/B, Kandy Rd, Weliweriya.',
            'phone' => '0112456789',
            'phone2' => '0717598064',
            'email' => 'info@jaannetwork.com',
            'website' => 'https://jaannetwork.com',
            'logo' => '/images/jaan_logo.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
