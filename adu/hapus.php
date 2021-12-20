<?php
require_once '../conn.php';

$response = array();

if ($conn) {
    $id = $_POST['id'];

    $query = "DELETE FROM adu WHERE id='$id'";

    $result = mysqli_query($conn, $query);
    $response = array();

    if ($result) {
        $response['status'] = 'ok';
        $response['message'] = 'successfully proceed';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'failed to process: ' . mysqli_error($conn);
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'failed to process: connection fails';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
mysqli_close($conn);
