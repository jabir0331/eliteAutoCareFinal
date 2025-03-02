<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="icon" href="<?= ROOT ?>/assets/images/logo.webp">
    <title>Page Not Found</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
            text-align: center;
            padding: 20px;
        }
        h1 { 
            color: #333;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        p { 
            color: #666;
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .back-button {
            background-color: #0066cc;
            color: white;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #0052a3;
        }
    </style>
</head>
<body>
    <h1>404 - Page Not Found</h1>
    <p>The page you're looking for doesn't exist or has been moved.</p>
    <a href="<?= ROOT ?>/RegisteredUserHome" class="back-button">Back to Home</a>
</body>
</html>