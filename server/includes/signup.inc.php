<?php
    cors();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $registerFormDataJson = file_get_contents('php://input'); // Returns data from the request body
        $registerFormDataArray = json_decode($registerFormDataJson, true);
        $username = $registerFormDataArray['username'];
        $email = $registerFormDataArray['email'];
        $password = $registerFormDataArray['password'];
        $password2 = $registerFormDataArray['password2'];

        include '../classes/dbh.class.php';
        include '../classes/signup.class.php';
        include '../classes/signup-controller.class.php';
        $signup = new SignUpController($username, $email, $password, $password2);

        $signup->signUpUser();

        $hostUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER[HTTP_HOST]}";
        header('location: '. $hostUrl . '?error=none');
    }   

/**
 *  An example CORS-compliant method.  It will allow any GET, POST, or OPTIONS requests from any
 *  origin.
 *
 *  In a production environment, you probably want to be more restrictive, but this gives you
 *  the general idea of what is involved.  For the nitty-gritty low-down, read:
 *
 *  - https://developer.mozilla.org/en/HTTP_access_control
 *  - https://fetch.spec.whatwg.org/#http-cors-protocol
 *
 */
function cors() {
    
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
    
    echo "You have CORS!";
}