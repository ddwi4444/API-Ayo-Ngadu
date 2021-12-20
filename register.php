<?php
require_once 'conn.php';

if ($conn) {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $encPassword = md5($password);

        $insert = "INSERT INTO users(name, email, password) 
                        VALUES('$name', '$email', '$encPassword')";
        $result = mysqli_query($conn, $insert);
        $response = array();

        if ($result) {
            $response['status'] = 'ok';
            $response['message'] = 'successfully registered';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'failed to register: ' . mysqli_error($conn);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'all field must be filled';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'failed to register';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
mysqli_close($conn);
