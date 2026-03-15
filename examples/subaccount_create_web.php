<?php

$paystack = require_once __DIR__.'/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $payload = [
            'business_name' => $_POST['business_name'],
            'settlement_bank' => $_POST['settlement_bank'],
            'account_number' => $_POST['account_number'],
            'percentage_charge' => (float) $_POST['percentage_charge'],
            'description' => $_POST['description'] ?? '',
        ];

        $response = $paystack->subaccounts()->create($payload);

        if ($response['status']) {
            $success = 'Subaccount created successfully!';
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
    <title>Paystack PHP - Create Subaccount</title>
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
        <h2>Create Subaccount</h2>
        
        <?php if (isset($error)) { ?>
            <div class="error">
                <strong>Error:</strong> <?php echo htmlspecialchars($error); ?>
                <?php if (str_contains($error, 'Account details are invalid')) { ?>
                    <p style="margin-top: 10px; font-size: 0.9em; font-weight: normal;">
                        <strong>Tip:</strong> This error usually means the Bank Code or Account Number is incorrect. 
                        In <strong>test mode</strong>, use any valid bank code with a dummy account number (e.g., 0000000000). 
                        In <strong>live mode</strong>, ensure the account exists and matches the bank.
                    </p>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if (isset($success)) { ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <div class="data-display">
                <p><strong>Subaccount Code:</strong> <?php echo htmlspecialchars($data['subaccount_code']); ?></p>
                <p><strong>Business Name:</strong> <?php echo htmlspecialchars($data['business_name']); ?></p>
                <p><strong>Bank:</strong> <?php echo htmlspecialchars($data['settlement_bank']); ?></p>
                <p><strong>Account Number:</strong> <?php echo htmlspecialchars($data['account_number']); ?></p>
            </div>
            <p><a href="split_create_web.php?subaccount=<?php echo urlencode($data['subaccount_code']); ?>">Create Split using this subaccount</a></p>
            <p><a href="subaccount_create_web.php">Create another subaccount</a></p>
        <?php } else { ?>
            <form method="POST">
                <div class="form-group">
                    <label for="business_name">Business Name</label>
                    <input type="text" name="business_name" id="business_name" value="Test Subaccount" required>
                </div>
                <div class="form-group">
                    <label for="settlement_bank">Settlement Bank (Code)</label>
                    <input type="text" name="settlement_bank" id="settlement_bank" value="058" placeholder="e.g. 058 for GTBank" required>
                    <small>Get bank codes from <a href="https://paystack.com/docs/api/bank/" target="_blank">Paystack API documentation</a>.</small>
                </div>
                <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="text" name="account_number" id="account_number" value="0000000000" required>
                    <small>In test mode, any 10-digit number usually works.</small>
                </div>
                <div class="form-group">
                    <label for="percentage_charge">Percentage Charge (%)</label>
                    <input type="number" name="percentage_charge" id="percentage_charge" value="20" min="0" max="100" step="0.1" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" value="Example subaccount for split payment">
                </div>
                <button type="submit">Create Subaccount</button>
            </form>
        <?php } ?>
    </div>
    <p><a href="index.php">Back to Examples List</a></p>
</body>
</html>
