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
$routes->get('/appointment', 'Main\Appointment::index'); // Map '/' to Main/Appointment
$routes->get('/contact', 'Main\Contact::index'); // Map '/' to Main/Appointment

