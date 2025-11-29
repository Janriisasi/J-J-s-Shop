<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "login";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $fName = $pNum = $bDate = $uName = $email = $pWord = "";
$error = "";


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM inf WHERE id=$id";
    $result = $conn->query($sql);
    
    if ($result && $row = $result->fetch_assoc()) {
        $fName = $row["fName"];
        $pNum = $row["pNum"];
        $bDate = $row["bDate"];
        $uName = $row["uName"];
        $email = $row["email"];
        $pWord = $row["pWord"];
    } else {
        $error = "Client not found!";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $fName = $_POST["fName"];
    $pNum = $_POST["pNum"];
    $bDate = $_POST["bDate"];
    $uName = $_POST["uName"];
    $email = $_POST["email"];
    $pWord = $_POST["pWord"];
    
    if (!empty($fName) && !empty($pNum) && !empty($bDate) && !empty($uName) && !empty($email) && !empty($pWord)) {

        $sql = "UPDATE inf SET fName='$fName', pNum='$pNum', bDate='$bDate', uName='$uName', email='$email', pWord='$pWord'  WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            header("location: profile.php");
            exit;
        } else {
            $error = "Error updating record: " . $conn->error;
        }
    } else {
        $error = "All fields are required!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .container {
            display: flex;
            max-width: 500px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .form-container {
            flex: 2;
            padding: 30px;
        }
        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .alert {
            color: #721c24;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
        .btn-primary {
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn-secondary {
            padding: 10px 20px;
            color: #333;
            background-color: #ccc;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Form Section -->
        <div class="form-container">
            <h2>Edit Profile</h2>
            <?php 
            if (!empty($error)) { 
                echo "<div class='alert'>$error</div>"; 
            } 
            ?>

            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="fName" value="<?php echo $fName; ?>">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="pNum" value="<?php echo $pNum; ?>">
                </div>

                <div class="form-group">
                    <label>Birthdate</label>
                    <input type="date" name="bDate" value="<?php echo $bDate; ?>">
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="uName" value="<?php echo $uName; ?>">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $email; ?>">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="pWord" value="<?php echo $pWord; ?>">
                </div>

                <button type="submit" class="btn-primary">Update Client</button>
                <a href="profile.php" class="btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
