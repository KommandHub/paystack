<?php

$paystack = require_once __DIR__.'/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = $_POST['name'];
        $amount = (int) ($_POST['amount'] * 100); // Convert Naira to kobo
        $interval = $_POST['interval'];

        $response = $paystack->plans()->create([
            'name' => $name,
            'amount' => $amount,
            'interval' => $interval,
        ]);

        if ($response['status']) {
            $success = 'Plan created successfully!';
            $data = $response['data'];
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
    <title>Paystack PHP - Create Plan</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #09a5db; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        button:hover { background-color: #0884af; }
        .error { color: #d93025; background-color: #fce8e6; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .success { color: #1e8e3e; background-color: #e6f4ea; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .data-display { background: #f8f9fa; padding: 10px; border-radius: 4px; border: 1px solid #eee; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Paystack PHP Library</h1>
    <div class="card">
        <h2>Create Plan</h2>
        
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <?php if (isset($success)) { ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <div class="data-display">
                <p><strong>Plan Code:</strong> <?php echo htmlspecialchars($data['plan_code']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($data['name']); ?></p>
                <p><strong>Amount:</strong> <?php echo htmlspecialchars((string) ($data['amount'] / 100)); ?> <?php echo htmlspecialchars($data['currency'] ?? 'NGN'); ?></p>
                <p><strong>Interval:</strong> <?php echo htmlspecialchars($data['interval']); ?></p>
            </div>
            <p><a href="plan_create_web.php">Create another</a></p>
        <?php } else { ?>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Plan Name</label>
                    <input type="text" name="name" id="name" value="Monthly Starter Plan" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount (NGN)</label>
                    <input type="number" name="amount" id="amount" value="1000" min="1" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="interval">Interval</label>
                    <select name="interval" id="interval" required>
                        <option value="hourly">Hourly</option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly" selected>Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        <option value="annually">Annually</option>
                    </select>
                </div>
                <button type="submit">Create Plan</button>
            </form>
        <?php } ?>
    </div>
    <p><a href="index.php">Back to Examples List</a></p>
</body>
</html>
