<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. Muhamed Ahmed',
                'email' => 'mohamedAhmed@gmail.com',
                'password' => Hash::make(123456),
                'doctor_photo' => storage_path('app/public/doctors/doctor1.jpg'),
                'status' => 1,
            ],

            [
                'name' => 'Dr. Ibrahim Mohamed',
                'email' => 'ibrahimMohamed@gmail.com',
                'password' => Hash::make(123456),
                'doctor_photo' => storage_path('app/public/doctor_photo/ibrahimMohamed.jpg'),
                'status' => 1,
            ],

            [
                'name' => 'Dr. Ahmed Wael',
                'email' => 'ahmedWael@gmail.com',
                'password' => Hash::make(123456),
                'doctor_photo' => storage_path('app/public/doctor_photo/doctor2.jpg'),
                'status' => 1,
            ],

            [
                'name' => 'Dr. Sarah Mohamed',
                'email' => 'sara@gmail.com',
                'password' => Hash::make(123456),
                'doctor_photo' => storage_path('app/public/doctor_photo/doctor3.png'),
                'status' => 1,
            ],

            [
                'name' => 'Dr. Khaled Elsayed',
                'email' => 'khaled@gmail.com',
                'password' => Hash::make(123456),
                'doctor_photo' => storage_path('app/public/doctor_photo/doctor4.jpg'),
                'status' => 1,
            ],

            [
                'name' => 'Dr. Yasser Mohamed',
                'email' => 'yasser@gmail.com',
                'password' => Hash::make(123456),
                'doctor_photo' => storage_path('app/public/doctor_photo/doctor5.jpg'),
                'status' => 1,
            ],

            [
                'name' => 'Dr. Muhamed Ali',
                'email' => 'muhamedAli@gmail.com',
                'password' => Hash::make(123456),
                'doctor_photo' => storage_path('app/public/doctor_photo/doctor6.jpg'),
                'status' => 1,
            ],

            [
                'name' => 'Dr. Omer Yousef',
                'email' => 'omar@gmail.com',
                'password' => Hash::make(123456),
                'doctor_photo' => storage_path('app/public/doctor_photo/doctor7.jpg'),
                'status' => 1,
            ],
        ];

        foreach ($doctors as $doctor) {
            DB::table('doctors')->insert($doctor);
        }
    }
}
