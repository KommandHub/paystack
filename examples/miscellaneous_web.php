<?php

$paystack = require_once __DIR__.'/bootstrap.php';

$action = $_GET['action'] ?? 'banks';
$country = $_GET['country'] ?? 'nigeria';

try {
    switch ($action) {
        case 'countries':
            $response = $paystack->miscellaneous()->listCountries();
            $title = 'Supported Countries';
            break;
        case 'states':
            $response = $paystack->miscellaneous()->listStates($country);
            $title = 'States for '.strtoupper($country);
            break;
        case 'banks':
        default:
            $response = $paystack->miscellaneous()->listBanks(['country' => $country]);
            $title = 'Supported Banks for '.ucfirst($country);
            break;
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paystack PHP - Miscellaneous</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 0 auto; padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #09a5db; font-weight: bold; }
        .nav a.active { color: #333; text-decoration: underline; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 4px; overflow-x: auto; font-size: 13px; }
        .error { color: #d93025; background-color: #fce8e6; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #eee; }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <h1>Miscellaneous API</h1>
    
    <div class="nav">
        <a href="?action=banks&country=nigeria" <?php echo $action === 'banks' && $country === 'nigeria' ? 'class="active"' : ''; ?>>Banks (Nigeria)</a>
        <a href="?action=banks&country=ghana" <?php echo $action === 'banks' && $country === 'ghana' ? 'class="active"' : ''; ?>>Banks (Ghana)</a>
        <a href="?action=countries" <?php echo $action === 'countries' ? 'class="active"' : ''; ?>>Countries</a>
        <a href="?action=states&country=NG" <?php echo $action === 'states' && $country === 'NG' ? 'class="active"' : ''; ?>>States (Nigeria)</a>
        <a href="?action=states&country=US" <?php echo $action === 'states' && $country === 'US' ? 'class="active"' : ''; ?>>States (US)</a>
        <a href="?action=states&country=CA" <?php echo $action === 'states' && $country === 'CA' ? 'class="active"' : ''; ?>>States (Canada)</a>
    </div>

    <div class="card">
        <h2><?php echo $title ?? 'Results'; ?></h2>
        
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php } elseif (isset($response)) { ?>
            <?php if ($action === 'states' && $country === 'NG' && ! $response['status']) { ?>
                <div class="error" style="background-color: #fff3cd; color: #856404; border-color: #ffeeba;">
                    <strong>Notice:</strong> Paystack's AVS States API currently only supports a few countries (US, CA, ZA, UK). 
                    While Nigeria is not yet supported for address verification via this endpoint, you can still list Nigerian banks.
                </div>
            <?php } ?>

            <?php if ($response['status']) { ?>
                <p><?php echo $response['message']; ?></p>
                
                <?php if ($action === 'banks') { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($response['data'], 0, 10) as $bank) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($bank['name']); ?></td>
                                    <td><code><?php echo htmlspecialchars($bank['code']); ?></code></td>
                                    <td><?php echo htmlspecialchars($bank['type']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if (count($response['data']) > 10) { ?>
                        <p><small>Showing first 10 of <?php echo count($response['data']); ?> banks.</small></p>
                    <?php } ?>
                <?php } elseif ($action === 'countries') { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ISO Code</th>
                                <th>Currency</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($response['data'] as $countryItem) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($countryItem['name']); ?></td>
                                    <td><code><?php echo htmlspecialchars($countryItem['iso_code']); ?></code></td>
                                    <td><?php echo htmlspecialchars($countryItem['currency_code']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } elseif ($action === 'states') { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Abbreviation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($response['data'] as $state) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($state['name']); ?></td>
                                    <td><code><?php echo htmlspecialchars($state['abbreviation']); ?></code></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>

                <h3>Raw Response:</h3>
                <pre><?php echo json_encode($response, JSON_PRETTY_PRINT); ?></pre>
            <?php } else { ?>
                <div class="error">API Error: <?php echo htmlspecialchars($response['message']); ?></div>
            <?php } ?>
        <?php } ?>
    </div>
    
    <p><a href="index.php">Back to Examples List</a></p>
</body>
</html>
