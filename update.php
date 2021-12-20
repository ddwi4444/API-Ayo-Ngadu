<?php
require_once 'conn.php';

if ($conn) {

  if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['password'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $encPassword = md5($password);

    if ($_FILES['image']) {
      $image = $_FILES['image'];
      $extension = pathinfo($image, PATHINFO_EXTENSION);
      $decodedImage = base64_decode("$image");
      file_put_contents("img/users/" . $name . "." . $extension, $decodedImage);
    }

    $query = "UPDATE users SET name = '$name', email = '$email',  phone = '$phone', password = '$encPassword' WHERE id = '$id'";

    $result = mysqli_query($conn, $query);
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
    $response['message'] = 'email and password must not be empty';
  }
} else {
  $response['status'] = 'error';
  $response['message'] = 'failed to register';
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
mysqli_close($conn);
