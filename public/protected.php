<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Protected Area</title></head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>!</h2>
    <p>This is a protected page. Only logged-in users can see this.</p>
    <a href="logout.php">Logout</a>
</body>
</html>