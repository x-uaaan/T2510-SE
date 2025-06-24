-- Campus Pulse Database Schema and Sample Data (MySQL)
-- ------------------------------------------------------
-- This file creates the main tables and inserts sample data for the Campus Pulse alumni management system.
-- Entities: users, admins, alumni, lecturers, forums, posts, events, attendees

DROP DATABASE IF EXISTS `CampusPulse`;
CREATE DATABASE `CampusPulse`;
USE `CampusPulse`;

-- USERS TABLE
CREATE TABLE campuspulse.users (
    userID VARCHAR(255) NOT NULL PRIMARY KEY,
    username VARCHAR(255), -- Will be populated from Microsoft name (allows duplicates)
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(255),
    faculty VARCHAR(255),
    resume VARCHAR(255), -- Path to PDF resume file (optional)
    -- Adding a discriminator column to differentiate user types
    userType ENUM('Alumni', 'Lecturer', 'Admin') NOT NULL,
    microsoft_id VARCHAR(255) UNIQUE,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

INSERT INTO campuspulse.users (userID, username, email, phone, faculty, userType, microsoft_id, created_at, updated_at) VALUES
('usr_001', 'Dr. Jane Patel', 'jane.patel@example.com', '1234567890', 'Computer Science', 'Alumni', 'msft_id_001', NOW(), NOW()),
('usr_002', 'Mark Stevens', 'mark.stevens@example.com', '1234567891', 'Cybersecurity', 'Alumni', 'msft_id_002', NOW(), NOW()),
('usr_003', 'Prof. John Miller', 'john.miller@example.com', '1234567802', 'Education', 'Lecturer', 'msft_id_003', NOW(), NOW()),
('usr_004', 'Dr. Maria Lopez', 'maria.lopez@example.com', '1234567804', 'Satellite Technology', 'Lecturer', 'msft_id_004', NOW(), NOW()),
('usr_005', 'Kevin Moore', 'kevin.moore@example.com', '1234567896', 'Computer Science', 'Alumni', 'msft_id_005', NOW(), NOW()),
('usr_006', 'Sofia Turner', 'sofia.turner@example.com', '1234567897', 'Digital Arts', 'Alumni', 'msft_id_006', NOW(), NOW()),
('usr_007', 'Dr. Emily Wong', 'emily.wong@example.com', '1234567899', 'Medicine', 'Alumni', 'msft_id_007', NOW(), NOW()),
('usr_008', 'Admin User', 'admin@example.com', '1234567000', 'Administration', 'Admin', 'msft_id_008', NOW(), NOW());

CREATE TABLE campuspulse.events (
    id VARCHAR(255) NOT NULL PRIMARY KEY, -- ID as VARCHAR(255)
    eventName VARCHAR(255) NOT NULL,
    eventDesc TEXT NOT NULL,
    startDate DATE NOT NULL,
    startTime TIME NOT NULL,
    endDate DATE,            -- End date of the event (optional)
    endTime TIME,            -- End time of the event (optional)
    eventVenue VARCHAR(255) NOT NULL,
    capacity INT,
    organiserName varchar(255) not null,
    organiserID VARCHAR(255) NOT NULL, -- Foreign key to users.id
    image VARCHAR(255),
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (organiserID) REFERENCES users(userID) ON DELETE RESTRICT ON UPDATE CASCADE -- Restrict deletion of user if they organised an event
);

INSERT INTO campuspulse.events (eventID, eventName, eventDesc, startDate, startTime, endDate, endTime, eventVenue, capacity, organiserName, organiserID, created_at, updated_at) VALUES
('evt_001', 'Orientation Week', 'This event marks the beginning of your exciting journey at the university. Designed to help new students transition smoothly into campus life, the day is filled with engaging activities. Begin with an inspiring welcome speech from our principal, followed by a detailed campus tour where you\'ll discover all the essential spots like lecture halls, the library, and recreation areas. Participate in interactive ice-breaker games led by student mentors, and enjoy performances from various student clubs showcasing the diverse opportunities you can explore. This is your chance to learn, connect, and make your first steps on campus memorable.', '2025-08-05', '09:00:00', '2025-08-05', '17:00:00', 'Main Auditorium', 0, 'Dr. Jane Patel','usr_001', NOW(), NOW()), -- Organiser: Dr. Jane Patel (Alumni)
('evt_002', 'Tech Talk: Future of Robotics', 'Robotics is transforming industries and redefining the future of work. Join us for an insightful session where experts from academia and the tech industry will delve into the latest advancements in robotics. Discover how automation, AI, and machine learning are revolutionising healthcare, manufacturing, and education. You\'ll also have the opportunity to interact with cutting-edge robotic models in live demonstrations. Whether you\'re a tech enthusiast or someone exploring career possibilities, this talk will provide valuable knowledge and inspiration.', '2025-08-05', '14:00:00', '2025-08-05', '16:00:00', 'Engineering Block Seminar Hall', 150, 'Prof. John Miller', 'usr_003', NOW(), NOW()), -- Organiser: Prof. John Miller (Lecturer)
('evt_003', 'Shakespeare Reimagined', 'Prepare to be mesmerised as the Drama Club breathes new life into Shakespeare', '2025-08-15', '18:00:00', '2025-08-15', '20:30:00', 'Black Box Theatre', 100, 'Mark Stevens','usr_002', NOW(), NOW()), -- Organiser: Mark Stevens (Alumni)
('evt_004', 'Hackathon 2025', 'Gear up for hours of non-stop innovation and creativity at Hackathon 2025', '2025-08-20', '10:00:00', '2025-08-21', '17:00:00', 'IT Lab', 200, 'Dr. Maria Lopez', 'usr_004', NOW(), NOW()), -- Organiser: Dr. Maria Lopez (Lecturer)
('evt_005', 'Green Campus Day', 'Join us in making our campus greener and more sustainable on Green Campus Day. This event features a series of activities including tree planting, recycling drives, and eco-friendly workshops. Engage with environmental experts during panel discussions and learn simple, effective ways to reduce your carbon footprint. Celebrate your efforts with a fun eco-marketplace offering organic products and food. Together, let\'s create a healthier environment for everyone and inspire a culture of sustainability on our campus.', '2025-08-20', '08:00:00', '2025-08-20', '16:00:00', 'Campus Grounds', NULL, 'Dr. Jane Patel', 'usr_001', NOW(), NOW()), -- Organiser: Dr. Jane Patel (Alumni)
('evt_006', 'Inter-College Debate Championship', 'Witness the finest minds from colleges across the region compete in the annual Inter-College Debate Championship. This intellectually stimulating event showcases the art of persuasive speaking, critical thinking, and teamwork. Each debate session will tackle relevant social, political, and economic topics, sparking lively discussions and diverse perspectives. The championship provides a platform for future leaders to shine and foster healthy competition. Be part of the audience and support your favourite team in this battle of words and wits.', '2025-09-12', '09:00:00', '2025-09-12', '17:00:00', 'Conference Room A', 200, 'Prof. John Miller', 'usr_003', NOW(), NOW()); -- Organiser: Prof. John Miller (Lecturer)

CREATE TABLE campuspulse.forums (
    forumID VARCHAR(255) NOT NULL PRIMARY KEY, -- ID as VARCHAR(255)
    forumTitle VARCHAR(255) NOT NULL,
    forumDesc TEXT NOT NULL,
    organiserName varchar(255) not null,
    organiserID VARCHAR(255) NOT NULL, -- Foreign key to users.id
    Categories VARCHAR(255),
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (organiserID) REFERENCES users(userID) ON DELETE RESTRICT ON UPDATE CASCADE -- Restrict deletion of user if they organised a forum
);

INSERT INTO campuspulse.forums (forumID, forumTitle, forumDesc, organiserName, organiserID, Categories, created_at, updated_at) VALUES
('frm_001', 'General Discussion', 'A place for general discussions about university life, campus events, and student activities.', 'Dr. Jane Patel', 'usr_001', 'General, Campus Life', NOW(), NOW()), -- Organised by Dr. Jane Patel (Alumni)
('frm_002', 'Academic Support', 'Get help with your studies, share resources, and discuss academic challenges with peers and lecturers.', 'Prof. John Miller', 'usr_003', 'Academic, Support', NOW(), NOW()), -- Organised by Prof. John Miller (Lecturer)
('frm_003', 'Career Development', 'Discuss career opportunities, internships, and professional development with alumni and career advisors.', 'Mark Stevens', 'usr_002', 'Career, Professional Development', NOW(), NOW()), -- Organised by Mark Stevens (Alumni)
('frm_004', 'Student Clubs & Activities', 'Connect with various student clubs, discuss upcoming events, and share your interests with like-minded students.', 'Dr. Jane Patel', 'usr_001', 'Clubs, Activities, Events', NOW(), NOW()), -- Organised by Dr. Jane Patel (Alumni)
('frm_005', 'Technology & Innovation', 'Share ideas about technology, discuss innovations, and collaborate on tech projects with fellow students.', 'Dr. Maria Lopez', 'usr_004', 'Technology, Innovation, Projects', NOW(), NOW()); -- Organised by Dr. Maria Lopez (Lecturer)

CREATE TABLE campuspulse.posts (
    postID VARCHAR(255) NOT NULL PRIMARY KEY, -- ID as VARCHAR(255)
    postTitle VARCHAR(255) NOT NULL,
    postDesc TEXT NOT NULL,
    comment TEXT,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Default to current timestamp
    forumID VARCHAR(255) NOT NULL, -- Foreign key to forums.forumID
    userID VARCHAR(255) NOT NULL, -- Foreign key to users.id
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (forumID) REFERENCES forums(forumID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE ON UPDATE CASCADE -- Cascade deletion if user is removed
);

INSERT INTO campuspulse.posts (postID, postTitle, postDesc, comment, forumID, userID, created_at, updated_at) VALUES
('pst_001', 'Welcome to Campus Pulse!', 'Hello everyone! This is the first post in our general discussion forum. Feel free to introduce yourselves and share your thoughts.', NULL, 'frm_001', 'usr_001', NOW(), NOW()), -- Posted by Dr. Jane Patel
('pst_002', 'Study Tips for Exams', 'Looking for effective study strategies for upcoming exams. Any advice?', NULL, 'frm_002', 'usr_001', NOW(), NOW()), -- Posted by Dr. Jane Patel
('pst_003', 'Internship Opportunities', 'Our company is offering summer internships for computer science students. Check out the details!', NULL, 'frm_003', 'usr_002', NOW(), NOW()), -- Posted by Mark Stevens
('pst_004', 'New Robotics Club Meeting', 'The Robotics Club will have its first meeting of the semester next Tuesday. All are welcome!', NULL, 'frm_005', 'usr_004', NOW(), NOW()), -- Posted by Dr. Maria Lopez
('pst_005', 'Call for Volunteers: Green Campus Day', 'We need volunteers for the upcoming Green Campus Day event. Join us!', NULL, 'frm_001', 'usr_005', NOW(), NOW()), -- Posted by Kevin Moore
('pst_006', 'Question about Thesis Writing', 'I am starting my thesis and feeling a bit overwhelmed. Any lecturers or alumni willing to share tips?', NULL, 'frm_002', 'usr_005', NOW(), NOW()), -- Posted by Kevin Moore
('pst_007', 'Graphic Design Workshop', 'Looking for a workshop on graphic design software. Any recommendations or upcoming events?', NULL, 'frm_005', 'usr_006', NOW(), NOW()), -- Posted by Sofia Turner
('pst_008', 'Medical Career Pathways', 'As a medical alumni, I\'d like to share insights on various career pathways in medicine.', NULL, 'frm_003', 'usr_007', NOW(), NOW()); -- Posted by Dr. Emily Wong

CREATE TABLE campuspulse.attendees (
    attendeesID VARCHAR(255) NOT NULL PRIMARY KEY, -- ID as VARCHAR(255)
    eventID VARCHAR(255) NOT NULL, -- Foreign key to events.id
    userID VARCHAR(255) NOT NULL, -- Foreign key to users.id
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (eventID) REFERENCES events(eventID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (userID) REFERENCES users(userID) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO campuspulse.attendees (attendeesID, eventID, userID, created_at, updated_at) VALUES
('att_001', 'evt_001', 'usr_001', NOW(), NOW()), -- Dr. Jane Patel attending Orientation Week
('att_002', 'evt_001', 'usr_002', NOW(), NOW()), -- Mark Stevens attending Orientation Week
('att_003', 'evt_002', 'usr_001', NOW(), NOW()), -- Dr. Jane Patel attending Tech Talk
('att_004', 'evt_002', 'usr_005', NOW(), NOW()), -- Kevin Moore attending Tech Talk
('att_005', 'evt_005', 'usr_006', NOW(), NOW()), -- Sofia Turner attending Green Campus Day
('att_006', 'evt_003', 'usr_007', NOW(), NOW()); -- Dr. Emily Wong attending Shakespeare Reimagined