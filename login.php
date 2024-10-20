<?php
session_start();
include "config.php";

$error = ''; // Variable to store error messages

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Collect the form inputs
    $email = trim($_POST['Email']);
    $password = trim($_POST['Password']);

    // Validation: Check if both fields are filled in
    if (empty($email)) {
        $error = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Validate email format
        $error = "Please enter a valid email address.";
    } elseif (empty($password)) {
        $error = "Please enter your password.";
    } else {
        // If no errors, proceed with login
        $sql = "SELECT Name, Surname, Password, UserType, City FROM clients WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user with the provided email exists
        if ($row = $result->fetch_assoc()) {
            // Verify the password
            if (password_verify($password, $row['Password'])) {
                // Set session variables
                $_SESSION['Name'] = $row['Name'];
                $_SESSION['Surname'] = $row['Surname'];
                $_SESSION['City'] = $row['City'];  // Store the city in the session
                $_SESSION['UserType'] = $row['UserType']; // Store user type for conditional redirection

                // Redirect based on UserType
                if ($row['UserType'] == 'employer') {
                    header("Location: employer/dashboard.php");
                } else {
                    header("Location: index.php"); // Redirect job seekers to the index page
                }
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }

        $stmt->close();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
<form action="login.php" method="post" class="login-form">
    <h2>Login</h2>

    <!-- Display error message -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <label>Email
        <input type="email" name="Email" placeholder="email" required>
    </label><br>

    <label>Password
        <input type="password" name="Password" placeholder="password" required>
    </label><br>

    <input type="submit" value="Login" name="login"><br>

    <p>Don't have an account? <a href="Register.php">Register</a></p>
</form>
</body>
</html>


