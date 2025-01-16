<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

try {
    // Validate forwarding number
    $forwarding_number = filter_input(INPUT_POST, 'forwarding_number', FILTER_SANITIZE_STRING);
    if ($forwarding_number && !preg_match('/^\+?[1-9]\d{9,14}$/', $forwarding_number)) {
        $_SESSION['error'] = "कृपया एक वैध फोन नंबर दर्ज करें।";
        header('Location: dashboard.php');
        exit();
    }

    // Prepare data
    $voicemail_enabled = isset($_POST['voicemail_enabled']) ? 1 : 0;
    $voicemail_greeting = filter_input(INPUT_POST, 'voicemail_greeting', FILTER_SANITIZE_STRING);

    // Update settings
    $stmt = $pdo->prepare("UPDATE call_settings SET 
        forwarding_number = ?,
        voicemail_enabled = ?,
        voicemail_greeting = ?
        WHERE user_id = ?");

    $stmt->execute([
        $forwarding_number,
        $voicemail_enabled,
        $voicemail_greeting,
        $_SESSION['user_id']
    ]);

    $_SESSION['success'] = "सेटिंग्स सफलतापूर्वक अपडेट की गईं।";
} catch (PDOException $e) {
    error_log("Settings update error: " . $e->getMessage());
    $_SESSION['error'] = "सेटिंग्स अपडेट करने में त्रुटि हुई।";
}

header('Location: dashboard.php');
exit(); 
