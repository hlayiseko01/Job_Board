<?php
session_start();
include "config.php";

// Initialize an empty array to hold job search results
$jobs = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search_city = $_POST['search_city'];

    // Query the database for jobs in the searched city
    $sql = "SELECT title, description,requirements, salary, street, suburb, city, posted_at FROM jobs WHERE city LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_city = "%$search_city%";  // Use wildcards to allow partial matches
    $stmt->bind_param("s", $search_city);
    $stmt->execute();
    $result = $stmt->get_result();
    $jobs = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Style.css">
    <title>Search</title>
</head>
<body>
<div class="button-container">
    <button class="nav-button"><a href="index.php">Home</a></button>
    <button class="nav-button"><a href="Search.php">Search</a></button>
    <button class="nav-button logout-button"><a href="logout.php">Log Out</a></button>
</div>


<div class="container">
    <h1>Search for Jobs by City</h1>

    <!-- Search Bar -->
    <form action="Search.php" method="POST" class="search-form">
        <label for="search_city">Enter City:</label>
        <input type="text" id="search_city" name="search_city" required>
        <input type="submit" name="search" value="Search">
    </form>

    <!-- Displaying the Search Results -->
    <h2>Search Results</h2>
    <?php if (count($jobs) > 0): ?>
        <ul>
            <?php foreach ($jobs as $job): ?>
                <li>
                    <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                    <p><?php echo htmlspecialchars($job['description']); ?></p>
                    <p><strong>requirements: </strong><?php echo htmlspecialchars($job['requirements']); ?></p>
                    <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?> p/m</p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($job['street'] . ', ' . $job['suburb'] . ', ' . $job['city']); ?></p>
                    <p><strong>Posted on:</strong> <?php echo date('F j, Y', strtotime($job['posted_at'])); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <p>No jobs found in the specified city.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Local Job Board. All rights reserved.</p>
</footer>
</body>
</html>
