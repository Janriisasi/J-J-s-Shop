<?php
$servername = "localhost";

$username = "root";

$password = "";

$database = "cart";

$conn = new mysqli($servername, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (!isset($_GET["id"])) {
        
        header("location: cart.php");
        
        exit;
        
    }
    
    $id = $_GET["id"];
    
    $sql = "DELETE FROM product WHERE id=$id";
    
    $conn->query($sql);
    
    header("location: cart.php");
    
    exit;
    
}

?>