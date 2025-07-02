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

// Admin routes
$routes->get('/admin', 'Admin\Auth::login'); // Map '/' to Admin/Login
$routes->post('/auth/loginSubmit', 'Admin\Auth::loginSubmit');
$routes->get('/logout', 'Admin\Auth::logout');
$routes->get('admin/dashboard', 'Admin\Dashboard');
$routes->get('admin/doctors', 'Admin\Doctors');
$routes->get('admin/appointments', 'Admin\Appointments');
$routes->get('admin/vaccines', 'Admin\Vaccines');
$routes->group('admin', function($routes) {
    $routes->get('patient-vaccines', 'Admin\PatientVaccines::index');
    $routes->get('patient-vaccines/(:num)', 'Admin\PatientVaccines::show/$1');
    $routes->post('patient-vaccines/add', 'Admin\PatientVaccines::add');
});
$routes->get('/admin/send-vaccine-reminders', 'VaccineReminderController::sendReminders');
$routes->get('admin/patient_timeline', 'Admin\PatientTimeline');
$routes->post('/doctors/store', 'Admin\Doctors::store');
$routes->post('admin/payments/update', 'Admin\Payments::update');
$routes->get('admin/appointments/generate-meet/(:num)', 'Admin\Appointments::generateMeet/$1');
$routes->get('google-auth', 'GoogleAuth::index');
$routes->get('admin/doctor/availability/(:num)', 'Admin\DoctorAvailability::getAvailability/$1');
$routes->post('admin/doctor/availability/update', 'Admin\DoctorAvailability::updateAvailability');
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

