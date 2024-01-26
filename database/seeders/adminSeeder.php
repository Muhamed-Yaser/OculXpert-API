<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            "name" => 'Mohamed Yasser Ragheb',
            "email" => 'mohamed Ragheb@gmail.com',
            "password" => Hash::make('123456789')
        ]);
    }
}
