-- Campus Pulse Database Schema and Sample Data (MySQL)
-- ------------------------------------------------------
-- This file creates the main tables and inserts sample data for the Campus Pulse alumni management system.
-- Entities: users, admins, alumni, lecturers, forums, posts, events, attendees

DROP DATABASE IF EXISTS `CampusPulse`;
CREATE DATABASE `CampusPulse`;
USE `CampusPulse`;

-- USERS TABLE
CREATE TABLE users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255),
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(255),
    faculty VARCHAR(255),
    resume_path VARCHAR(255),
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255),
    microsoft_id VARCHAR(255),
    profile_completed BOOLEAN DEFAULT FALSE,
    remember_token VARCHAR(100),
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- ADMINS TABLE
CREATE TABLE admins (
    adminID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    adminName VARCHAR(255) NOT NULL,
    adminEmail VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

INSERT INTO admins (adminName, adminEmail, created_at, updated_at) VALUES
('Alice Smith', 'alice.smith@example.com', NOW(), NOW()),
('Bob Johnson', 'bob.johnson@example.com', NOW(), NOW()),
('Charlie Lee', 'charlie.lee@example.com', NOW(), NOW()),
('Diana King', 'diana.king@example.com', NOW(), NOW()),
('Ethan Brown', 'ethan.brown@example.com', NOW(), NOW());

-- ALUMNI TABLE
CREATE TABLE alumni (
    alumniID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    alumniName VARCHAR(255) NOT NULL,
    alumniEmail VARCHAR(255) NOT NULL UNIQUE,
    alumniPhone VARCHAR(255) NOT NULL,
    alumniFaculty VARCHAR(255) NOT NULL,
    alumniResume TEXT,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

INSERT INTO alumni (alumniName, alumniEmail, alumniPhone, alumniFaculty, alumniResume, created_at, updated_at) VALUES
('Dr. Jane Patel', 'jane.patel@example.com', '1234567890', 'Computer Science', NULL, NOW(), NOW()),
('Mark Stevens', 'mark.stevens@example.com', '1234567891', 'Cybersecurity', NULL, NOW(), NOW()),
('Rachel Carter', 'rachel.carter@example.com', '1234567892', 'Information Security', NULL, NOW(), NOW()),
('Laura Green', 'laura.green@example.com', '1234567893', 'Environmental Science', NULL, NOW(), NOW()),
('Mike Johnson', 'mike.johnson@example.com', '1234567894', 'Agriculture', NULL, NOW(), NOW()),
('Dr. Alice Lee', 'alice.lee@example.com', '1234567895', 'Computer Science', NULL, NOW(), NOW()),
('Kevin Moore', 'kevin.moore@example.com', '1234567896', 'Computer Science', NULL, NOW(), NOW()),
('Sofia Turner', 'sofia.turner@example.com', '1234567897', 'Digital Arts', NULL, NOW(), NOW()),
('Jordan Smith', 'jordan.smith@example.com', '1234567898', 'Digital Media', NULL, NOW(), NOW()),
('Dr. Emily Wong', 'emily.wong@example.com', '1234567899', 'Medicine', NULL, NOW(), NOW()),
('Dr. Samuel King', 'samuel.king@example.com', '1234567800', 'Medicine', NULL, NOW(), NOW()),
('Nancy Adams', 'nancy.adams@example.com', '1234567801', 'Education Technology', NULL, NOW(), NOW()),
('Prof. John Miller', 'john.miller@example.com', '1234567802', 'Education', NULL, NOW(), NOW()),
('Dr. Alan Carter', 'alan.carter@example.com', '1234567803', 'Aerospace Engineering', NULL, NOW(), NOW()),
('Dr. Maria Lopez', 'maria.lopez@example.com', '1234567804', 'Satellite Technology', NULL, NOW(), NOW()),
('Adam Jones', 'adam.jones@example.com', '1234567805', 'Game Development', NULL, NOW(), NOW()),
('Emma Brown', 'emma.brown@example.com', '1234567806', 'Virtual Reality', NULL, NOW(), NOW()),
('Lisa Forbes', 'lisa.forbes@example.com', '1234567807', 'Entrepreneurship', NULL, NOW(), NOW()),
('Tim Watson', 'tim.watson@example.com', '1234567808', 'Business Leadership', NULL, NOW(), NOW());

-- LECTURERS TABLE
CREATE TABLE lecturers (
    lecturerID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    lecturerName VARCHAR(255) NOT NULL,
    lecturerPhone VARCHAR(255) NOT NULL,
    lecturerEmail VARCHAR(255) NOT NULL UNIQUE,
    lecturerFaculty VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- FORUMS TABLE
CREATE TABLE forums (
    forumID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    forumTitle VARCHAR(255) NOT NULL,
    forumDesc TEXT NOT NULL,
    organiser VARCHAR(255) NOT NULL,
    organiserID INT NOT NULL,
    Categories VARCHAR(255),
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

INSERT INTO forums (forumTitle, forumDesc, organiser, organiserID, Categories, created_at, updated_at) VALUES
('General Discussion', 'A place for general discussions about university life, campus events, and student activities.', 'Student Council', 1, 'General, Campus Life', NOW(), NOW()),
('Academic Support', 'Get help with your studies, share resources, and discuss academic challenges with peers and lecturers.', 'Academic Department', 2, 'Academic, Support', NOW(), NOW()),
('Career Development', 'Discuss career opportunities, internships, and professional development with alumni and career advisors.', 'Career Services', 3, 'Career, Professional Development', NOW(), NOW()),
('Student Clubs & Activities', 'Connect with various student clubs, discuss upcoming events, and share your interests with like-minded students.', 'Student Activities Office', 4, 'Clubs, Activities, Events', NOW(), NOW()),
('Technology & Innovation', 'Share ideas about technology, discuss innovations, and collaborate on tech projects with fellow students.', 'Computer Science Department', 5, 'Technology, Innovation, Projects', NOW(), NOW());

-- EVENTS TABLE
CREATE TABLE events (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    eventName VARCHAR(255) NOT NULL,
    eventDesc TEXT NOT NULL,
    eventDate DATE NOT NULL,
    eventTime TIME NOT NULL,
    eventVenue VARCHAR(255) NOT NULL,
    capacity INT,
    organiser VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

INSERT INTO events (eventName, eventDesc, eventDate, eventTime, eventVenue, capacity, organiser, created_at, updated_at) VALUES
('Orientation Week', 'This event marks the beginning of your exciting journey at the university. Designed to help new students transition smoothly into campus life, the day is filled with engaging activities. Begin with an inspiring welcome speech from our principal, followed by a detailed campus tour where you\'ll discover all the essential spots like lecture halls, the library, and recreation areas. Participate in interactive ice-breaker games led by student mentors, and enjoy performances from various student clubs showcasing the diverse opportunities you can explore. This is your chance to learn, connect, and make your first steps on campus memorable.', '2025-08-05', '09:00:00', 'Main Auditorium', 0, 'Student Council', NOW(), NOW()),
('Tech Talk: Future of Robotics', 'Robotics is transforming industries and redefining the future of work. Join us for an insightful session where experts from academia and the tech industry will delve into the latest advancements in robotics. Discover how automation, AI, and machine learning are revolutionising healthcare, manufacturing, and education. You\'ll also have the opportunity to interact with cutting-edge robotic models in live demonstrations. Whether you\'re a tech enthusiast or someone exploring career possibilities, this talk will provide valuable knowledge and inspiration.', '2025-08-05', '14:00:00', 'Engineering Block Seminar Hall', 150, 'Engineering Society', NOW(), NOW()),
('Shakespeare Reimagined', 'Prepare to be mesmerised as the Drama Club breathes new life into Shakespeare', '2025-08-15', '18:00:00', 'Black Box Theatre', 100, 'Drama Club', NOW(), NOW()),
('Hackathon 2025', 'Gear up for hours of non-stop innovation and creativity at Hackathon 2025', '2025-08-20', '10:00:00', 'IT Lab', 200, 'Computer Science Club', NOW(), NOW()),
('Green Campus Day', 'Join us in making our campus greener and more sustainable on Green Campus Day. This event features a series of activities including tree planting, recycling drives, and eco-friendly workshops. Engage with environmental experts during panel discussions and learn simple, effective ways to reduce your carbon footprint. Celebrate your efforts with a fun eco-marketplace offering organic products and food. Together, let\'s create a healthier environment for everyone and inspire a culture of sustainability on our campus.', '2025-08-20', '08:00:00', 'Campus Grounds', NULL, 'Environmental Society', NOW(), NOW()),
('Inter-College Debate Championship', 'Witness the finest minds from colleges across the region compete in the annual Inter-College Debate Championship. This intellectually stimulating event showcases the art of persuasive speaking, critical thinking, and teamwork. Each debate session will tackle relevant social, political, and economic topics, sparking lively discussions and diverse perspectives. The championship provides a platform for future leaders to shine and foster healthy competition. Be part of the audience and support your favourite team in this battle of words and wits.', '2025-09-12', '09:00:00', 'Conference Room A', 200, 'Debate Society', NOW(), NOW()),
('Battle of the Bands', 'Feel the rhythm and embrace the music as bands from all over compete in this year', '2025-09-25', '19:00:00', 'Open Air Theatre', 300, 'Music Club', NOW(), NOW()),
('Alumni Meet 2025', 'Reconnect, reminisce, and rejoice at Alumni Meet 2025. This annual gathering brings together alumni from various batches to celebrate shared memories and future aspirations. Relive your campus days with a host of nostalgic activities, including a tour of newly developed campus facilities, networking sessions, and an interactive dinner gala. Hear inspiring success stories from alumni speakers and strengthen your bonds with the university community. Let\'s make this year\'s meet an unforgettable experience!', '2025-10-03', '18:00:00', 'Alumni Hall', 200, 'Alumni Association', NOW(), NOW()),
('Annual Sports Day', 'Celebrate athleticism, teamwork, and school spirit at our Annual Sports Day. From exhilarating track and field events to thrilling team sports like football and basketball, the day promises excitement for everyone. Students, staff, and faculty are all invited to participate or cheer for their favourites. Enjoy live commentary, music, and refreshments throughout the event. Wrap up the day with an awards ceremony honouring outstanding performances. Come and be part of this vibrant and energetic campus tradition!', '2025-10-15', '07:00:00', 'Sports Ground', 0, 'Sports Committee', NOW(), NOW()),
('Orientation Event', 'Kickstart your university journey with our comprehensive orientation event! Meet your peers, explore the campus, and get all the information you need to succeed.', '2025-07-30', '08:30:00', 'Grand Hall', 500, 'Student Council', NOW(), NOW());

-- POSTS TABLE
CREATE TABLE posts (
    postID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    postTitle VARCHAR(255) NOT NULL,
    postDesc TEXT NOT NULL,
    comment TEXT,
    timestamp TIMESTAMP NOT NULL,
    forumID INT UNSIGNED NOT NULL,
    alumniID INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (forumID) REFERENCES forums(forumID) ON DELETE CASCADE,
    FOREIGN KEY (alumniID) REFERENCES alumni(alumniID) ON DELETE CASCADE
);

-- (INSERT INTO posts ... )
-- (Due to length, please see the next message for the full INSERT statements for posts)

-- ATTENDEES TABLE
CREATE TABLE attendees (
    attendeesID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    eventID INT UNSIGNED NOT NULL,
    alumniID INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (eventID) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (alumniID) REFERENCES alumni(alumniID) ON DELETE CASCADE
);

-- (Add sample data for attendees as needed) 