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
    WHERE id = ?");
    $stmt->execute([$forwarding_number, $voicemail_enabled, $voicemail_greeting, $_SESSION['user_id']]);

    $_SESSION['success'] = "सेटिंग्स सफलतापूर्वक सहेज हुई।";
    header('Location: dashboard.php');
    exit();
} catch (PDOException $e) {
    error_log("Phone number assignment error: " . $e->getMessage());
    $_SESSION['error'] = "फोन नंबर असाइन करने में समस्या हुई।";
    header('Location: dashboard.php');
    exit();
}

// Add this code at the start of dashboard.php to verify phone number
if (!isset($_SESSION['phone_number']) || empty($_SESSION['phone_number'])) {
    // Generate and assign a new virtual number if not exists
    try {
        $stmt = $pdo->prepare("SELECT phone_number FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $phone = $stmt->fetchColumn();
        
        if (!$phone) {
            // Generate new virtual number (example: +1-555-XXX-XXXX)
            $new_number = '+1555' . sprintf('%06d', rand(0, 999999));
            
            $stmt = $pdo->prepare("UPDATE users SET phone_number = ? WHERE id = ?");
            $stmt->execute([$new_number, $_SESSION['user_id']]);
            
            $_SESSION['phone_number'] = $new_number;
        } else {
            $_SESSION['phone_number'] = $phone;
        }
    } catch (PDOException $e) {
        error_log("Phone number assignment error: " . $e->getMessage());
        $_SESSION['error'] = "फोन नंबर असाइन करने में समस्या हुई।";
    }
} 
