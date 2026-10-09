<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

function require_secure_session() {
    if (isset($_SESSION['user_id'])) {
        
        if (isset($_SESSION['last_activity'])) {
            if (time() - $_SESSION['last_activity'] > 1800) {
                session_unset();
                session_destroy();
                header("Location: login.php?msg=expired");
                exit;
            }
        }
        $_SESSION['last_activity'] = time();

        $current_ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $current_ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

        if (isset($_SESSION['user_ip']) && isset($_SESSION['user_agent'])) {
            if ($_SESSION['user_ip'] !== $current_ip || $_SESSION['user_agent'] !== $current_ua) {
                session_unset();
                session_destroy();
                header("Location: login.php?msg=hijacked");
                exit;
            }
        }
    }
}
require_secure_session();