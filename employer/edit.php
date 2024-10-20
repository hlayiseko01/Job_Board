<?php
session_start();
include('../config.php');

// Check if the employer is logged in
if (!isset($_SESSION['Name'])) {
    header("Location: login.php");
    exit();
}

// Get the employer's name from the session
$employer_name = $_SESSION['Name'];

// Check if job_id is provided
if (!isset($_GET['job_id'])) {
    echo "Invalid job ID.";
    exit();
}

$job_id = $_GET['job_id'];

// Fetch the job details to pre-fill the form
$sql = "SELECT title, description, requirements, salary, street, suburb, city FROM jobs WHERE id = ? AND employer_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $job_id, $employer_name);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();

if (!$job) {
    echo "Job not found or you do not have permission to edit this job.";
    exit();
}

// Handle form submission to update job details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $salary = $_POST['salary'];
    $street = $_POST['street'];
    $suburb = $_POST['suburb'];
    $city = $_POST['city'];

    $update_sql = "UPDATE jobs SET title = ?, description = ?, requirements = ?, salary = ?, street = ?, suburb = ?, city = ? WHERE id = ? AND employer_name = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssssis", $title, $description, $requirements, $salary, $street, $suburb, $city, $job_id, $employer_name);

    if ($stmt->execute()) {
        echo "<p>Job updated successfully!</p>";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p>Error updating job: " . $conn->error . "</p>";
    }
}

$stmt->close();
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <title>Edit Job</title>
</head>
<body>
<div class="container">
    <h1>Edit Job</h1>

    <!-- Pre-filled form for editing the job -->
    <form action="edit.php?job_id=<?php echo $job_id; ?>" method="POST">
        <label for="title">Job Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required>

        <label for="description">Job Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($job['description']); ?></textarea>

        <label for="requirements">Requirements:</label>
        <textarea id="requirements" name="requirements" required><?php echo htmlspecialchars($job['requirements']); ?></textarea>

        <label for="salary">Salary:</label>
        <input type="text" id="salary" name="salary" value="<?php echo htmlspecialchars($job['salary']); ?>" required>

        <label for="street">Street Address:</label>
        <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($job['street']); ?>" required>

        <label for="suburb">Suburb:</label>
        <input type="text" id="suburb" name="suburb" value="<?php echo htmlspecialchars($job['suburb']); ?>" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($job['city']); ?>" required>

        <input type="submit" value="Update Job">
    </form>

    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>

