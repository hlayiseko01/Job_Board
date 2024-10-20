<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Style.css">
    <title>About Us</title>
</head>
<body>
<div class="container">
    <h1>About Local Job Board</h1>

    <p>Welcome to Local Job Board, your one-stop platform for connecting local employers and job seekers.
        We aim to bring together people within the same community, helping job seekers find jobs near them and
        making it easy for employers to hire talent locally.</p>

    <h2>Our Mission</h2>
    <p>Our mission is to simplify the job search process for local job seekers and help businesses find the
        right candidates efficiently. We believe that supporting local talent and businesses strengthens the community
        and fosters growth and opportunity.</p>

    <h2>How It Works</h2>
    <ul>
        <li><strong>For Employers:</strong> Post your job listings quickly and easily, and manage them from your
            personalized dashboard. Our platform allows you to find candidates within your city or surrounding areas.</li>
        <li><strong>For Job Seekers:</strong> Search for jobs by city and connect with local employers. With a few clicks,
            you can find jobs that match your skills and location.
            <br>⚠️YOU STILL HAVE TO VISIT THE PHYSICAL ADDRESS TO APPLY</li>
    </ul>

    <h2>Contact Us</h2>
    <p>If you have any questions or feedback, feel free to reach out to us at <strong>support@localjobboard.com</strong>.</p>

    <!-- Conditional Back Button -->
    <?php if (isset($_SESSION['UserType']) && $_SESSION['UserType'] == 'employer'): ?>
        <a href="employer/dashboard.php">Back to Dashboard</a>
    <?php else: ?>
        <a href="index.php">Back to Home</a>
    <?php endif; ?>
</div>

<!-- Optional: Basic Styling for the About Page -->
<style>
    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
        color: #007BFF;
    }

    p {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    ul {
        list-style-type: disc;
        margin-left: 20px;
    }

    ul li {
        margin-bottom: 10px;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #007BFF;
        font-size: 16px;
        transition: color 0.3s ease;
    }

    a:hover {
        color: #0056b3;
    }
</style>
</body>
</html>

