<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Your Order - Allahu Restaurant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
        }
        .contact-info {
            text-align: center;
            margin: 10px 0;
        }
        .date-time {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Reduced space above the table */
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #f8f8f8;
        }
        button {
            padding: 10px 15px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
        /* Hide buttons during print */
        @media print {
            button {
                display: none; /* Hide buttons */
            }
            .container {
                box-shadow: none; /* Remove shadow for print */
            }
        }
        .payment-field {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1 style="font-size:50px;"> ﷲھو ریسٹورنٹ </h1>
        <p class="contact-info">TEL: 03115104444</p>
        <p class="contact-info">Address: Gollrra Morr, H13 <br> Near Quaid-e-Azam International Hospital</p>
        <p class="date-time" id="dateTime"></p> <!-- Date and Time Field -->
    </div>

    <table class="mt-5">
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
            session_start();

            // Prices for menu items
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

            // Initialize total variable
            $total = 0;

            // Check if there are any items in the order
            if (isset($_SESSION['order']) && count($_SESSION['order']) > 0) {
                foreach ($_SESSION['order'] as $order) {
                    $itemTotal = $order['price'] * $order['quantity'];
                    $total += $itemTotal;
                    echo "<tr>
                        <td>{$order['item']}</td>
                        <td>{$order['price']}</td>
                        <td>{$order['quantity']}</td>
                        <td>$itemTotal</td>
                    </tr>";
                }
                echo "<tr>
                    <td colspan='3'><strong>Total:</strong></td>
                    <td><strong>$total</strong></td>
                </tr>";
            } else {
                echo "<tr><td colspan='4'>No items in your order.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="payment-field">
        <label for="payment">ادائیگی کی رقم درج کریں:</label>
        <input type="number" id="payment" class="form-control" placeholder="مجموعی ادائیگی" oninput="calculateChange()" />
    </div>

    <div class="payment-field">
        <label for="change">واپسی:</label>
        <input type="text" id="change" class="form-control" readonly />
    </div>

    <button onclick="printAndRedirect();">آرڈر پرنٹ کریں</button>
    <button onclick="window.location.href='index.php';">مینیو پر واپس جائیں</button>
</div>

<script>
    // Function to display current date and time
    function updateDateTime() {
        const now = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
        const dateTimeString = now.toLocaleString('en-US', options);
        document.getElementById('dateTime').textContent = dateTimeString;
    }

    // Call the function to set date and time on page load
    window.onload = updateDateTime;

    // Function to calculate change
    function calculateChange() {
        const total = <?php echo json_encode($total); ?>; // Get the total from PHP
        const payment = document.getElementById('payment').value || 0; // Get the payment value
        const change = payment - total; // Calculate change
        document.getElementById('change').value = change < 0 ? '' : change.toFixed(2); // Update change field
    }

    // Function to print and redirect
    function printAndRedirect() {
        window.print(); // Open print dialog
        setTimeout(function() {
            // Clear session and redirect after printing
            <?php 
            // Clear the session order after printing
            unset($_SESSION['order']); 
            ?>
            window.location.href = 'index.php'; // Redirect after 2 seconds
        }, 2000); // Adjust time as needed
    }
</script>

</body>
</html>
