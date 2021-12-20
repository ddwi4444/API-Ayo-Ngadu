<?php
require_once '../conn.php';

$response = array();

if ($conn) {
    if (isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['complain']) && isset($_POST['latitude']) && isset($_POST['longitude'])) {
        $user_id = $_POST['user_id'];
        $name = $_POST['name'];
        $complain = $_POST['complain'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $image = $_FILES['image'];
        $date = date('d M Y H:i:s');

        $decodedImage = base64_decode("$image");
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        file_put_contents("img/adu/" . $name . "-" . $date . "." . $extension, $decodedImage);

        $query = "INSERT INTO adu(user_id, name, complain, date, latitude, longitude) 
                        VALUES('$user_id', '$name', '$complain', '$date', '$latitude', '$longitude')";

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
    $response['status'] = 'error';
    $response['message'] = 'failed to process';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
mysqli_close($conn);
