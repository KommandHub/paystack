<?php

$paystack = require_once __DIR__.'/bootstrap.php';

$reference = $_GET['reference'] ?? $_GET['trxref'] ?? null;

if (! $reference) {
    exit('No reference provided.');
}

try {
    $response = $paystack->transactions()->verify($reference);
} catch (Exception $e) {
    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Verification - Paystack PHP</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .success { color: #1e8e3e; background-color: #e6f4ea; padding: 15px; border-radius: 4px; font-weight: bold; }
        .failed { color: #d93025; background-color: #fce8e6; padding: 15px; border-radius: 4px; font-weight: bold; }
        .pending { color: #f29900; background-color: #fff7e6; padding: 15px; border-radius: 4px; font-weight: bold; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 4px; overflow-x: auto; font-size: 13px; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 14px; text-transform: uppercase; }
        .badge-success { background: #e6f4ea; color: #1e8e3e; }
        .badge-failed { background: #fce8e6; color: #d93025; }
        .badge-pending { background: #fff7e6; color: #f29900; }
    </style>
</head>
<body>
    <h1>Payment Verification</h1>
    <div class="card">
        <?php if (isset($error)) { ?>
            <div class="failed">Error: <?php echo htmlspecialchars($error); ?></div>
        <?php } elseif ($response['status']) { ?>
            <?php $data = $response['data']; ?>
            
            <?php if ($data['status'] === 'success') { ?>
                <div class="success">
                    ✅ Payment Successful!
                </div>
                <p style="margin-top: 15px;">
                    <a href="refund_create_web.php?reference=<?php echo urlencode($reference); ?>&amount=<?php echo $data['amount'] / 100; ?>" class="status-badge badge-pending" style="text-decoration: none;">
                        Refund this transaction
                    </a>
                </p>
            <?php } elseif ($data['status'] === 'failed') { ?>
                <div class="failed">
                    ❌ Payment Failed
                </div>
            <?php } else { ?>
                <div class="pending">
                    ⚠️ Status: <?php echo ucfirst($data['status']); ?>
                </div>
            <?php } ?>

            <p><strong>Reference:</strong> <?php echo htmlspecialchars($reference); ?></p>
            <p><strong>Amount:</strong> <?php echo ($data['amount'] / 100).' '.$data['currency']; ?></p>
            <p><strong>Message:</strong> <?php echo htmlspecialchars($response['message']); ?></p>

            <h3>Response Data:</h3>
            <pre><?php echo json_encode($response, JSON_PRETTY_PRINT); ?></pre>
        <?php } else { ?>
            <div class="failed">
                ❌ Verification Failed: <?php echo htmlspecialchars($response['message']); ?>
            </div>
        <?php } ?>
    </div>
    <p><a href="web_initialize.php">Try another payment</a> | <a href="index.php">Back to Examples List</a></p>
</body>
</html>
