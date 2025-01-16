<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Grasshopper</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #4E73DF 0%, #224abe 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px 50px;
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 700;
        }
        .input-group {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }
        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 2px #00E676;
        }
        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 50px;
            background: #00E676;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .btn:hover {
            background: #00C853;
            transform: translateY(-3px);
            box-shadow: 0 14px 24px rgba(0,0,0,0.15);
        }
        .btn:active {
            transform: translateY(1px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form action="login_handler.php" method="post">
            <h2>Login</h2>
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
