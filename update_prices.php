<?php
session_start();

// Sample current prices array
$currentPrices = [
    'دال' => 30,
    'سبزی' => 40,
    'چنا دال' => 35,
    'شاہی دال' => 50,
    'چکن کڑاہی' => 200,
    'مکھنی کڑاہی' => 220,
    'روٹی' => 20,
    'بریانی' => 180,
    'چاول' => 25,
    'قورمہ' => 150,
    'قیمہ' => 160,
    'کلیجی' => 250,
    '1 لیٹر' => 170,
    '1.5 لیٹر' => 200,
    '2.5 لیٹر' => 250,
    'ریٹھا' => 60,
    'سلاد' => 60
];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item = $_POST['item'];
    $newPrice = $_POST['price'];

    // Update the price
    if (array_key_exists($item, $currentPrices)) {
        $currentPrices[$item] = $newPrice;
        
        // Save the updated prices to session
        $_SESSION['prices'] = $currentPrices; // Save the current prices to session
    }
}

// Initialize prices from session if available
if (isset($_SESSION['prices'])) {
    $currentPrices = $_SESSION['prices'];
}
?>

<!DOCTYPE html>
<html lang="ur">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قیمتیں اپ ڈیٹ کریں</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 4px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>کھانے کی اشیاء کی قیمتیں اپ ڈیٹ کریں</h1>
    <form method="POST" action="update_prices.php">
        <select name="item" required>
            <option value="">آئٹم منتخب کریں</option>
            <?php
            foreach ($currentPrices as $item => $price) {
                echo "<option value=\"$item\">$item</option>";
            }
            ?>
        </select>

        <input type="number" name="price" placeholder="نئی قیمت" step="0.01" required>
        <input type="submit" value="قیمت اپ ڈیٹ کریں">
    </form>

    <table>
        <thead>
            <tr>
                <th>آئٹم</th>
                <th>موجودہ قیمت</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($currentPrices as $item => $price) {
                echo "<tr>
                    <td>$item</td>
                    <td>$price</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <button onclick="window.location.href='index.php';">مینو پر واپس جائیں</button>
</div>

</body>
</html>
