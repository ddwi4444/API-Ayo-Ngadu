<?php
require_once '../conn.php';

$response = array();

if ($conn) {
    $user_id = $_POST['user_id'];
    $query = "SELECT * FROM ambulans WHERE user_id = '$user_id'";

    $result = mysqli_query($conn, $query);
    $response = array();

    if ($result) {
        $response['status'] = 'ok';
        $response['message'] = 'successfully proceed';
        $response['data'] = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $response['status'] = 'error';
        $response['message'] = 'failed to process: ' . mysqli_error($conn);
    }
} else {
    array_push($response, array(
        'status' => 'FAILED'
    ));
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
mysqli_close($conn);