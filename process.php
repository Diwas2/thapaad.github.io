<?php
session_start();
$conn = mysqli_connect('localhost','root','','part2');

$phoneNumber = $_POST['phoneNumber'];
$password = $_POST['phoneNumber'];

$query = "SELECT * FROM member WHERE phone_number = '$phoneNumber' AND password = '$password'";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result) == 1){
    $data = mysqli_fetch_assoc($result);
    $_SESSION['id'] = $data['member_id'];
    header('location:index.php');
}
else{
    $_SESSION['error'] = "Username or password invalid";
    header('location:index.php');
}
?>