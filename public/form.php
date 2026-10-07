<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once __DIR__ . '/../private/process.php';
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Ultra Secure Form</title></head>
<body>
    <h2>Submit Your Data</h2>
    
    <?php
    if (isset($_SESSION['errors'])) {
        echo "<ul style='color:red;'>";
        foreach ($_SESSION['errors'] as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        unset($_SESSION['errors']);
    }
    ?>

    <form action="form.php" method="POST">
        <label>Name (max 50 chars):</label><br>
        <input type="text" name="name" required maxlength="50"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Age:</label><br>
        <input type="number" name="age" required><br><br>

        <label>Website (optional):</label><br>
        <input type="url" name="website"><br><br>

        <label>Message (max 500 chars):</label><br>
        <textarea name="message" required maxlength="500"></textarea><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>