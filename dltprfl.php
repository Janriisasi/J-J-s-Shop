<?php
$servername = "localhost";

$username = "root";

$password = "";

$database = "login";

$conn = new mysqli($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (!isset($_GET["id"])) {
        
        header("location: profile.php");
        
        exit;
        
    }
    
    $id = $_GET["id"];
    
    $sql = "DELETE FROM inf WHERE id=$id";
    
    $conn->query($sql);
    
    header("location: profile.php");
    
    exit;
    
}

?>