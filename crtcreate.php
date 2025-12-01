<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "cart";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

// Product data with prices
$products = [
    'LeBron' => ['prices' => ['S' => 40, 'M' => 50, 'L' => 60, 'XL' => 80]],
    'Nike One Classic' => ['prices' => ['S' => 29.90, 'M' => 29.90, 'L' => 29.90, 'XL' => 29.90]],
    'Nike SB' => ['prices' => ['S' => 25, 'M' => 25, 'L' => 25, 'XL' => 25]],
    'Jordan Brooklyn Fleece' => ['prices' => ['S' => 40, 'M' => 40, 'L' => 40, 'XL' => 40]],
    'NikeCourt' => ['prices' => ['S' => 25, 'M' => 25, 'L' => 25, 'XL' => 25]],
    'Nike Victory' => ['prices' => ['S' => 120, 'M' => 180, 'L' => 220, 'XL' => 280]],
    'Jordan Flight Essentials 85' => ['prices' => ['S' => 18, 'M' => 18, 'L' => 18, 'XL' => 18]],
    'Jordan' => ['prices' => ['S' => 40, 'M' => 40, 'L' => 40, 'XL' => 40]]
];

$brand = $size = $color = $address = $payment = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST["pBrand"];
    $size = $_POST["pSize"];
    $color = $_POST["pColor"];
    $address = $_POST["addr"];
    $payment = $_POST["payMet"];
    $price = $_POST["price"];
    
    if (empty($brand)) $errors['pBrand'] = "Brand is required";
    if (empty($size)) $errors['pSize'] = "Size is required";
    if (empty($color)) $errors['pColor'] = "Color is required";
    if (empty($address)) $errors['addr'] = "Address is required";
    if (empty($payment)) $errors['payMet'] = "Payment is required";
    
    if (count($errors) == 0) {
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO product (user_id, pBrand, pSize, pColor, price, addr, payMet)
                VALUES ('$user_id', '$brand', '$size', '$color', '$price', '$address', '$payment')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: cart.php");
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
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .Listtable {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
            width: 100%;
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
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 15px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .price-display {
            font-size: 20px;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
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

        <form method="POST" action="crtcreate.php" id="orderForm">
            <div class="mb-3">
                <label for="pBrand" class="form-Label">Product Brand</label>
                <select class="form-control" id="pBrand" name="pBrand" required>
                    <option value="">Select Product</option>
                    <option value="LeBron">LeBron</option>
                    <option value="Nike One Classic">Nike One Classic</option>
                    <option value="Nike SB">Nike SB</option>
                    <option value="Jordan Brooklyn Fleece">Jordan Brooklyn Fleece</option>
                    <option value="NikeCourt">NikeCourt</option>
                    <option value="Nike Victory">Nike Victory</option>
                    <option value="Jordan Flight Essentials 85">Jordan Flight Essentials 85</option>
                    <option value="Jordan">Jordan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="pSize" class="form-Label">Product Size</label>
                <select class="form-control" id="pSize" name="pSize" required>
                    <option value="">Select Size</option>
                    <option value="S">Small (S)</option>
                    <option value="M">Medium (M)</option>
                    <option value="L">Large (L)</option>
                    <option value="XL">Extra Large (XL)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="pColor" class="form-Label">Product Color</label>
                <select class="form-control" id="pColor" name="pColor" required>
                    <option value="">Select Color</option>
                    <option value="Black">Black</option>
                    <option value="White">White</option>
                    <option value="Red">Red</option>
                    <option value="Blue">Blue</option>
                    <option value="Green">Green</option>
                    <option value="Gray">Gray</option>
                    <option value="Navy">Navy</option>
                    <option value="Pink">Pink</option>
                </select>
            </div>

            <div class="price-display" id="priceDisplay">
                Price: Select product and size
            </div>
            <input type="hidden" name="price" id="priceInput" value="0">

            <div class="mb-3">
                <label for="addr" class="form-Label">Address</label>
                <input type="text" class="form-control" id="addr" name="addr" value="<?php echo $address; ?>" required>
            </div>

            <div class="mb-3">
                <label for="payMet" class="form-Label">Payment Method</label>
                <select class="form-control" id="payMet" name="payMet" required>
                    <option value="">Select Payment Method</option>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="GCash">GCash</option>
                    <option value="PayMaya">PayMaya</option>
                </select>
            </div>

            <div class="btn-container">
                <a href="cart.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Add to cart</button>
            </div>
        </form>
    </div>

    <script>
        const products = <?php echo json_encode($products); ?>;
        
        const brandSelect = document.getElementById('pBrand');
        const sizeSelect = document.getElementById('pSize');
        const priceDisplay = document.getElementById('priceDisplay');
        const priceInput = document.getElementById('priceInput');

        function updatePrice() {
            const brand = brandSelect.value;
            const size = sizeSelect.value;
            
            if (brand && size && products[brand]) {
                const price = products[brand].prices[size];
                priceDisplay.textContent = 'Price: $' + price.toFixed(2);
                priceInput.value = price;
            } else {
                priceDisplay.textContent = 'Price: Select product and size';
                priceInput.value = '0';
            }
        }

        brandSelect.addEventListener('change', updatePrice);
        sizeSelect.addEventListener('change', updatePrice);
    </script>
</body>
</html>