<?php
require_once __DIR__ . '/../private/db.php';
$results = [];

if (isset($_GET['username'])) {
    $stmt = $pdo->prepare("SELECT id, username, email FROM users WHERE username = :username");
    $stmt->execute([':username' => $_GET['username']]);
    $results = $stmt->fetchAll();
}
?>

<form method="GET">
    <h3>Secure Search</h3>
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