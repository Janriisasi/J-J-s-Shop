<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn ->connect_error){
    die ("Connection Error" . $conn ->connect_error);
}

$fName = $_POST ['fName'];
$pNum = $_POST ['pNum'];
$bDate = $_POST ['bDate'];
$uName = $_POST ['uName'];
$email = $_POST ['email'];
$pWord = $_POST ['pWord'];

$sql = "INSERT into inf (fName, pNum, bDate, uName, email, pWord) VALUES ('$fName', '$pNum', '$bDate', '$uName', '$email', '$pWord')";

if($conn->query($sql) === TRUE){
    echo("Registered Successfully");
    
    header("LOCATION: login.html");
    exit();
}

else {
    echo"Register error. Please try again." . $sql . $conn->connect_error;
}

$conn->close();
?>