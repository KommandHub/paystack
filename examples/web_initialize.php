<?php

$paystack = require_once __DIR__.'/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $amount = (int) ($_POST['amount'] * 100); // Convert Naira to kobo
        $email = $_POST['email'];

        // Determine callback URL based on current request
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $callbackUrl = "$protocol://$host/web_callback.php";

        $response = $paystack->transactions()->initialize([
            'amount' => $amount,
            'email' => $email,
            'callback_url' => $callbackUrl,
        ]);

        if ($response['status']) {
            $authorizationUrl = $response['data']['authorization_url'];
            header("Location: $authorizationUrl");
            exit;
        } else {
            $error = $response['message'];
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paystack PHP - Web Example</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="email"], input[type="number"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #09a5db; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        button:hover { background-color: #0884af; }
        .error { color: #d93025; background-color: #fce8e6; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>Paystack PHP Library</h1>
    <div class="card">
        <h2>Initialize Transaction</h2>
        
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" value="customer@example.com" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount (NGN)</label>
                <input type="number" name="amount" id="amount" value="50" min="1" step="0.01" required>
            </div>
            <button type="submit">Pay Now</button>
        </form>
    </div>
    <p><a href="index.php">Back to Examples List</a></p>
</body>
</html>
