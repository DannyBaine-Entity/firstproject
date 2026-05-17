<?php
  include "connection.php";

try {
 

    if(isset($_POST['reset'])) {
        $email = $_POST['email'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];


          // CHECK IF EMAIL EXISTS
            $stmtEmail = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmtEmail->execute([$email]);
            $emailExists = $stmtEmail->fetch(PDO::FETCH_ASSOC);

            if($emailExists == 0) {
                echo "<script>alert('Email does not exist!');</script>";
            } 

        else {
            if($new_password == $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
                $stmt->execute([$hashed_password, $email]);
                echo "<script>
                alert('Password reset successfully!');
                window.location.href = 'index.php';
              </script>";
                exit();
            } else {
                echo "<script>
                alert('New passwords do not match!');
              </script>";
            }
        
    }

 }
 }catch (PDOException $e) {
    echo "<script>
    alert('Error: " . addslashes($e->getMessage()) . "');
  </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
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

        .reset-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: all 0.3s ease;
        }

        .reset-container:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .reset-container h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
            font-weight: 700;
        }

        .reset-container h1::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2ecc71);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        .reset-container label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 20px;
            font-size: 14px;
        }

        .reset-container input[type="email"],
        .reset-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .reset-container input[type="email"]:focus,
        .reset-container input[type="password"]:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        .reset-container input[type="submit"] {
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

        .reset-container input[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .reset-container p {
            color: #2c3e50;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .reset-container a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .reset-container a:hover {
            color: #2980b9;
        }
    </style>
</head>
<body>

<div class="reset-container">
    <h1>Reset Password</h1>

    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <input type="submit" name="reset" value="Reset Password">
    </form>
    
    <p>Remember your password? <a href="login.php">Login here</a></p>
</div>

</body>
</html>