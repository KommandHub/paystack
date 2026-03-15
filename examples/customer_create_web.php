<?php

$paystack = require_once __DIR__.'/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];

        $response = $paystack->customers()->create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
        ]);

        if ($response['status']) {
            $success = 'Customer created successfully!';
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
    <title>Paystack PHP - Create Customer</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="email"], input[type="text"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
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
        <h2>Create Customer</h2>
        
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <?php if (isset($success)) { ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <div class="data-display">
                <p><strong>Customer Code:</strong> <?php echo htmlspecialchars($data['customer_code']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($data['first_name'].' '.$data['last_name']); ?></p>
            </div>
            <p><a href="customer_create_web.php">Create another</a></p>
        <?php } else { ?>
            <form method="POST">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" value="John" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="Doe" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" value="john.doe@example.com" required>
                </div>
                <button type="submit">Create Customer</button>
            </form>
        <?php } ?>
    </div>
    <p><a href="index.php">Back to Examples List</a></p>
</body>
</html>
