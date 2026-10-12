CREATE DATABASE IF NOT EXISTS pmpml_bus_pass;
USE pmpml_bus_pass;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `user_type` enum('student','passenger') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

CREATE TABLE `student_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `bonafide_document` varchar(255) NOT NULL,
  `light_bill` varchar(255) NOT NULL,
  `aadhar_card` varchar(255) NOT NULL,
  `fees_receipt` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `starting_date` date NOT NULL,
  `pass_duration` int(11) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `status` enum('Pending','Under Review','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `application_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `application_number` (`application_number`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `passenger_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `aadhar_card` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `starting_date` date NOT NULL,
  `status` enum('Pending','Under Review','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `application_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `application_number` (`application_number`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_number` varchar(50) NOT NULL,
  `bus_number` varchar(50) NOT NULL,
  `starting_point` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `major_stops` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `helpline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_number` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `office_address` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `routes` (`route_number`, `bus_number`, `starting_point`, `destination`, `major_stops`) VALUES
('43', 'MH12FC1234', 'Katraj', 'Nigdi', 'Swargate, Shivajinagar, Wakdewadi, Pimpri'),
('115', 'MH12FC5678', 'Pune Station', 'Hinjewadi Phase 3', 'Deccan, Kothrud, Chandani Chowk, Wakad');

INSERT INTO `helpline` (`contact_number`, `email`, `office_address`, `description`) VALUES
('020-24503355', 'complaints@pmpml.org', 'Swargate, Pune, Maharashtra 411037', 'PMPML Central Office Helpline for Passenger Queries and Complaints.');
