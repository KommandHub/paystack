<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paystack PHP Library - Examples</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 0 auto; padding: 20px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        ul { list-style-type: none; padding: 0; }
        li { margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        li:last-child { border-bottom: none; }
        a { color: #09a5db; text-decoration: none; font-weight: bold; }
        a:hover { text-decoration: underline; }
        .tag { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 12px; margin-right: 5px; background: #eee; color: #666; }
        .tag-web { background: #e3f2fd; color: #1976d2; }
        .tag-cli { background: #f5f5f5; color: #616161; }
    </style>
</head>
<body>
    <h1>Paystack PHP Library Examples</h1>
    
    <div class="card">
        <h2>Examples</h2>
        <p>Run these in your browser using <code>php -S localhost:8000</code> in the <code>examples</code> directory.</p>
        <ul>
            <li>
                <span class="tag tag-web">Web</span>
                <a href="web_initialize.php">Full Payment Flow</a> - Initialize a transaction and handle the callback in the browser.
            </li>
            <li>
                <span class="tag tag-web">Web</span>
                <a href="customer_create_web.php">Create Customer</a> - Create a new customer via web form.
            </li>
            <li>
                <span class="tag tag-web">Web</span>
                <a href="plan_create_web.php">Create Plan</a> - Create a new payment plan via web form.
            </li>
            <li>
                <span class="tag tag-web">Web</span>
                <a href="refund_create_web.php">Create Refund</a> - Process a refund for a transaction.
            </li>
            <li>
                <span class="tag tag-web">Web</span>
                <a href="subaccount_create_web.php">Create Subaccount</a> - Create a subaccount for split payments.
            </li>
            <li>
                <span class="tag tag-web">Web</span>
                <a href="split_create_web.php">Create Split Payment</a> - Create a split payment configuration.
            </li>
            <li>
                <span class="tag tag-web">Web</span>
                <a href="miscellaneous_web.php">Miscellaneous</a> - List banks, countries, and states.
            </li>
        </ul>
    </div>

    <p><a href="../README.md">&larr; Back to Documentation</a></p>
</body>
</html>
