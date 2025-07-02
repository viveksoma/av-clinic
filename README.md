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

CREATE TABLE doctor_special_availabilities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT UNSIGNED NOT NULL,
    available_date DATE NOT NULL,
    morning_start TIME NULL,
    morning_end TIME NULL,
    evening_start TIME NULL,
    evening_end TIME NULL,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE ON UPDATE CASCADE
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
    name VARCHAR(100),
    description TEXT,
    due_weeks INT COMMENT 'Weeks after birth'
);

CREATE TABLE patient_vaccines (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    patient_id INT UNSIGNED NOT NULL,
    vaccine_name VARCHAR(100) NOT NULL,
    dose_number TINYINT UNSIGNED NOT NULL,
    vaccination_date DATE NOT NULL,
    created_at DATETIME DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    PRIMARY KEY (id),
    KEY patient_id_idx (patient_id),
    CONSTRAINT patient_vaccines_ibfk_1 FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE patient_vaccines
ADD vaccine_id INT,
ADD CONSTRAINT fk_vaccine FOREIGN KEY (vaccine_id) REFERENCES vaccines(id);

-- Then remove vaccine_name if not needed



INSERT INTO vaccines (name, description, due_weeks) VALUES
-- At Birth
('BCG', 'Bacillus Calmette–Guérin (TB)', 0),
('OPV-0', 'Oral Polio Vaccine – Birth dose', 0),
('Hepatitis B-1', 'Hepatitis B – Birth dose', 0),

-- 6 Weeks
('DTP-1', 'Diphtheria, Tetanus, Pertussis – 1st dose', 6),
('Hib-1', 'Haemophilus influenzae type b – 1st dose', 6),
('IPV-1', 'Inactivated Polio Vaccine – 1st dose', 6),
('Hepatitis B-2', 'Hepatitis B – 2nd dose', 6),
('Rotavirus-1', 'Rotavirus – 1st dose', 6),
('PCV-1', 'Pneumococcal Conjugate Vaccine – 1st dose', 6),

-- 10 Weeks
('DTP-2', 'Diphtheria, Tetanus, Pertussis – 2nd dose', 10),
('Hib-2', 'Haemophilus influenzae type b – 2nd dose', 10),
('IPV-2', 'Inactivated Polio Vaccine – 2nd dose', 10),
('Rotavirus-2', 'Rotavirus – 2nd dose', 10),
('PCV-2', 'Pneumococcal Conjugate Vaccine – 2nd dose', 10),

-- 14 Weeks
('DTP-3', 'Diphtheria, Tetanus, Pertussis – 3rd dose', 14),
('Hib-3', 'Haemophilus influenzae type b – 3rd dose', 14),
('IPV-3', 'Inactivated Polio Vaccine – 3rd dose', 14),
('Rotavirus-3', 'Rotavirus – 3rd dose', 14),
('PCV-3', 'Pneumococcal Conjugate Vaccine – 3rd dose', 14),

-- 6 Months
('Hepatitis B-3', 'Hepatitis B – 3rd dose', 24),

-- 9 Months
('MMR-1', 'Measles, Mumps, Rubella – 1st dose', 39),
('Vitamin A-1', 'Vitamin A – 1st dose', 39),

-- 12 Months
('Typhoid Conjugate', 'Typhoid Conjugate Vaccine', 52),

-- 15 Months
('MMR-2', 'Measles, Mumps, Rubella – 2nd dose', 65),
('Varicella-1', 'Chickenpox – 1st dose', 65),
('PCV Booster', 'Pneumococcal Conjugate Vaccine – Booster', 65),

-- 18 Months
('DTP Booster-1', 'Diphtheria, Tetanus, Pertussis – 1st booster', 78),
('Hib Booster', 'Haemophilus influenzae type b – Booster', 78),
('IPV Booster', 'Inactivated Polio Vaccine – Booster', 78),
('Hepatitis A-1', 'Hepatitis A – 1st dose', 78),

-- 2 Years
('Typhoid Booster', 'Typhoid Booster (if needed)', 104),

-- 4-6 Years
('DTP Booster-2', 'Diphtheria, Tetanus, Pertussis – 2nd booster', 208),
('OPV Booster', 'Oral Polio Vaccine – Booster', 208),
('MMR-3', 'Measles, Mumps, Rubella – 3rd dose', 208),
('Varicella-2', 'Chickenpox – 2nd dose', 208),
('Hepatitis A-2', 'Hepatitis A – 2nd dose', 208);
