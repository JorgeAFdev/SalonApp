<?php 

namespace Controllers;

use Model\User;
use MVC\Router;
use Classes\Email;

class LoginController {
    public static function login(Router $router) {
        $alerts = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alerts = $auth->validateLogin();

            if(empty($alerts)) {
                // Checking if the user exists
                $user = User::where('email', $auth->email);
                
                if($user){
                    // Verify password
                    if($user->checkPasswordAndVerify($auth->password)) {
                        // Authenticate the user
                        if(!isset($_SESSION)) {
                            session_start();
                        }
                        

                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name . " " . $user->last_name;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        // Redirect
                        if($user->admin === "1") {
                            $_SESSION['admin'] = $user->admin ?? null;
                            header('Location: /admin');
                        } else {
                           header('Location: /appointment');
                        }
                    }
                } else {
                    User::setAlert('error', 'Invalid email or password');
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/login', [
            'alerts' => $alerts
        ]);
    }

    public static function logout(Router $router) {
        session_start();
        
        $_SESSION = [];
        
        header('Location: /');
    }

    public static function Forgotpassword(Router $router) {
        $alerts = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = New User($_POST);
            $alerts = $auth->validateEmail();

            if(empty($alerts)) {
                $user = User::where('email', $auth->email);
                
                if($user && $user->confirmed === "1") {
                    // Generate Token
                    $user->createToken();
                    $user->save();

                    // Send email
                    $email = new Email($user->name, $user->email, $user->token);
                    $email->sendInstructions();

                    // Alert
                    User::setAlert('success', 'Check your inbox');
                    } else {
                    User::setAlert('error', 'User does not exist or is not confirmed');
                    
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/forgot-password', [
            'alerts' => $alerts
        ]);
    }

    public static function Resetpassword(Router $router) {
        $alerts = [];
        $error = false;

        $token = s($_GET['token']);

        // Search for user by their token
        $user = User::where('token', $token);


        if(empty($user)) {
            User::setAlert('error', 'Invalid token');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Read the new password and save it
            $password = New User($_POST);
            $alerts = $password->validatePassword();

            if(empty($alerts)) {
                $user->password = null;

                $user->password = $password->password;
                $user->hashPassword();
                $user->token = null;

                $result = $user->save();
                if($result) {
                    header('Location: /');
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/reset-password', [
            'alerts' => $alerts,
            'error' => $error
        ]);
    }

    public static function createAccount(Router $router) {
        $user = new User(); 
        
        $alerts = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->synchronize($_POST); 
            $alerts = $user->validateNewAccount();

            if(empty($alerts)) {
                // Verify that the user is not registered
                $result = $user->userExists();

                if($result->num_rows) {
                    $alerts = User::getAlerts();
                } else { // User is not registered
                    // Hash the password
                    $user->hashPassword();
                    
                    // Generate Unique Token
                    $user->createToken();

                    // Send email
                    $email = New Email($user->name, $user->email, $user->token); 
                    $email->sendConfirmation();

                    // Create user
                    $result = $user->save();

                    if($result) {
                        header("Location: /message");
                    }
                    
                }
            }
        } 
        $router->render('auth/create-account', [
            'user' => $user,
            'alerts' => $alerts
        ]);
    }
    
    public static function message(Router $router) {

        $router->render('auth/message', [

        ]);
    }

    public static function confirmAccount(Router $router) {
        $alerts = [];
        $token = s($_GET['token']);
        $user = user::where('token', $token);
       
        if(empty($user)) {
            // Show error message
            User::setAlert('error', 'Invalid Token');
        } else {
            // Change to confirmed user
            $user->confirmed = "1";
            $user->token = null;
            $user->save();
            User::setAlert('success', 'Your account has been confirmed!');
        }
        // Get alerts
        $alerts = User::getAlerts();

        // Render the view
        $router->render('auth/confirm-account', [
            'alerts' => $alerts
        ]);
    }
}