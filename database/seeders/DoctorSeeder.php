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
        $photos = [
            'doctor1.jpg' => 'doctors-profile-photo/doctor1.jpg',
            'DR.Ibrahim.jpg' => 'doctors-profile-photo/DR.Ibrahim.jpg',
            'doctor2.jpg' => 'doctors-profile-photo/doctor2.jpg',
            'doctor3.png' => 'doctors-profile-photo/doctor3.png',
            'doctor4.jpg' => 'doctors-profile-photo/doctor4.jpg',
            'doctor5.jpg' => 'doctors-profile-photo/doctor5.jpg',
            'doctor6.jpg' => 'doctors-profile-photo/doctor6.jpg',
            'doctor7.jpg' => 'doctors-profile-photo/doctor7.jpg',
        ];

        // Copy images from seeder-images to storage/app/public/doctors-profile-photo
        foreach ($photos as $filename => $path) {
            $sourcePath = database_path("seeders/DocImageSeed/$filename");
            if (file_exists($sourcePath) && !Storage::disk('public')->exists($path)) {
                Storage::disk('public')->put($path, file_get_contents($sourcePath));
            } else {
                // Log an error or notify that the file does not exist
                echo "File does not exist: $sourcePath";
            }
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