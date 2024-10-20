<?php
session_start();
include('../config.php');

// Check if the employer is logged in
if (!isset($_SESSION['Name'])) {
    header("Location: ../login.php");
    exit();
}

// Get the employer's name from the session
$employer_name = $_SESSION['Name'];
// Handle job deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_job_id'])) {
    $job_id_to_delete = $_POST['delete_job_id'];

    // Prepare and execute the delete query
    $delete_sql = "DELETE FROM jobs WHERE id = ? AND employer_name = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("is", $job_id_to_delete, $employer_name);
    if ($stmt->execute()) {
        echo "<p>Job deleted successfully!</p>";
    } else {
        echo "<p>Error deleting job: " . $conn->error . "</p>";
    }
    $stmt->close();
}
// Fetch the jobs posted by the employer from the database using employer's name
$sql = "SELECT id, title, description, salary, posted_at FROM jobs WHERE employer_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $employer_name);
$stmt->execute();
$result = $stmt->get_result();
$jobs = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dash.css">
    <title>DASHBOARD</title>
</head>
<body>
<div class="container">
    <h1>Welcome, <?php echo $_SESSION['Name']; ?></h1>
    <div class="button-container">
        <a href="Add.php" class="btn">Post a New Job</a>
        <a href="../about.php" class="about-btn">About</a>
    </div>
    <h2>Your Job Listings</h2>
    <div class="job-listings">
        <?php if (count($jobs) > 0): ?>
            <ul>
                <?php foreach ($jobs as $job): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                        <p><?php echo htmlspecialchars($job['description']); ?></p>
                        <p><strong>Salary:R</strong> <?php echo htmlspecialchars($job['salary']); ?> p/m</p>
                        <p><strong>Posted on:</strong> <?php echo date('F j, Y', strtotime($job['posted_at'])); ?></p>

                        <a href="edit.php?job_id=<?php echo $job['id']; ?>" class="edit-btn">Edit Job</a>

                        <form action="dashboard.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_job_id" value="<?php echo $job['id']; ?>">
                            <button type="submit" class="delete-btn">Delete Job</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No jobs posted yet.</p>
        <?php endif; ?>
    </div>
</div>

<form action="../logout.php" method="POST" style="display:inline;">
    <button type="submit" class="logout-btn">Log Out</button>
</form>

</body>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Local Job Board. All rights reserved.</p>
</footer>
</html>

