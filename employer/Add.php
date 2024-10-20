<?php
session_start();
include('../config.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $requirements = $_POST['requirements'];
    $salary = $_POST['salary'];
    $street = $_POST['street'];
    $suburb = $_POST['suburb'];
    $city = $_POST['city'];
    $employer_name = $_SESSION['Name']; // Get employer's name from session

    // Prepare the SQL query to insert the job into the database
    $sql = "INSERT INTO jobs (title, description, requirements, salary, street, suburb, city, employer_name) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare a prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters (s for string, i for integer, d for double)
        $stmt->bind_param("ssssssss", $title, $description, $requirements, $salary, $street, $suburb, $city, $employer_name);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<p>Job posted successfully!</p>";

        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a New Job</title>
    <link rel="stylesheet" href="Add.css">
</head>
<body>
<h1>Post a New Job</h1>
<form action="Add.php" method="POST">
    <label for="title">Job Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="description">Job Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="requirements">Requirements:</label>
    <textarea id="requirements" name="requirements" required></textarea>

    <label for="salary">Salary:</label>
    <input type="text" id="salary" name="salary" required>

    <label for="street">Street Address:</label><br>
    <input type="text" id="street" name="street" required>

    <label for="street">suburb:</label><br>
    <input type="text" id="suburb" name="suburb" required>

    <label for="city">City:</label>
    <input type="text" id="city" name="city" required>

    <input type="submit" value="Post Job">
</form>

<!-- Back button -->
<button class="back-btn"><a href="dashboard.php">Back</a></button>

</body>
</html>
