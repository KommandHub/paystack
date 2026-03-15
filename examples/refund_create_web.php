<?php

$paystack = require_once __DIR__.'/bootstrap.php';

$transactionReference = $_GET['reference'] ?? '';
$amount = $_GET['amount'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $transaction = $_POST['transaction'];
        $refundAmount = ! empty($_POST['amount']) ? (int) ($_POST['amount'] * 100) : null;
        $merchantNote = $_POST['merchant_note'] ?? '';
        $customerNote = $_POST['customer_note'] ?? '';

        $payload = [
            'transaction' => $transaction,
        ];

        if ($refundAmount) {
            $payload['amount'] = $refundAmount;
        }

        if ($merchantNote) {
            $payload['merchant_note'] = $merchantNote;
        }

        if ($customerNote) {
            $payload['customer_note'] = $customerNote;
        }

        $response = $paystack->refunds()->create($payload);

        if ($response['status']) {
            $success = $response['message'];
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
    <title>Paystack PHP - Refund Example</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #09a5db; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        button:hover { background-color: #0884af; }
        .error { color: #d93025; background-color: #fce8e6; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .success { color: #1e8e3e; background-color: #e6f4ea; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 4px; overflow-x: auto; font-size: 13px; }
        .help-text { font-size: 12px; color: #666; margin-top: 4px; }
    </style>
</head>
<body>
    <h1>Paystack PHP Library</h1>
    <div class="card">
        <h2>Create Refund</h2>
        <p>Use this form to initiate a refund for a transaction.</p>
        
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <?php if (isset($success)) { ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <h3>Refund Details:</h3>
            <pre><?php echo json_encode($data, JSON_PRETTY_PRINT); ?></pre>
            <p><a href="index.php">Back to Dashboard</a></p>
        <?php } else { ?>
            <form method="POST">
                <div class="form-group">
                    <label for="transaction">Transaction Reference or ID</label>
                    <input type="text" name="transaction" id="transaction" value="<?php echo htmlspecialchars($transactionReference); ?>" required>
                    <p class="help-text">The reference of the successful transaction you want to refund.</p>
                </div>
                <div class="form-group">
                    <label for="amount">Amount (NGN) - Optional</label>
                    <input type="number" name="amount" id="amount" value="<?php echo htmlspecialchars($amount); ?>" step="0.01" min="0">
                    <p class="help-text">Leave empty to refund the full amount.</p>
                </div>
                <div class="form-group">
                    <label for="merchant_note">Merchant Note (Optional)</label>
                    <textarea name="merchant_note" id="merchant_note" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <label for="customer_note">Customer Note (Optional)</label>
                    <textarea name="customer_note" id="customer_note" rows="2"></textarea>
                </div>
                <button type="submit">Process Refund</button>
            </form>
        <?php } ?>
    </div>
    <p><a href="index.php">Back to Examples List</a></p>
</body>
</html>
