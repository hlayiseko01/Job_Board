<?php
session_start();
include "config.php";

// Check if the user is logged in and is a job seeker
if (!isset($_SESSION['Name']) || $_SESSION['UserType'] != 'job_seeker') {
    header("Location: login.php");
    exit();
}

// Ensure 'City' is set in the session
$job_seeker_city = isset($_SESSION['City']) ? $_SESSION['City'] : null;

if ($job_seeker_city) {
    // Fetch jobs from the database that match the job seeker's city
    $sql = "SELECT title, description,requirements, salary, street, suburb, city, posted_at FROM jobs WHERE city = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $job_seeker_city);
    $stmt->execute();
    $result = $stmt->get_result();
    $jobs = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle the case where the city is not set
    $jobs = []; // No jobs to display since the city is not set
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Style.css">
    <title>Home</title>
</head>
<body>
<div class="button-container">
    <button class="nav-button"><a href="index.php">Home</a></button>
    <button class="nav-button"><a href="Search.php">Search</a></button>
    <button class="nav-button"><a href="about.php">About</a></button>
    <button class="nav-button logout-button"><a href="logout.php">Log Out</a></button>
</div>


<div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['Name'] ?? ''); ?></h1>
    <h2>Jobs Available in <?php echo htmlspecialchars($job_seeker_city ?? ''); ?></h2>

    <?php if (count($jobs) > 0): ?>
        <ul>
            <?php foreach ($jobs as $job): ?>
                <li>
                    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                    <p><?php echo htmlspecialchars($job['description']); ?></p>
                    <p><strong>requirements: </strong><?php echo htmlspecialchars($job['requirements']); ?></p>
                    <p><strong>Salary:R</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($job['street'] . ', ' . $job['suburb'] . ', ' . $job['city']); ?></p>
                    <p><strong>Posted on:</strong> <?php echo date('F j, Y', strtotime($job['posted_at'])); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No jobs found in your city.</p>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Local Job Board. All rights reserved.</p>
</footer>
</body>
</html>

