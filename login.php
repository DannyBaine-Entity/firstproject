<?php
// ==========================================
// Simple Login 
// ==========================================

$message = "";

try {
    // Create a connection to the database
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "root", "");

    // Set error mode to show errors (useful for debugging)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form was submitted
    if(isset($_POST['submit'])) {

        // Get data from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // SQL query to find a user with the given username
        $sql = "SELECT * FROM users WHERE username = ?";

        // Prepare the SQL statement (safer than direct queries)
        $stmt = $conn->prepare($sql);

        // Execute the query and pass the username into the ? placeholder
        $stmt->execute([$username]);

        // Fetch the user as an associative array (column names as keys)
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a user was found in the database
        if($user) {

            // Check if the entered password matches the hashed password in the database
            if(password_verify($password, $user['password'])) {

                // If password is correct
                $message = "Login successful! Welcome " . $user['username'] . ".";

            } else {
                // If password is incorrect
                $message = "Invalid username or password.";
            }

        } else {
            // If no user was found
            $message = "$username does not exist.";
        }
    }

} catch (PDOException $e) {
    // If something goes wrong with the database
    $message = "Login failed!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

    <h2>Login</h2>

    <!-- Display message if there is one -->
    <?php if($message != "") echo "<p>$message</p>"; ?>

    <!-- Login form -->
    <form method="post">

        Username:<br>
        <input type="text" name="username" required><br>

        Password:<br>
        <input type="password" name="password" required><br><br>

        <!-- Submit button -->
        <input type="submit" name="submit" value="Login">

    </form>

    <!-- Link to registration page -->
    <p>Don't have an account? <a href="pdo.php">Register here</a></p>

</body>
</html>