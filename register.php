<?php
// ==========================================
// Simple Registration with Email Check + JS Alert
// ==========================================

include "connection.php"; // Database connection

try {

    if(isset($_POST['submit'])) {

        // GET INPUTS SAFELY
          $username = trim($_POST['username']);
          $email = trim($_POST['email']);
          $password = $_POST['password'];

        // VALIDATION
        if(empty($username) || empty($email) || empty($password)) {
            echo "<script>alert('All fields are required!');</script>";
        } 
        elseif(strlen($password) < 6) {
            echo "<script>alert('Password must be at least 6 characters!');</script>"; //CHECKS IF THE PASSWORD IS LESS THAN 6
        }
        elseif(!preg_match('/[A-Z]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)){
                echo "<script>alert('Password must be at least one capital and special character');</script>";
        }
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Invalid email format!');</script>";
        }
        elseif($_POST['password'] !== $_POST['confirm_password']) {
            echo "<script>alert('Passwords do not match!');</script>";
        }

        else {
            // CHECK IF EMAIL EXISTS
            $stmtEmail = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmtEmail->execute([$email]);
            $emailExists = $stmtEmail->fetch(PDO::FETCH_ASSOC);

            if($emailExists) {
                echo "<script>alert('Email already exists!');</script>";
            } 
            else {
                // INSERT USER
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                $stmtInsert = $pdo->prepare($sql);
                $stmtInsert->execute([$username, $email, $hashedPassword]);

                // SUCCESS MESSAGE + REDIRECT
                echo "<script>
                        alert('Registration successful!');
                        window.location.href = 'index.php';
                      </script>";
                exit();
            }
        }
    }

}  catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .register-container h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }

        .register-container label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .register-container input[type="text"]:focus,
        .register-container input[type="email"]:focus,
        .register-container input[type="password"]:focus {
            outline: none;
            border-color: #3498db;
        }

        .register-container input[type="submit"] {
            width: 100%;
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .register-container input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Register</h2>

    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <input type="submit" name="submit" value="Register">
    </form>
</div>

</body>
</html>