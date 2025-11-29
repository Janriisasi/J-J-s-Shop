<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "cart";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

$brand = $size = $color = $address = $payment = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $brand = $_POST["pBrand"];
    $size = $_POST["pSize"];
    $color = $_POST["pColor"];
    $address = $_POST["addr"];
    $payment = $_POST["payMet"];
    
    if (empty($brand)) $errors['pBrand'] = "Brand is required";
    if (empty($size)) $errors['pSize'] = "Size is required";
    if (empty($color)) $errors['pColor'] = "Color is required";
    if (empty($address)) $errors['addr'] = "Address is required";
    if (empty($payment)) $errors['payMet'] = "Payment is required";
    
    if (count($errors) == 0) {
        // Ensure that the column names below match those in your database table exactly
        $sql = "INSERT INTO product (pBrand, pSize, pColor, addr, payMet)
                VALUES ('$brand', '$size', '$color', '$address', '$payment')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: cart.php"); // Redirect to cart.php after successful insertion
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding-right: 20px;
        }

        .Listtable {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
            width: 100%;
            margin: 20px 20px 20px 20px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #333333;
            font-weight: bold;
            margin-bottom: 20px;
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

        .form-Label {
            display: block;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .form-control {
            width: 95%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 15px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 20px; /* Increased spacing between buttons */
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #ffffff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="Listtable">
        <h2>New Order</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="crtcreate.php">
            <div class="mb-3">
                <label for="pBrand" class="form-Label">Product Brand</label>
                <input type="text" class="form-control" id="pBrand" name="pBrand" value="<?php echo $brand; ?>">
            </div>

            <div class="mb-3">
                <label for="pSize" class="form-Label">Product Size</label>
                <input type="text" class="form-control" id="pSize" name="pSize" value="<?php echo $size; ?>">
            </div>

            <div class="mb-3">
                <label for="pColor" class="form-Label">Product Color</label>
                <input type="text" class="form-control" id="pColor" name="pColor" value="<?php echo $color; ?>">
            </div>

            <div class="mb-3">
                <label for="addr" class="form-Label">Address</label>
                <input type="text" class="form-control" id="addr" name="addr" value="<?php echo $address; ?>">
            </div>

            <div class="mb-3">
                <label for="payMet" class="form-Label">Payment Method</label>
                <input type="text" class="form-control" id="payMet" name="payMet" value="<?php echo $payment; ?>">
            </div>

            <div class="btn-container">
                <a href="cart.php" class="btn btn-secondary">Cancel</a>
                <button type="submit"  class="btn btn-primary">Add to cart</button>
            </div>
        </form>
    </div>
</body>
</html>