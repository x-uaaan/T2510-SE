<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run()
    {
        DB::table('events')->insert([
            [
                'eventName' => 'Orientation Week',
                'eventDesc' => 'This event marks the beginning of your exciting journey at the university. Designed to help new students transition smoothly into campus life, the day is filled with engaging activities. Begin with an inspiring welcome speech from our principal, followed by a detailed campus tour where you\'ll discover all the essential spots like lecture halls, the library, and recreation areas. Participate in interactive ice-breaker games led by student mentors, and enjoy performances from various student clubs showcasing the diverse opportunities you can explore. This is your chance to learn, connect, and make your first steps on campus memorable.',
                'eventDate' => '2025-08-05',
                'eventTime' => '09:00:00',
                'eventVenue' => 'Main Auditorium',
                'capacity' => 0,
                'organiser' => 'Student Council',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eventName' => 'Tech Talk: Future of Robotics',
                'eventDesc' => 'Robotics is transforming industries and redefining the future of work. Join us for an insightful session where experts from academia and the tech industry will delve into the latest advancements in robotics. Discover how automation, AI, and machine learning are revolutionising healthcare, manufacturing, and education. You\'ll also have the opportunity to interact with cutting-edge robotic models in live demonstrations. Whether you\'re a tech enthusiast or someone exploring career possibilities, this talk will provide valuable knowledge and inspiration.',
                'eventDate' => '2025-08-05',
                'eventTime' => '14:00:00',
                'eventVenue' => 'Engineering Block Seminar Hall',
                'capacity' => 150,
                'organiser' => 'Engineering Society',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eventName' => 'Shakespeare Reimagined',
                'eventDesc' => 'Prepare to be mesmerised as the Drama Club breathes new life into Shakespeare',
                'eventDate' => '2025-08-15',
                'eventTime' => '18:00:00',
                'eventVenue' => 'Black Box Theatre',
                'capacity' => 100,
                'organiser' => 'Drama Club',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eventName' => 'Hackathon 2025',
                'eventDesc' => 'Gear up for hours of non-stop innovation and creativity at Hackathon 2025',
                'eventDate' => '2025-08-20',
                'eventTime' => '10:00:00',
                'eventVenue' => 'IT Lab',
                'capacity' => 200,
                'organiser' => 'Computer Science Club',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eventName' => 'Green Campus Day',
                'eventDesc' => "Join us in making our campus greener and more sustainable on Green Campus Day. This event features a series of activities including tree planting, recycling drives, and eco-friendly workshops. Engage with environmental experts during panel discussions and learn simple, effective ways to reduce your carbon footprint. Celebrate your efforts with a fun eco-marketplace offering organic products and food. Together, let's create a healthier environment for everyone and inspire a culture of sustainability on our campus.",
                'eventDate' => '2025-08-20',
                'eventTime' => '08:00:00',
                'eventVenue' => 'Campus Grounds',
                'capacity' => 'No Cap',
                'organiser' => 'Environmental Society',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eventName' => 'Inter-College Debate Championship',
                'eventDesc' => 'Witness the finest minds from colleges across the region compete in the annual Inter-College Debate Championship. This intellectually stimulating event showcases the art of persuasive speaking, critical thinking, and teamwork. Each debate session will tackle relevant social, political, and economic topics, sparking lively discussions and diverse perspectives. The championship provides a platform for future leaders to shine and foster healthy competition. Be part of the audience and support your favourite team in this battle of words and wits.',
                'eventDate' => '2025-09-12',
                'eventTime' => '09:00:00',
                'eventVenue' => 'Conference Room A',
                'capacity' => 200,
                'organiser' => 'Debate Society',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eventName' => 'Battle of the Bands',
                'eventDesc' => 'Feel the rhythm and embrace the music as bands from all over compete in this year',
                'eventDate' => '2025-09-25',
                'eventTime' => '19:00:00',
                'eventVenue' => 'Open Air Theatre',
                'capacity' => 300,
                'organiser' => 'Music Club',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eventName' => 'Alumni Meet 2025',
                'eventDesc' => "Reconnect, reminisce, and rejoice at Alumni Meet 2025. This annual gathering brings together alumni from various batches to celebrate shared memories and future aspirations. Relive your campus days with a host of nostalgic activities, including a tour of newly developed campus facilities, networking sessions, and an interactive dinner gala. Hear inspiring success stories from alumni speakers and strengthen your bonds with the university community. Let's make this year's meet an unforgettable experience!",
                'eventDate' => '2025-10-03',
                'eventTime' => '18:00:00',
                'eventVenue' => 'Alumni Hall',
                'capacity' => 200,
                'organiser' => 'Alumni Association',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eventName' => 'Annual Sports Day',
                'eventDesc' => 'Celebrate athleticism, teamwork, and school spirit at our Annual Sports Day. From exhilarating track and field events to thrilling team sports like football and basketball, the day promises excitement for everyone. Students, staff, and faculty are all invited to participate or cheer for their favourites. Enjoy live commentary, music, and refreshments throughout the event. Wrap up the day with an awards ceremony honouring outstanding performances. Come and be part of this vibrant and energetic campus tradition!',
                'eventDate' => '2025-10-15',
                'eventTime' => '07:00:00',
                'eventVenue' => 'Sports Ground',
                'capacity' => 0,
                'organiser' => 'Sports Committee',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'eventName' => 'Orientation Event',
                'eventDesc' => 'Kickstart your university journey with our comprehensive orientation event! Meet your peers, explore the campus, and get all the information you need to succeed.',
                'eventDate' => '2025-07-30',
                'eventTime' => '08:30:00',
                'eventVenue' => 'Grand Hall',
                'capacity' => 500,
                'organiser' => 'Student Council',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}