<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\APIController;
use Controllers\AdminController;
use Controllers\LoginController;
use Controllers\ServiceController;
use Controllers\AppointmentController;

$router = new Router();

// Sign in
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);

// Log out 
$router->get('/logout', [LoginController::class, 'logout']);

// Recover Password
$router->get('/forgot-password', [LoginController::class, 'Forgotpassword']);
$router->post('/forgot-password', [LoginController::class, 'Forgotpassword']);
$router->get('/reset-password', [LoginController::class, 'Resetpassword']);
$router->post('/reset-password', [LoginController::class, 'Resetpassword']);

// Create Account
$router->get('/create-account', [LoginController::class, 'createAccount']);
$router->post('/create-account', [LoginController::class, 'createAccount']);

// Confirm Account
$router->get('/confirm-account', [LoginController::class, 'confirmAccount']);
$router->get('/message', [LoginController::class, 'message']);

// Private Area
$router->get('/appointment', [AppointmentController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

//  API Appointments
$router->get('/api/services', [APIController::class, 'index']);
$router->post('/api/appointments', [APIController::class, 'save']);
$router->post('/api/delete', [APIController::class, 'delete']);

// CRUD Services
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/create', [ServiceController::class, 'create']);
$router->post('/services/create', [ServiceController::class, 'create']);
$router->get('/services/update', [ServiceController::class, 'update']);
$router->post('/services/update', [ServiceController::class, 'update']);
$router->post('/services/delete', [ServiceController::class, 'delete']);

// Check and validate the routes
$router->checkRoutes();