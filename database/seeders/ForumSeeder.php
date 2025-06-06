<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        $forums = [
            [
                'forumTitle' => 'AI Researching',
                'organiser' => 'AI Club',
                'forumDesc' => "Exploring the latest advancements and applications in artificial intelligence, from neural networks to generative models.",
                'Categories' => 'AI, IT, ML',
            ],
            [
                'forumTitle' => 'Cybersecurity Essentials',
                'organiser' => 'Tech Secure Group',
                'forumDesc' => "Discussing best practices, tools, and trends to safeguard digital assets and prevent cyber threats.",
                'Categories' => 'Cybersecurity, IT, Security',
            ],
            [
                'forumTitle' => 'Climate Change Innovations',
                'organiser' => 'Green Future Forum',
                'forumDesc' => "Showcasing cutting-edge technologies and ideas to combat climate change and promote sustainability.",
                'Categories' => 'Environment, Climate, Innovation',
            ],
            [
                'forumTitle' => 'Blockchain Applications',
                'organiser' => 'Crypto Nexus',
                'forumDesc' => "Delving into real-world uses of blockchain technology across industries like finance, healthcare, and supply chains.",
                'Categories' => 'Blockchain, Cryptocurrency, Finance',
            ],
            [
                'forumTitle' => 'Digital Art Trends',
                'organiser' => 'Creative Coders',
                'forumDesc' => "Exploring emerging trends in digital art, from NFTs to AI-generated artwork, and their impact on the creative industry.",
                'Categories' => 'Art, Digital, Trends',
            ],
            [
                'forumTitle' => 'HealthTech Advancements',
                'organiser' => 'MedTech Alliance',
                'forumDesc' => "Highlighting innovations in medical technology, including wearable devices, telemedicine, and AI in healthcare.",
                'Categories' => 'Health, Technology, Innovation',
            ],
            [
                'forumTitle' => 'Future of Education',
                'organiser' => 'EdTech Pioneers',
                'forumDesc' => "Examining how technology is reshaping education, with discussions on e-learning, VR classrooms, and adaptive learning.",
                'Categories' => 'Education, Technology, Future',
            ],
            [
                'forumTitle' => 'Space Exploration Updates',
                'organiser' => 'Astro Society',
                'forumDesc' => "A look at the latest developments in space exploration, from Mars missions to new satellite technologies.",
                'Categories' => 'Space, Science, Exploration',
            ],
            [
                'forumTitle' => 'Gaming Industry Insights',
                'organiser' => 'Game Developers Hub',
                'forumDesc' => "Analyzing current trends and future possibilities in the gaming world, from VR to indie game development.",
                'Categories' => 'Gaming, Tech, Industry',
            ],
            [
                'forumTitle' => 'Entrepreneurship Strategies',
                'organiser' => 'Startup Leaders',
                'forumDesc' => "Sharing practical strategies and success stories to help entrepreneurs build and scale successful businesses.",
                'Categories' => 'Business, Startup, Strategy',
            ],
        ];

        $organiserIds = [];
        $nextOrganiserId = 1;

        foreach ($forums as $forum) {
            // Assign a unique organiserID for each organiser name
            if (!isset($organiserIds[$forum['organiser']])) {
                $organiserIds[$forum['organiser']] = $nextOrganiserId++;
            }
            $organiserID = $organiserIds[$forum['organiser']];

            DB::table('forums')->insert([
                'forumTitle' => $forum['forumTitle'],
                'forumDesc' => $forum['forumDesc'],
                'organiser' => $forum['organiser'],
                'organiserID' => $organiserID,
                'Categories' => $forum['Categories'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 