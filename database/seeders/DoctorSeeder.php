<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            'doctor1.jpg',
            'doctor2.jpg',
            'doctor3.jpg',
            'doctor4.jpg',
            'doctor5.jpg',
            'doctor6.jpg',
            'doctor7.jpg',
            'DR.Ibrahim.jpg'
        ];

        foreach ($images as $image) {
            Storage::disk('public')->put('doctors-profile-photo/' . $image, file_get_contents(database_path('seeders/DocImageSeed/' . $image)));
        }

        Doctor::create([
            'name' => 'Dr. Shrief Ali',
            'email' => 'Shrief@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctors-profile-photo/doctor1.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr.Ibrahim',
            'email' => 'Ibrahim@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctors-profile-photo/DR.Ibrahim.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Sarah Mohamed',
            'email' => 'sara@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctors-profile-photo/doctor2.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Khaled Elsayed',
            'email' => 'khaled@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctors-profile-photo/doctor3.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Yasser Mohamed',
            'email' => 'yasser@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctors-profile-photo/doctor4.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Muhamed Ali',
            'email' => 'muhamedAli@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctors-profile-photo/doctor5.jpg',
            'status' => 1,
        ]);

        Doctor::create([
            'name' => 'Dr. Omer Yousef',
            'email' => 'omar@gmail.com',
            'password' => Hash::make(123456),
            'doctor_photo' => 'doctors-profile-photo/doctor6.jpg',
            'status' => 1,
        ]);
    }
}