<?php 
namespace Controllers;

use Model\Service;
use Model\Appointment;
use Model\AppointmentService;

class APIController {
    public static function index() {

        $services = Service::all();
        echo json_encode($services);
    }

    public static function save() {
        session_start();
        isAuth();

        // Store the appointment and return the ID
        $appointment = new Appointment($_POST);
        // The client sends userId, but only the session decides whose appointment it is.
        $appointment->userId = $_SESSION['id'];
        $result = $appointment->save();

        $id = $result['id'];
        
        // Store the appointment and the service with the appointment's ID
        $idServices = explode(",", $_POST['services']); 
        foreach($idServices as $idService) {
            $args = [
                'appointmentId' => $id,
                'serviceId' => $idService
            ];
            $appointmentService = new AppointmentService($args);
            $appointmentService->save();
        }

        echo json_encode(['result' => $result]);
    }

    public static function delete() {
        session_start();
        isAdmin();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $appointment = Appointment::find($id);
            $appointment->delete();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}