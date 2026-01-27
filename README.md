# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

CREATE TABLE doctor_availabilities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT UNSIGNED NOT NULL,
    day_of_week ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
    morning_start TIME NULL,
    morning_end TIME NULL,
    evening_start TIME NULL,
    evening_end TIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

ALTER TABLE doctors
ADD COLUMN qualifications VARCHAR(255) AFTER name,
ADD COLUMN about TEXT AFTER qualifications,
ADD COLUMN social_links JSON AFTER about;

ALTER TABLE appointments
ADD COLUMN appointment_type VARCHAR(50) AFTER status;

ALTER TABLE patients ADD COLUMN email VARCHAR(255);

ALTER TABLE doctors ADD COLUMN email VARCHAR(255);

ALTER TABLE appointments
ADD COLUMN appointment_type VARCHAR(50) AFTER status;

ALTER TABLE appointments ADD google_meet_link TEXT AFTER appointment_type;

CREATE TABLE `payments` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `appointment_id` INT UNSIGNED NOT NULL,
  `payment_amount` DECIMAL(10,2) NOT NULL,
  `payment_mode` ENUM('upi', 'bank_transfer') NOT NULL,
  `payment_status` ENUM('pending', 'received', 'failed') DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `payments_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE vaccines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,          -- e.g. "BCG"
    full_name VARCHAR(255) NULL,         -- e.g. "Bacillus Calmette–Guérin"
    notes VARCHAR(255) NULL              -- e.g. "Influenza yearly"
);

INSERT INTO vaccines (id, name, full_name, notes) VALUES
(1, 'BCG', NULL, NULL),
(2, 'OPV', NULL, NULL),
(3, 'Hep B', NULL, NULL),
(4, 'DTwP', NULL, NULL),
(5, 'DTaP', NULL, NULL),
(6, 'Hib', NULL, NULL),
(7, 'PCV', NULL, NULL),
(8, 'IPV', NULL, NULL),
(9, 'Rota', NULL, NULL),
(10, 'Influenza', NULL, NULL),
(11, 'Typhoid Conjugate', NULL, NULL),
(12, 'MMR', NULL, NULL),
(13, 'Varicella', NULL, NULL),
(14, 'Hep A', NULL, NULL),
(15, 'HPV', NULL, NULL),
(16, 'Tdap', NULL, NULL);


CREATE TABLE vaccination_stages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stage_label VARCHAR(50),      -- e.g. "At Birth", "6 Weeks"
    age_in_days INT NULL,         -- optional, useful for reminders
    display_order INT NOT NULL
);

TRUNCATE TABLE vaccination_stages;

INSERT INTO vaccination_stages (stage_label, display_order) VALUES
('At Birth', 1),
('6 Weeks', 2),
('10 Weeks', 3),
('14 Weeks', 4),
('6 Months', 5),
('7 Months', 6),          -- ✅ NEW
('9 Months', 7),
('1 Year', 8),
('15 Months', 9),
('18 Months', 10),
('2 Years', 11),
('3 Years', 12),
('4 Years', 13),
('5 Years', 14),
('9-14 Years', 15);


CREATE TABLE stage_vaccines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vaccination_stage_id INT NOT NULL,
    vaccine_id INT NOT NULL,
    dose_label VARCHAR(20),     -- e.g. "1", "2", "B1", "Booster"
    display_order INT NOT NULL,

    FOREIGN KEY (vaccination_stage_id) REFERENCES vaccination_stages(id),
    FOREIGN KEY (vaccine_id) REFERENCES vaccines(id)
);

TRUNCATE TABLE stage_vaccines;

INSERT INTO stage_vaccines
(vaccination_stage_id, vaccine_id, dose_label, display_order)
VALUES

-- At Birth
(1, 1, NULL, 1),
(1, 2, NULL, 2),
(1, 3, '1', 3),

-- 6 Weeks
(2, 4, '1', 1),
(2, 5, '1', 2),
(2, 6, '1', 3),
(2, 3, '2', 4),
(2, 7, '1', 5),
(2, 8, '1', 6),
(2, 9, '1', 7),

-- 10 Weeks
(3, 4, '2', 1),
(3, 5, '2', 2),
(3, 6, '2', 3),
(3, 3, '3', 4),
(3, 7, '2', 5),
(3, 8, '2', 6),
(3, 9, '2', 7),

-- 14 Weeks
(4, 4, '3', 1),
(4, 5, '3', 2),
(4, 6, '3', 3),
(4, 3, '4', 4),
(4, 7, '3', 5),
(4, 8, '3', 6),
(4, 9, '3', 7),

-- 6 Months
(5, 10, '1', 1),            -- Influenza dose-1
(5, 11, NULL, 2),            -- Typhoid Conjugate

-- 7 Months (NEW – Influenza dose-2)
(6, 10, '2', 1),

-- 9 Months
(7, 12, '1', 1),
-- 1 Year
(8, 14, NULL, 1),

-- 15 Months
(9, 12, '2', 1),
(9, 13, '1', 2),
(9, 7, 'Booster', 3),

-- 18 Months
(10, 4, 'B1', 1),
(10, 5, 'B1', 2),
(10, 8, 'B1', 3),
(10, 6, 'B1', 4),
(10, 14, '2', 5),
(10, 13, '2', 6),

-- 2 Years
(11, 10, NULL, 1),

-- 3 Years
(12, 10, NULL, 1),

-- 4 Years
(13, 10, NULL, 1),

-- 5 Years
(14, 4, 'B2', 1),
(14, 5, 'B2', 2),
(14, 8, 'B2', 3),
(14, 12, '3', 4),
(14, 10, NULL, 5),

-- 9–14 Years
(15, 16, NULL, 1),
(15, 15, '1', 2),
(15, 15, '2', 3);


DROP TABLE IF EXISTS patient_vaccines;

CREATE TABLE patient_vaccines (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    patient_id INT UNSIGNED NOT NULL,
    stage_vaccine_id INT NOT NULL,

    given_date DATE DEFAULT NULL,
    status ENUM('pending','given','missed') DEFAULT 'pending',
    remarks VARCHAR(255),

    CONSTRAINT fk_patient
        FOREIGN KEY (patient_id)
        REFERENCES patients(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_stage_vaccine
        FOREIGN KEY (stage_vaccine_id)
        REFERENCES stage_vaccines(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

ALTER TABLE patients
ADD COLUMN dob DATE NULL AFTER phone;

CREATE TABLE vaccine_reminder_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    stage_vaccine_id INT NOT NULL,
    reminder_type ENUM('7_days','3_days','same_day') NOT NULL,
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_reminder (patient_id, stage_vaccine_id, reminder_type)
);
ALTER TABLE patients MODIFY age INT NULL;
ALTER TABLE patients
ADD COLUMN guardian_name VARCHAR(100) NULL AFTER name,
ADD COLUMN guardian_relation VARCHAR(50) NULL AFTER guardian_name;

ALTER TABLE patients DROP INDEX phone;

UPDATE vaccination_stages
SET age_in_days = CASE stage_label
    WHEN 'At Birth'    THEN 0
    WHEN '6 Weeks'     THEN 42
    WHEN '10 Weeks'    THEN 70
    WHEN '14 Weeks'    THEN 98
    WHEN '6 Months'    THEN 180
    WHEN '7 Months'    THEN 210
    WHEN '9 Months'    THEN 270
    WHEN '1 Year'      THEN 365
    WHEN '15 Months'   THEN 450
    WHEN '18 Months'   THEN 540
    WHEN '2 Years'     THEN 730
    WHEN '3 Years'     THEN 1095
    WHEN '4 Years'     THEN 1460
    WHEN '5 Years'     THEN 1825
    WHEN '9-14 Years'  THEN 3650
END;

ALTER TABLE admins
ADD created_at DATETIME NULL DEFAULT NULL,
ADD updated_at DATETIME NULL DEFAULT NULL;


curl -s http://avmultispeciality.com/send-vaccine-reminders
