<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grasshopper</title>
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
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            overflow: hidden;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px 60px;
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn {
            display: inline-block;
            width: 100%;
            padding: 15px 30px;
            margin: 10px 0;
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
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Grasshopper</h1>
        <p style="margin-bottom: 30px; font-weight: 400;">Call Managing Company</p>
        <a href="signup.php" style="text-decoration: none; display: block;">
            <button class="btn">Sign Up</button>
        </a>
        <a href="login.php" style="text-decoration: none; display: block;">
            <button class="btn">Login</button>
        </a>
    </div>
</body>
</html>
