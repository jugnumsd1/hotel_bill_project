<?php
session_start(); // Start the session at the beginning of the file

// Prices for menu items, defaulting to session prices if available
if (isset($_SESSION['prices'])) {
    $prices = $_SESSION['prices'];
} else {
    $prices = [
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
}

// Initialize or retrieve the order
if (!isset($_SESSION['order'])) {
    $_SESSION['order'] = [];
}

// Handle form submission for adding items to the order
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['clear'])) {
        // Clear the session order
        unset($_SESSION['order']);
    } else {
        $item = $_POST['item'];
        $quantity = $_POST['quantity'];

        // Ensure quantity is a valid number and greater than zero (allowing decimals)
        if ($item && is_numeric($quantity) && $quantity > 0) {
            // Get the price for the selected item from the session
            $price = $prices[$item]; // Updated price

            // Calculate the item total based on the quantity
            $itemTotal = $price * $quantity;

            // Store the item details in the session order, including itemTotal
            $_SESSION['order'][] = [
                'item' => $item,
                'price' => $price,
                'quantity' => $quantity,
                'itemTotal' => $itemTotal // Store the calculated total for this item
            ];
        }
    }

    // Redirect to the same page to refresh the data and avoid resubmission
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ﷲھو ریسٹورنٹ</title>
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
            width: 48%; /* Adjust width for side-by-side buttons */
            display: inline-block; /* Align buttons side by side */
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .button-container {
            display: flex; /* Use flexbox for button layout */
            justify-content: space-between; /* Space between buttons */
            margin-top: 10px; /* Spacing above buttons */
        }
        .clear-button {
            width: 100%; /* Full width for clear button */
            margin-top: 10px; /* Spacing above the clear button */
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
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            border-radius: 4px;
            width: 190px;
            display: inline;
            margin-top: 10px; /* Spacing above button */
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>منیو</h1>
    <form method="POST" action="index.php">
        <select name="item" required>
            <option value="">آئٹم منتخب کریں</option>
            <?php
            foreach ($prices as $item => $price) {
                echo "<option value=\"$item\">$item</option>";
            }
            ?>
        </select>
        <!-- Allow decimal values in the quantity input -->
        <input type="number" name="quantity" placeholder="مقدار" required step="0.1" min="0.1">
        <div class="button-container">
            <input type="submit" value="آرڈر شامل کریں">
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>آئٹم</th>
                <th>قیمت</th>
                <th>مقدار</th>
                <th>کل</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalAmount = 0;
            if (isset($_SESSION['order'])) {
                foreach ($_SESSION['order'] as $order) {
                    echo "<tr>
                        <td>{$order['item']}</td>
                        <td>{$order['price']}</td>
                        <td>{$order['quantity']}</td>
                        <td>{$order['itemTotal']}</td>
                    </tr>";
                    $totalAmount += $order['itemTotal']; // Calculate the total amount
                }
            }
            ?>
        </tbody>
    </table>

    <h2>کل رقم: <?php echo $totalAmount; ?></h2>
    <button onclick="window.location.href='update_prices.php';" class="btn">قیمتیں اپ ڈیٹ کریں</button>
    <button onclick="window.location.href='view_menu.php';" class="btn">رسید چیک کریں</button>
   
    <form method="POST" action="index.php">
        <div class="button-container">
            <input type="submit" name="clear" value="آرڈر صاف کریں" class="clear-button btn">
        </div>
    </form>

</div>

</body>
</html>
