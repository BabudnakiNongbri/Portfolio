<?php $portfolio = getenv("PORTFOLIO_URL") ?: ""; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Projects</title>
    <style>
        body{font-family:Arial,sans-serif;background:#0f172a;color:#e2e8f0;display:flex;justify-content:center;padding:60px 20px}
        .box{max-width:520px;width:100%}
        a{display:block;padding:14px 18px;margin:10px 0;background:#1e293b;border-radius:10px;color:#38bdf8;text-decoration:none}
        a:hover{background:#334155}
    </style>
</head>
<body>
<div class="box">
    <h1>PHP + MySQL Projects</h1>
    <a href="employee-management/">Employee Management System</a>
    <a href="contact-management/">Contact Management Application</a>
    <a href="nexora-company/">Nexora - Company Portal</a>
    <a href="department-portal/">Department Portal</a>
    <?php if ($portfolio): ?>
        <a href="<?php echo htmlspecialchars($portfolio); ?>">&larr; Back to portfolio</a>
    <?php endif; ?>
</div>
</body>
</html>
