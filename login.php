<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn ->connect_error){
    die("Connection Error" . $conn ->connect_error);
}

$uName = $_POST ['uName'];
$pWord = $_POST ['pWord'];

$sql = "SELECT * FROM inf WHERE uName = '$uName' AND pWord = '$pWord'";

$result = $conn->query($sql);

if($result->num_rows > 0){
    echo"Logged in Successfully Welcome " . $uName;
    header("LOCATION: home.html");
    exit();
}

else {
    echo "Invalid username or password. Please check and try again.";
}

$conn->close();
?>