<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cart";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $brand = $size = $color = $address = $payment = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM product WHERE id=$id";
    $result = $conn->query($sql);
    
    if ($result && $row = $result->fetch_assoc()) {
        $brand = $row["pBrand"];
        $size = $row["pSize"];
        $color = $row["pColor"];
        $address = $row["addr"];
        $payment = $row["payMet"];
    } else {
        $error = "Product not found!";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $brand = $_POST["pBrand"];
    $size = $_POST["pSize"];
    $color = $_POST["pColor"];
    $address = $_POST["addr"];
    $payment = $_POST["payMet"];
    
    if (!empty($brand) && !empty($size) && !empty($color) && !empty($address) && !empty($payment)) {

        $sql = "UPDATE product SET pBrand='$brand', pSize='$size', pColor='$color', addr='$address', payMet='$payment' WHERE id=$id";
        
        if ($conn->query($sql) === TRUE) {
            header("location: cart.php");
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
    <title>Edit Client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            max-width: 500px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333333;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333333;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.4);
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #3b82f6;
            border: none;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            display: inline-block;
            text-align: center;
            width: 96%;
            padding: 10px;
            background-color: #e5e7eb;
            color: #333333;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .alert {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="container my-5">
        <h2>Update Order</h2>
        <?php 
        if (!empty($error)) { 
            echo "<div class='alert'>$error</div>"; 
        } 
        ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Hidden field for client ID -->

            <div class="form-group mb-3">
                <label>Product Brand</label>
                <input type="text" class="form-control" name="pBrand" value="<?php echo $brand; ?>">
            </div>

            <div class="form-group mb-3">
                <label>Product Size</label>
                <input type="text" class="form-control" name="pSize" value="<?php echo $size; ?>">
            </div>

            <div class="form-group mb-3">
                <label>Product Color</label>
                <input type="text" class="form-control" name="pColor" value="<?php echo $color; ?>">
            </div>

            <div class="form-group mb-3">
                <label>Address</label>
                <input type="text" class="form-control" name="addr" value="<?php echo $address; ?>">
            </div>

            <div class="form-group mb-3">
                <label>Payment Method</label>
                <input type="text" class="form-control" name="payMet" value="<?php echo $payment; ?>">
            </div>

            <button type="submit" class="btn-primary">Update Order</button>
            <a href="cart.php" class="btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>