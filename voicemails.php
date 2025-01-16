<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config/db.php';

// Fetch voicemails
$stmt = $pdo->prepare("SELECT * FROM voicemails WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$voicemails = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voicemails - Grasshopper</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Copy existing styles from dashboard.php */
        .voicemail-list {
            margin: 20px 0;
        }
        
        .voicemail-item {
            background: rgba(255, 255, 255, 0.15);
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .voicemail-info {
            flex: 1;
        }
        
        .back-btn {
            display: inline-block;
            padding: 12px 25px;
            background: #4E73DF;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin: 10px 0;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Voicemails</h1>
        
        <div class="voicemail-list">
            <?php if (empty($voicemails)): ?>
                <p>No voicemails found.</p>
            <?php else: ?>
                <?php foreach ($voicemails as $voicemail): ?>
                    <div class="voicemail-item">
                        <div class="voicemail-info">
                            <p>From: <?php echo htmlspecialchars($voicemail['caller_number']); ?></p>
                            <p>Date: <?php echo date('M d, Y H:i', strtotime($voicemail['created_at'])); ?></p>
                        </div>
                        <audio controls src="<?php echo htmlspecialchars($voicemail['message_path']); ?>"></audio>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html> 
