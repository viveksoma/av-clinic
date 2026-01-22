<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Main\Home'); // Set default controller
$routes->setDefaultMethod('index'); // Default method
$routes->get('/', 'Main\Home::index'); // Map '/' to Main/Home
$routes->get('/about', 'Main\About::index'); // Map '/' to Main/About
$routes->get('/service', 'Main\Service::index'); // Map '/' to Main/Service
$routes->get('/doctor', 'Main\Doctor::index'); // Map '/' to Main/Doctor
$routes->get('doctor/(:num)', 'Main\Doctor::view/$1');

$routes->get('/appointment', 'Main\Appointment::index'); // Map '/' to Main/Appointment
$routes->get('/contact', 'Main\Contact::index'); // Map '/' to Main/Appointment

// Public admin routes
$routes->get('/admin', 'Admin\Auth::login');
$routes->post('/auth/loginSubmit', 'Admin\Auth::loginSubmit');
$routes->get('/logout', 'Admin\Auth::logout');
$routes->get('google-auth', 'GoogleAuth::index');

// Protected admin routes
$routes->group('admin', ['filter' => 'adminauth'], function($routes) {

    $routes->get('dashboard', 'Admin\Dashboard');
    $routes->get('doctors', 'Admin\Doctors');
    $routes->post('doctors/store', 'Admin\Doctors::store');

    $routes->get('appointments', 'Admin\Appointments');
    $routes->get('appointments/generate-meet/(:num)', 'Admin\Appointments::generateMeet/$1');

    $routes->get('vaccines', 'Admin\Vaccines');
    $routes->get('patient_timeline', 'Admin\PatientTimeline');

    $routes->get('patient-vaccines', 'Admin\PatientVaccines::index');
    $routes->get('patient-vaccines/(:num)', 'Admin\PatientVaccines::show/$1');
    $routes->post('patient-vaccines/add', 'Admin\PatientVaccines::add');

    $routes->post('payments/update', 'Admin\Payments::update');

    $routes->get('doctor/availability/(:num)', 'Admin\DoctorAvailability::getAvailability/$1');
    $routes->post('doctor/availability/update', 'Admin\DoctorAvailability::updateAvailability');

    $routes->get('send-vaccine-reminders', 'VaccineReminderController::sendReminders');
});

$routes->get('appointments/getDoctorAvailableDays', 'Appointments::getDoctorAvailableDays');

//Appoinments
$routes->get('appointments/booking', 'Appointments::booking');
$routes->get('appointments/getSlots', 'Appointments::getSlots');
$routes->post('appointments/book', 'Appointments::book');
$routes->get('appointments/getBookedSlots', 'Appointments::getBookedSlots');
$routes->post('patients/checkPatient', 'Patients::createPatient');
$routes->get('patients/checkPatient', 'Patients::checkPatient');
$routes->get('patients/search', 'Patients::search');
$routes->get('/patients/(:num)/getPatientTimeline', 'Patients::getPatientTimeline/$1');
$routes->post('/patients/(:num)/addTimelineEntry', 'Patients::addTimelineEntry/$1');

