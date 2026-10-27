<?php 
namespace Controllers;
use MVC\Router;
use Model\AdminAppointment;

class AdminController {
    public static function index(Router $router) {
        session_start();

        isAdmin();

        $date = $_GET['date'] ?? date('Y-m-d');
        $dates = explode('-', $date);

        // Format check first: checkdate() throws a TypeError on non-numeric parts
        if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || !checkdate($dates[1], $dates[2], $dates[0])) {
            header('Location: 404');
            exit;
        }

        // Query the database
        $query = "SELECT appointments.id, appointments.time, concat(users.name, ' ', users.last_name) AS client, ";
        $query .= " users.email, users.phone_number, services.name as service, services.price ";
        $query .= " FROM appointments ";
        $query .= " LEFT JOIN users ";
        $query .= " ON appointments.userId=users.id ";
        $query .= " LEFT OUTER JOIN appointments_services ";
        $query .= " ON appointments_services.appointmentId = appointments.id ";
        $query .= " LEFT OUTER JOIN services ";
        $query .= " ON services.id=appointments_services.serviceId ";
        $query .= " WHERE date = ?";

        $appointments = AdminAppointment::SQL($query, [$date]);

        
        $router->render('admin/index', [
            'name' => $_SESSION['name'],
            'appointments' => $appointments,
            'date' => $date
        ]);
    }
}