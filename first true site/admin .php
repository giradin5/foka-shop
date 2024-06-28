<?php
session_start();

$correct_code = '658923374';
$retry_limit = 3;
$retry_timeout = 1800; // 30 minutes

if (!isset($_SESSION['retry_count'])) {
    $_SESSION['retry_count'] = 0;
    $_SESSION['blocked_until'] = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];

    if ($_SESSION['blocked_until'] && time() < $_SESSION['blocked_until']) {
        $remaining_time = $_SESSION['blocked_until'] - time();
        echo "Access blocked. Try again in $remaining_time seconds.";
    } else {
        if ($code === $correct_code) {
            $_SESSION['authenticated'] = true;
            header('Location: dashboard.php');
            exit;
        } else {
            $_SESSION['retry_count']++;

            if ($_SESSION['retry_count'] >= $retry_limit) {
                $_SESSION['blocked_until'] = time() + $retry_timeout;
                $_SESSION['retry_count'] = 0;
                echo "Access blocked. Try again in 30 minutes.";
            } else {
                echo "Incorrect code. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form method="post" action="index.php">
            <div class="mb-3">
                <label for="code" class="form-label">Enter Code:</label>
                <input type="text" class="form-control" id="code" name="code" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
