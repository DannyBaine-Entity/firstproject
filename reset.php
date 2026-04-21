<?php
  include "conn.php";

try {
 

    if(isset($_POST['reset'])) {
        $email = $_POST['email'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];


          // CHECK IF EMAIL EXISTS
            $stmtEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmtEmail->execute([$email]);
            $emailExists = $stmtEmail->fetch(PDO::FETCH_ASSOC);

            if($emailExists == 0) {
                echo "<script>alert('Email does not exist!');</script>";
            } 

        else {
            if($new_password == $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
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
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: #333;
            color: white;
            position: fixed;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        /* MAIN CONTENT */
        .main {
            margin-left: 200px;
            padding: 20px;
        }

        .logout {
            color: red;
        }
    </style>
</head>
<body>


<!-- MAIN CONTENT -->

<div class="main">

    <h1>Reset Password</h1>

    <form method="POST">
           New Password:<br>
        <input type="text" name="email" required><br><br>
        
        New Password:<br>
        <input type="password" name="new_password" required><br><br>

        Confirm New Password:<br>
        <input type="password" name="confirm_password" required><br><br>

        <input type="submit" name="reset" value="Change Password">
    </form>
</div>

</body>
</html>