<?php
require_once __DIR__ . '/../private/session.php';
require_once __DIR__ . '/../private/db.php';
require_once __DIR__ . '/../private/logger.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN_IP';
    $current_time = time();

    $time_limit = $current_time - 600; 
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM failed_logins WHERE ip_address = :ip AND attempt_time > :time_limit");
    $stmt->execute([':ip' => $ip, ':time_limit' => $time_limit]);
    $attempts = $stmt->fetchColumn();

    if ($attempts >= 5) {
        SecurityLogger::log('ATTACK', 'Brute-force blocked', "5+ failed attempts from IP");
        die("Too many failed login attempts. Please try again in 10 minutes.");
    }

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $stmt = $pdo->prepare("DELETE FROM failed_logins WHERE ip_address = :ip");
            $stmt->execute([':ip' => $ip]);

            SecurityLogger::log('INFO', 'Successful login', "User ID: {$user['id']}");

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['last_activity'] = time();
            $_SESSION['user_ip'] = $ip;
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? '';
            
            header("Location: protected.php");
            exit;
        } else {
            $stmt = $pdo->prepare("INSERT INTO failed_logins (ip_address, attempt_time) VALUES (:ip, :time)");
            $stmt->execute([':ip' => $ip, ':time' => $current_time]);

            SecurityLogger::log('WARNING', 'Failed login attempt', "Attempted username: $username");
            $error = "Invalid username or password.";
        }
    }
}
?>

<form method="POST">
    <h3>Login</h3>
    <?php if ($error): ?><p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>