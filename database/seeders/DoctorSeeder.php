<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::create([
            'name' => 'Dr. Muhamed Ahmed',
            'email' => 'mohamedAhmed@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctor_photo/doctor1.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Ibrahim Mohamed',
            'email' => 'ibrahimMohamed@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctor_photo/ibrahimMohamed.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Ahmed Wael',
            'email' => 'ahmedWael@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctor_photo/doctor2.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Sarah Mohamed',
            'email' => 'sara@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctor_photo/doctor3.png',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Khaled Elsayed',
            'email' => 'khaled@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctor_photo/doctor4.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Yasser Mohamed',
            'email' => 'yasser@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctor_photo/doctor5.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Muhamed Ali',
            'email' => 'muhamedAli@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctor_photo/doctor6.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Omer Yousef',
            'email' => 'omar@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctor_photo/doctor7.jpg',
            'status' => 1,
        ]);
    }
}