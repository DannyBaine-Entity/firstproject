<?php

$message = "";

try {
    // Create a connection to the database
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
    // Set error mode to show errors (useful for debugging)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Check if the form was submitted
    if(isset($_POST['submit'])) {
        // Get data from the form
        $email = $_POST['email'];
        $password = $_POST['password'];
        // SQL query to find a user with the given email
        $sql = "SELECT * FROM users WHERE email = ?";
        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);
        // Execute the query and pass the email into the ? placeholder
        $stmt->execute([$email]);
        // Fetch the user as an associative array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Check if a user was found in the database
        if($user) {
            // Check if the entered password matches the hashed password in the database
            if(password_verify($password, $user['password'])) {
                // If password is correct
                $message = "Login successful! Welcome " . $user['email'] . ".";
            } else {
                // If password is incorrect
                $message = "Invalid email or password.";
            }
        } else {
            // If no user was found
            $message = "$email does not exist.";
        }
    }
} catch (PDOException $e) {
    // If something goes wrong with the database
    $message = "Login failed!";
}

?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>

<h2>Login</h2>

<!-- Show message -->
<?php if($message != "") echo "<p>$message</p>"; ?>

<!-- Login form -->
<form method="post">
    Email:<br>
    <input type="email" name="email" required><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <input type="submit" name="submit" value="Login">
</form>

<p>Don't have an account? <a href="register.php">Register here</a></p>

</body>
</html>