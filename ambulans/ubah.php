<?php
require_once '../conn.php';

$response = array();

if ($conn) {
    if (isset($_POST['id']) && isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['latitude']) && isset($_POST['longitude'])) {
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $date = date('d M Y H:i:s');

        $query = "UPDATE adu 
            SET user_id='$user_id', name='$name', phone='$phone', date='$date', latitude='$latitude', longitude='$longitude' 
            WHERE id='$id')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $response['status'] = 'ok';
            $response['message'] = 'successfully created';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'failed to process: ' . mysqli_error($conn);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'all field must be filled';
    }
} else {
    array_push($response, array(
        'status' => 'FAILED'
    ));
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
mysqli_close($conn);
