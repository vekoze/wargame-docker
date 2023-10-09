-- Populate Roles table
INSERT INTO Roles (id, name) VALUES
(0, 'Default'),
(1, 'Admin'),
(2, 'SuperAdmin');

-- Populate Users table
INSERT INTO Users (username, email, password, id_Role) VALUES
('Adrien', 'adrien@example.com', '2522f7c9c098302a41f4e8b2bd821d94', 0),           -- MD5("Adrien")
('Loic', 'loic@example.com', '8f29d46f8d31021b2f56763e8346db25', 0),               -- MD5("Loic")
('Victor', 'victor@example.com', '82233bce59652cf3cc0eb7a03f3109d1', 0),           -- MD5("Victor")
('d3vel0per', 'd3vel0per@example.com', '38c16985eb235f1583cfae53ea1ac7c9', 0),     -- MD5("d3vel0per")
('admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 1),               -- MD5("admin")
('sup3r4dm1n', 'sup3r4dm1n@example.com', 'f93fc10472a31bb3061aa0b45e228c5a', 2);   -- MD5("strongpassword")

-- Populate Destinations table
INSERT INTO Destinations (title, description) VALUES
('Paris', 'The romantic city of France'),
('New York', 'The city that never sleeps'),
('Tokyo', 'The vibrant capital of Japan'),
('London', 'The historic capital of the United Kingdom'),
('Sydney', 'A beautiful city on the east coast of Australia'),
('Cape Town', 'A stunning coastal city at the southern tip of South Africa');



-- Populate Reviews table
-- Assuming that each user comments on each destination
INSERT INTO Reviews (comment, rating, id_User, id_Destination) VALUES
('I loved Paris!', 5, 1, 1),
('Eiffel tower is overrated', 3, 2, 1),
('Paris is always a good idea', 5, 3, 1),
('New York is bustling!', 4, 1, 2),
('Central park was peaceful', 5, 2, 2),
('NY is too crowded', 2, 3, 2),
('Tokyo has amazing sushi', 5, 1, 3),
('Too many people in Tokyo', 3, 2, 3),
('I loved the temples', 5, 3, 3);

-- Populate Images table
-- Assuming that each destination has multiple images
INSERT INTO Images (path, id_Destination) VALUES
('img/destination/paris1.jpg', 1),
('img/destination/paris2.jpg', 1),
('img/destination/paris3.jpg', 1),
('img/destination/ny1.jpg', 2),
('img/destination/ny2.jpg', 2),
('img/destination/tokyo1.jpg', 3),
('img/destination/tokyo2.jpg', 3);

INSERT INTO SneakyTable (name) VALUES
('flag{Sh0uldv3_L1st3ned_ToM0m_NoR4wInPuts}');