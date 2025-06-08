<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $alumni = [
            [
                'alumniName' => 'Dr. Jane Patel',
                'alumniEmail' => 'jane.patel@example.com',
                'alumniPhone' => '1234567890',
                'alumniFaculty' => 'Computer Science',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Mark Stevens',
                'alumniEmail' => 'mark.stevens@example.com',
                'alumniPhone' => '1234567891',
                'alumniFaculty' => 'Cybersecurity',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Rachel Carter',
                'alumniEmail' => 'rachel.carter@example.com',
                'alumniPhone' => '1234567892',
                'alumniFaculty' => 'Information Security',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Laura Green',
                'alumniEmail' => 'laura.green@example.com',
                'alumniPhone' => '1234567893',
                'alumniFaculty' => 'Environmental Science',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Mike Johnson',
                'alumniEmail' => 'mike.johnson@example.com',
                'alumniPhone' => '1234567894',
                'alumniFaculty' => 'Agriculture',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Dr. Alice Lee',
                'alumniEmail' => 'alice.lee@example.com',
                'alumniPhone' => '1234567895',
                'alumniFaculty' => 'Computer Science',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Kevin Moore',
                'alumniEmail' => 'kevin.moore@example.com',
                'alumniPhone' => '1234567896',
                'alumniFaculty' => 'Computer Science',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Sofia Turner',
                'alumniEmail' => 'sofia.turner@example.com',
                'alumniPhone' => '1234567897',
                'alumniFaculty' => 'Digital Arts',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Jordan Smith',
                'alumniEmail' => 'jordan.smith@example.com',
                'alumniPhone' => '1234567898',
                'alumniFaculty' => 'Digital Media',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Dr. Emily Wong',
                'alumniEmail' => 'emily.wong@example.com',
                'alumniPhone' => '1234567899',
                'alumniFaculty' => 'Medicine',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Dr. Samuel King',
                'alumniEmail' => 'samuel.king@example.com',
                'alumniPhone' => '1234567800',
                'alumniFaculty' => 'Medicine',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Nancy Adams',
                'alumniEmail' => 'nancy.adams@example.com',
                'alumniPhone' => '1234567801',
                'alumniFaculty' => 'Education Technology',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Prof. John Miller',
                'alumniEmail' => 'john.miller@example.com',
                'alumniPhone' => '1234567802',
                'alumniFaculty' => 'Education',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Dr. Alan Carter',
                'alumniEmail' => 'alan.carter@example.com',
                'alumniPhone' => '1234567803',
                'alumniFaculty' => 'Aerospace Engineering',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Dr. Maria Lopez',
                'alumniEmail' => 'maria.lopez@example.com',
                'alumniPhone' => '1234567804',
                'alumniFaculty' => 'Satellite Technology',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Adam Jones',
                'alumniEmail' => 'adam.jones@example.com',
                'alumniPhone' => '1234567805',
                'alumniFaculty' => 'Game Development',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Emma Brown',
                'alumniEmail' => 'emma.brown@example.com',
                'alumniPhone' => '1234567806',
                'alumniFaculty' => 'Virtual Reality',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Lisa Forbes',
                'alumniEmail' => 'lisa.forbes@example.com',
                'alumniPhone' => '1234567807',
                'alumniFaculty' => 'Entrepreneurship',
                'alumniResume' => null
            ],
            [
                'alumniName' => 'Tim Watson',
                'alumniEmail' => 'tim.watson@example.com',
                'alumniPhone' => '1234567808',
                'alumniFaculty' => 'Business Leadership',
                'alumniResume' => null
            ],
        ];

        foreach ($alumni as $alumnus) {
            DB::table('alumni')->insert([
                'alumniName' => $alumnus['alumniName'],
                'alumniEmail' => $alumnus['alumniEmail'],
                'alumniPhone' => $alumnus['alumniPhone'],
                'alumniFaculty' => $alumnus['alumniFaculty'],
                'alumniResume' => $alumnus['alumniResume'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 