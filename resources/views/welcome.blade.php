<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Your App</title>
    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Styles for the welcome section */
        .welcome-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('your-background-image.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            text-align: center;
            padding: 100px 0;
        }

        .welcome-heading {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .welcome-description {
            font-size: 18px;
            margin-bottom: 40px;
        }

        .welcome-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .welcome-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="welcome-section">
    <h1 class="welcome-heading">Welcome to Your App</h1>
    <p class="welcome-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    <a href="{{ route('home') }}" class="welcome-button">Get Started</a>
</div>

<!-- Your app content goes here -->

</body>
</html>
