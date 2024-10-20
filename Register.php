<?php
session_start();
include "config.php";

$error = ''; // Variable to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    // Collect the form inputs
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $city = trim($_POST['city']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $user_type = trim($_POST['user_type']);

    // Validation: Check if all fields are filled in
    if (empty($name)) {
        $error = "Please enter your name.";
    } elseif (empty($surname)) {
        $error = "Please enter your surname.";
    } elseif (empty($email)) {
        $error = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (empty($city)) {
        $error = "Please enter your city.";
    } elseif (empty($password)) {
        $error = "Please enter a password.";
    } elseif (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/\d/", $password) || !preg_match("/[@$!%*?&]/", $password)) {
        // Validate password: at least 8 characters, 1 uppercase, 1 lowercase, 1 number, and 1 special character
        $error = "Password must be at least 8 characters long and contain one uppercase letter, one lowercase letter, one number, and one special character.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if the email is already registered
        $email_check_sql = "SELECT id FROM clients WHERE Email = ?";
        $stmt = $conn->prepare($email_check_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "An account with this email already exists.";
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the user into the database
            $query = "INSERT INTO clients (Name, Surname, Email, City, Password, UserType)
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssss", $name, $surname, $email, $city, $hashedPassword, $user_type);

            if ($stmt->execute()) {
                echo "<span style='color: green;'>You have successfully registered. You can now log in.</span>";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }

        $stmt->close();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <title>Register</title>
</head>
<body>
<div class="form-container">
    <h2>Register</h2>

    <!-- Display error message -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="Register.php" method="POST" class="register-form">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>

        <label for="surname">Surname</label>
        <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($surname ?? ''); ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>

        <label for="city">City</label>
        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city ?? ''); ?>" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required
               pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
               title="Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character.">

        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required
               pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
               title="Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character.">

        <label for="user_type">User Type</label>
        <select id="user_type" name="user_type" required>
            <option value="job_seeker" <?php if (isset($user_type) && $user_type === 'job_seeker') echo 'selected'; ?>>Job Seeker</option>
            <option value="employer" <?php if (isset($user_type) && $user_type === 'employer') echo 'selected'; ?>>Employer</option>
        </select><br><br>

        <input type="submit" value="Register" name="register"><br>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
</div>
</body>
</html>


