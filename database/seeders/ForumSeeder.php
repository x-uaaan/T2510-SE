<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForumSeeder extends Seeder
{
    public function run()
    {
        DB::table('forums')->insert([
            [
                'forumTitle' => 'General Discussion',
                'forumDesc' => 'A place for general discussions about university life, campus events, and student activities.',
                'organiser' => 'Student Council',
                'organiserID' => 1,
                'Categories' => 'General, Campus Life',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'forumTitle' => 'Academic Support',
                'forumDesc' => 'Get help with your studies, share resources, and discuss academic challenges with peers and lecturers.',
                'organiser' => 'Academic Department',
                'organiserID' => 2,
                'Categories' => 'Academic, Support',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'forumTitle' => 'Career Development',
                'forumDesc' => 'Discuss career opportunities, internships, and professional development with alumni and career advisors.',
                'organiser' => 'Career Services',
                'organiserID' => 3,
                'Categories' => 'Career, Professional Development',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'forumTitle' => 'Student Clubs & Activities',
                'forumDesc' => 'Connect with various student clubs, discuss upcoming events, and share your interests with like-minded students.',
                'organiser' => 'Student Activities Office',
                'organiserID' => 4,
                'Categories' => 'Clubs, Activities, Events',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'forumTitle' => 'Technology & Innovation',
                'forumDesc' => 'Share ideas about technology, discuss innovations, and collaborate on tech projects with fellow students.',
                'organiser' => 'Computer Science Department',
                'organiserID' => 5,
                'Categories' => 'Technology, Innovation, Projects',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
} 