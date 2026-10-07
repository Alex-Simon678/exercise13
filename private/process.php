<?php

$errors = [];
$sanitized_data = [];

$name = $_POST['name'] ?? '';
if (empty($name)) {
    $errors[] = "Name is required.";
} elseif (strlen($name) > 50) {
    $errors[] = "Name must not exceed 50 characters.";
} else {
    $clean_name = strip_tags($name);
    $sanitized_data['name'] = htmlspecialchars($clean_name, ENT_QUOTES, 'UTF-8');
}

$email = $_POST['email'] ?? '';
if (empty($email)) {
    $errors[] = "Email is required.";
} else {
    $clean_email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (!filter_var($clean_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        $sanitized_data['email'] = $clean_email;
    }
}

$age = $_POST['age'] ?? '';
if (empty($age) || !is_numeric($age)) {
    $errors[] = "Age is required and must be a number.";
} else {
    $sanitized_data['age'] = (int)$age;
}

$website = $_POST['website'] ?? '';
if (!empty($website)) {
    if (!filter_var($website, FILTER_VALIDATE_URL)) {
        $errors[] = "Invalid website URL.";
    } else {
        $sanitized_data['website'] = htmlspecialchars(strip_tags($website), ENT_QUOTES, 'UTF-8');
    }
} else {
    $sanitized_data['website'] = "N/A";
}

$message = $_POST['message'] ?? '';
if (empty($message)) {
    $errors[] = "Message is required.";
} elseif (strlen($message) > 500) {
    $errors[] = "Message must not exceed 500 characters.";
} else {
    $clean_message = strip_tags($message);
    $sanitized_data['message'] = htmlspecialchars($clean_message, ENT_QUOTES, 'UTF-8');
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: form.php");
    exit;
} else {
    echo "<h2>Submission Successful</h2>";
    echo "<p><strong>Name:</strong> " . $sanitized_data['name'] . "</p>";
    echo "<p><strong>Email:</strong> " . $sanitized_data['email'] . "</p>";
    echo "<p><strong>Age:</strong> " . $sanitized_data['age'] . "</p>";
    echo "<p><strong>Website:</strong> " . $sanitized_data['website'] . "</p>";
    echo "<p><strong>Message:</strong> " . $sanitized_data['message'] . "</p>";
    echo "<a href='form.php'>Go Back</a>";
}