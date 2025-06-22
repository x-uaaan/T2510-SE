<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            // AI Researching Forum
            [
                'postTitle' => 'The Future of Generative AI in Education',
                'postDesc' => 'Discussing how AI-driven tools can personalize learning and reshape educational systems globally.',
                'alumniID' => 1, // Dr. Jane Patel
                'forumID' => 1, // AI Researching
                'timestamp' => '2025-06-01 14:35:00',
                'comment' => json_encode([
                    'Could generative AI replace traditional teaching methods entirely?',
                    'What challenges do schools face in adopting AI tools?',
                    'This will only work with massive datasets; what about privacy concerns?'
                ])
            ],
            [
                'postTitle' => 'ML 101',
                'postDesc' => 'Introduction to ML, beginner-friendly.',
                'alumniID' => 1, // Dr. Jane Patel
                'forumID' => 1, // AI Researching
                'timestamp' => '2025-06-02 10:15:00',
                'comment' => json_encode([
                    'What can ML do?',
                    'So informative!',
                    'That\'s inspiring!',
                    'I\'m not sure about the future of AI.',
                    'I think we need to be careful with AI.',
                    'So excited to see the future of AI!',
                    'Love to learn more about AI!',
                    'So informative!',
                    'That\'s inspiring!',
                    'I\'m not sure about the future of AI.',
                    'I think we need to be careful with AI.',
                    'So excited to see the future of AI!',
                    'Love to learn more about AI!'
                ])
            ],

            // Cybersecurity Essentials Forum
            [
                'postTitle' => 'Ransomware Attacks: How to Stay Safe',
                'postDesc' => 'Insights into the growing threat of ransomware and strategies for protection.',
                'alumniID' => 2, // Mark Stevens
                'forumID' => 2, // Cybersecurity Essentials
                'timestamp' => '2025-06-01 09:50:00',
                'comment' => json_encode([
                    'Are there any tools to detect ransomware early?',
                    'How do companies recover from such attacks?',
                    'This is becoming a huge concern for small businesses.'
                ])
            ],
            [
                'postTitle' => 'Best Practices for Secure Passwords',
                'postDesc' => 'Discussing how strong passwords can prevent cyber breaches.',
                'alumniID' => 3, // Rachel Carter
                'forumID' => 2, // Cybersecurity Essentials
                'timestamp' => '2025-06-02 13:25:00',
                'comment' => json_encode([
                    'What\'s the ideal password length?',
                    'Password managers are lifesavers!',
                    'How secure are biometric options compared to passwords?'
                ])
            ],

            // Climate Change Innovations Forum
            [
                'postTitle' => 'Renewable Energy Revolution',
                'postDesc' => 'Exploring the latest breakthroughs in solar, wind, and geothermal technologies.',
                'alumniID' => 4, // Laura Green
                'forumID' => 3, // Climate Change Innovations
                'timestamp' => '2025-06-01 16:45:00',
                'comment' => json_encode([
                    'Which renewable source is the most efficient?',
                    'This could solve the energy crisis.',
                    'How do we make this accessible to developing countries?'
                ])
            ],
            [
                'postTitle' => 'Urban Farming: A Sustainable Future',
                'postDesc' => 'How urban farming can address food security and reduce carbon footprints.',
                'alumniID' => 5, // Mike Johnson
                'forumID' => 3, // Climate Change Innovations
                'timestamp' => '2025-06-03 08:00:00',
                'comment' => json_encode([
                    'What technologies make urban farming viable?',
                    'Does this work in dense cities?',
                    'Could this reduce transportation emissions?'
                ])
            ],

            // Blockchain Applications Forum
            [
                'postTitle' => 'Blockchain in Healthcare',
                'postDesc' => 'Improving patient data security and sharing through blockchain.',
                'alumniID' => 6, // Dr. Alice Lee
                'forumID' => 4, // Blockchain Applications
                'timestamp' => '2025-06-02 11:30:00',
                'comment' => json_encode([
                    'Is blockchain scalable for nationwide healthcare systems?',
                    'What about patient privacy?',
                    'This sounds revolutionary!'
                ])
            ],
            [
                'postTitle' => 'Smart Contracts Explained',
                'postDesc' => 'A beginner\'s guide to understanding and implementing smart contracts.',
                'alumniID' => 7, // Kevin Moore
                'forumID' => 4, // Blockchain Applications
                'timestamp' => '2025-06-04 09:15:00',
                'comment' => json_encode([
                    'What industries use smart contracts the most?',
                    'This simplifies legal processes.',
                    'Are there any downsides to smart contracts?'
                ])
            ],

            // Digital Art Trends Forum
            [
                'postTitle' => 'The Rise of AI-Generated Art',
                'postDesc' => 'How AI tools are transforming the art industry and sparking debate among artists.',
                'alumniID' => 8, // Sofia Turner
                'forumID' => 5, // Digital Art Trends
                'timestamp' => '2025-06-01 12:00:00',
                'comment' => json_encode([
                    'Does this devalue traditional art?',
                    'AI art is fascinating!',
                    'What\'s the future for human artists?'
                ])
            ],
            [
                'postTitle' => 'NFTs: Fad or Future?',
                'postDesc' => 'Analyzing the sustainability and viability of NFTs in the art world.',
                'alumniID' => 9, // Jordan Smith
                'forumID' => 5, // Digital Art Trends
                'timestamp' => '2025-06-03 14:10:00',
                'comment' => json_encode([
                    'What about the environmental impact of NFTs?',
                    'Are NFTs still popular in 2025?',
                    'How do artists protect their work as NFTs?'
                ])
            ],

            // HealthTech Advancements Forum
            [
                'postTitle' => 'Wearable Devices: A Game Changer for Health Monitoring',
                'postDesc' => 'Discussing the role of wearable tech in improving health outcomes.',
                'alumniID' => 10, // Dr. Emily Wong
                'forumID' => 6, // HealthTech Advancements
                'timestamp' => '2025-06-02 08:20:00',
                'comment' => json_encode([
                    'Can wearables predict health issues early?',
                    'How accurate are these devices?',
                    'What\'s the most popular wearable right now?'
                ])
            ],
            [
                'postTitle' => 'Telemedicine in Rural Areas',
                'postDesc' => 'How telemedicine is bridging the healthcare gap in underserved areas.',
                'alumniID' => 11, // Dr. Samuel King
                'forumID' => 6, // HealthTech Advancements
                'timestamp' => '2025-06-04 10:45:00',
                'comment' => json_encode([
                    'What are the biggest challenges for telemedicine?',
                    'This has the potential to save lives.',
                    'How reliable is internet infrastructure in rural areas?'
                ])
            ],

            // Future of Education Forum
            [
                'postTitle' => 'Virtual Reality Classrooms',
                'postDesc' => 'Exploring the possibilities of immersive learning through VR technology.',
                'alumniID' => 12, // Nancy Adams
                'forumID' => 7, // Future of Education
                'timestamp' => '2025-06-02 13:10:00',
                'comment' => json_encode([
                    'This could revolutionize STEM education!',
                    'What\'s the cost of setting up VR classrooms?',
                    'How do students without access to VR participate?'
                ])
            ],
            [
                'postTitle' => 'E-Learning Platforms: Trends and Challenges',
                'postDesc' => 'Analyzing the evolution of e-learning and its impact on traditional education.',
                'alumniID' => 13, // Prof. John Miller
                'forumID' => 7, // Future of Education
                'timestamp' => '2025-06-03 15:30:00',
                'comment' => json_encode([
                    'How do we ensure quality content on these platforms?',
                    'E-learning has made education so accessible.',
                    'What about teacher-student interaction?'
                ])
            ],

            // Space Exploration Updates Forum
            [
                'postTitle' => 'Mars Missions: The Next Frontier',
                'postDesc' => 'Updates on global efforts to colonize Mars.',
                'alumniID' => 14, // Dr. Alan Carter
                'forumID' => 8, // Space Exploration Updates
                'timestamp' => '2025-06-01 18:20:00',
                'comment' => json_encode([
                    'How soon can we expect humans on Mars?',
                    'What are the biggest hurdles?',
                    'This is the beginning of a new era.'
                ])
            ],
            [
                'postTitle' => 'Advancements in Satellite Technology',
                'postDesc' => 'How new satellites are enhancing communication and data collection.',
                'alumniID' => 15, // Dr. Maria Lopez
                'forumID' => 8, // Space Exploration Updates
                'timestamp' => '2025-06-03 11:40:00',
                'comment' => json_encode([
                    'Will this reduce internet costs?',
                    'What about space debris from outdated satellites?',
                    'Are these satellites climate-resilient?'
                ])
            ],

            // Gaming Industry Insights Forum
            [
                'postTitle' => 'The Rise of Indie Games',
                'postDesc' => 'How indie developers are reshaping the gaming landscape.',
                'alumniID' => 16, // Adam Jones
                'forumID' => 9, // Gaming Industry Insights
                'timestamp' => '2025-06-01 17:00:00',
                'comment' => json_encode([
                    'What makes indie games stand out?',
                    'The creativity in indie games is unmatched!',
                    'How do these developers compete with big studios?'
                ])
            ],
            [
                'postTitle' => 'VR Gaming: The Future is Here',
                'postDesc' => 'Exploring the immersive experiences offered by VR games.',
                'alumniID' => 17, // Emma Brown
                'forumID' => 9, // Gaming Industry Insights
                'timestamp' => '2025-06-03 09:30:00',
                'comment' => json_encode([
                    'What are the top VR games in 2025?',
                    'This feels like the future!',
                    'What\'s holding back mass adoption of VR?'
                ])
            ],

            // Entrepreneurship Strategies Forum
            [
                'postTitle' => 'Scaling Your Startup: Tips and Tricks',
                'postDesc' => 'Strategies for entrepreneurs to scale their businesses effectively.',
                'alumniID' => 18, // Lisa Forbes
                'forumID' => 10, // Entrepreneurship Strategies
                'timestamp' => '2025-06-02 12:15:00',
                'comment' => json_encode([
                    'What\'s the best way to secure funding?',
                    'Scaling is harder than starting!',
                    'How do you balance growth and quality?'
                ])
            ],
            [
                'postTitle' => 'Leadership in Startups',
                'postDesc' => 'The role of effective leadership in a startup\'s success.',
                'alumniID' => 19, // Tim Watson
                'forumID' => 10, // Entrepreneurship Strategies
                'timestamp' => '2025-06-04 14:20:00',
                'comment' => json_encode([
                    'What qualities make a great startup leader?',
                    'Leadership defines the culture of a startup.',
                    'How do leaders handle failures effectively?'
                ])
            ],
        ];

        foreach ($posts as $post) {
            DB::table('posts')->insert([
                'postTitle' => $post['postTitle'],
                'postDesc' => $post['postDesc'],
                'alumniID' => $post['alumniID'],
                'forumID' => $post['forumID'],
                'timestamp' => $post['timestamp'],
                'comment' => $post['comment'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 