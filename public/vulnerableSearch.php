<?php
require_once __DIR__ . '/../private/db.php';
$results = [];

if (isset($_GET['username'])) {
    $query = "SELECT id, username, email FROM users WHERE username = '" . $_GET['username'] . "'";
    
    try {
        $stmt = $pdo->query($query);
        $results = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Query failed.";
    }
}
?>

<form method="GET">
    <h3>Vulnerable Search</h3>
    <p>Try searching for: <code>' OR '1'='1</code></p>
    <input type="text" name="username" placeholder="Search Username" required>
    <button type="submit">Search</button>
</form>

<?php if ($results): ?>
    <ul>
        <?php foreach ($results as $user): ?>
            <li><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>