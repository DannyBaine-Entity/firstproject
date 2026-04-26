<?php
include "connection.php";

try {
    // CHECK IF FORM IS SUBMITTED
    if(isset($_POST['submit'])) {

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // =========================
        // VALIDATION
        // =========================
        if(empty($email) || empty($password)) {
            echo "<script>alert('All fields are required!');</script>";
        } 
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format!');</script>";
        } 
        else {

            // =========================
            // CHECK USER IN DATABASE
            // =========================
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])) {

                // =========================
                // STORE SESSION DATA
                // =========================
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['rolez'] = $user['rolez'];

                // =========================
                // SIMPLE ROLE-BASED REDIRECT
                // =========================
                if($user['rolez'] == 1) {
                    echo "<script>
                            alert('Login successful!');
                            window.location.href = 'admindashboard.php';
                          </script>";
                } else {
                    echo "<script>
                            alert('Login successful!');
                            window.location.href = 'studentdashboard.php';
                          </script>";
                }

                exit();

            } else {
                echo "<script>alert('Invalid email or password!');</script>";
            }
        }
    }

} catch(PDOException $e) {
    echo "<script>alert('Login failed!');</script>";
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
            background-color: #f9f9f9;
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
        }

        .login-container h2 {
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }

        .login-container label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .login-container input[type="email"]:focus,
        .login-container input[type="password"]:focus {
            outline: none;
            border-color: #3498db;
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
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .login-container input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .login-container p {
            text-align: center;
            color: #555;
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
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <form method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" name="submit" value="Login">
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

</body>
</html>