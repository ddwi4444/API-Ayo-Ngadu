<?php
require_once 'conn.php';

if ($conn) {

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $encPassword = md5($password);

        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$encPassword'";

        $result = mysqli_query($conn, $query);
        $response = array();

        if ($result) {
            $data = $result->fetch_assoc();

            $response['status'] = 'ok';
            $response['message'] = 'successfully logged in';
            $response['data'] = [
                'id' => intval($data['id']),
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ];
        } else {
            $response['status'] = 'error';
            $response['message'] = 'failed to register: ' . mysqli_error($conn);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'email and password must not be empty';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'failed to register';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
mysqli_close($conn);
