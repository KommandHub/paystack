<?php

$paystack = require_once __DIR__.'/bootstrap.php';

$subaccountCode = $_GET['subaccount'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $payload = [
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'currency' => $_POST['currency'],
            'subaccounts' => [
                [
                    'subaccount' => $_POST['subaccount_code'],
                    'share' => (float) $_POST['share'],
                ],
            ],
            'bearer_type' => $_POST['bearer_type'],
        ];

        $response = $paystack->splits()->create($payload);

        if ($response['status']) {
            $success = 'Split created successfully!';
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
    <title>Paystack PHP - Create Split Payment</title>
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
        <h2>Create Split Payment</h2>
        
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <?php if (isset($success)) { ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <div class="data-display">
                <p><strong>Split ID:</strong> <?php echo htmlspecialchars((string) $data['id']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($data['name']); ?></p>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($data['type']); ?></p>
                <p><strong>Subaccounts:</strong> <?php echo count($data['subaccounts']); ?></p>
            </div>
            <p><a href="split_create_web.php">Create another split</a></p>
        <?php } else { ?>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Split Name</label>
                    <input type="text" name="name" id="name" value="Test Split" required>
                </div>
                <div class="form-group">
                    <label for="type">Split Type</label>
                    <select name="type" id="type" required>
                        <option value="percentage">Percentage</option>
                        <option value="flat">Flat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <select name="currency" id="currency" required>
                        <option value="NGN">NGN</option>
                        <option value="GHS">GHS</option>
                        <option value="KES">KES</option>
                        <option value="ZAR">ZAR</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subaccount_code">Subaccount Code</label>
                    <input type="text" name="subaccount_code" id="subaccount_code" value="<?php echo htmlspecialchars($subaccountCode); ?>" placeholder="ACCT_xxxxxxxxx" required>
                    <?php if (empty($subaccountCode)) { ?>
                        <small>Don't have a subaccount? <a href="subaccount_create_web.php">Create one first</a>.</small>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="share">Share (Percentage or Flat Amount)</label>
                    <input type="number" name="share" id="share" value="20" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="bearer_type">Transaction Bearer</label>
                    <select name="bearer_type" id="bearer_type" required>
                        <option value="account">Main Account</option>
                        <option value="subaccount">Subaccount</option>
                        <option value="all-pro-rata">All Pro-rata</option>
                    </select>
                </div>
                <button type="submit">Create Split</button>
            </form>
        <?php } ?>
    </div>
    <p><a href="index.php">Back to Examples List</a></p>
</body>
</html>
