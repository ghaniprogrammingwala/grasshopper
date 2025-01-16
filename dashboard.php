<?php
// Start session and include required files with error checking
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if config file exists
if (!file_exists('config/db.php')) {
    die('Database configuration file not found');
}

// Include database configuration with error handling
try {
    require_once 'config/db.php';
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Check if auth_check file exists
if (!file_exists('includes/auth_check.php')) {
    die('Authentication check file not found');
}

// Include authentication check
require_once 'includes/auth_check.php';

// Verify session variables exist
if (!isset($_SESSION['username']) || !isset($_SESSION['phone_number'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Call Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .main-dashboard {
            text-align: center;
        }

        .user-info {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.5s ease-out;
        }

        .user-info h1 {
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .virtual-number {
            font-size: 28px;
            color: #4eff91;
            margin: 20px 0;
            font-weight: 500;
            text-shadow: 0 0 10px rgba(78, 255, 145, 0.3);
        }

        .status {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(78, 255, 145, 0.2);
            border-radius: 30px;
            font-size: 14px;
            color: #4eff91;
        }

        .feature-buttons {
            margin: 40px 0;
        }

        .feature-btn {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            padding: 20px 40px;
            border-radius: 15px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
            min-width: 250px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .feature-section {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .feature-section.active {
            display: block;
        }

        .logout-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #4eff91;
            color: #1e3c72;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 500;
            margin-top: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 255, 145, 0.3);
        }

        .logout-btn:hover {
            background: #3be47d;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 255, 145, 0.4);
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Notification Styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: #1e3c72;
            z-index: 1000;
            animation: slideIn 0.5s ease;
            backdrop-filter: blur(10px);
        }

        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-dashboard">
            <div class="user-info">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></h1>
                <div class="virtual-number">
                    <?php echo htmlspecialchars($_SESSION['phone_number'] ?? 'No number assigned'); ?>
                </div>
                <div class="status">Active</div>
            </div>

            <div class="feature-buttons">
                <button class="feature-btn" onclick="showSection('forwarding')">
                    Call Forwarding Settings
                </button>
            </div>

            <div id="forwarding-section" class="feature-section active">
                <?php 
                try {
                    if (file_exists('sections/call_forwarding.php')) {
                        include 'sections/call_forwarding.php';
                    } else {
                        throw new Exception('Call forwarding section not found');
                    }
                } catch (Exception $e) {
                    echo '<div class="error-message">Error loading call forwarding settings</div>';
                }
                ?>
            </div>

            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        try {
            const section = document.getElementById('forwarding-section');
            if (section) {
                section.classList.add('active');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    function showNotification(message) {
        try {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        } catch (error) {
            console.error('Notification error:', error);
        }
    }
    </script>
</body>
</html>
