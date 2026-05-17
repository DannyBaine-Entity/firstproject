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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: all 0.3s ease;
        }

        .login-container:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .login-container h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
            font-weight: 700;
        }

        .login-container h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2ecc71);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        .login-container label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 20px;
            font-size: 14px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        .login-container input[type="submit"] {
            width: 100%;
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .login-container input[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .login-container p {
            color: #2c3e50;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .login-container a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-container a:hover {
            color: #2980b9;
        }

        .message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: 500;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <!-- Display message if there is one -->
    <?php if($message != "") {
        $messageClass = (strpos($message, 'successful') !== false) ? 'success' : 'error';
        echo "<p class='message $messageClass'>$message</p>";
    } ?>

    <!-- Login form -->
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <!-- Submit button -->
        <input type="submit" name="submit" value="Login">
    </form>

    <!-- Link to registration page -->
    <p>Don't have an account? <a href="pdo.php">Register here</a></p>
</div>