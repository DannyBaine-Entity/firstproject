<?php
  include "connection.php";

// CHECK IF USER IS LOGGED IN
if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

try {
 

    if(isset($_POST['change'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        //echo "$current_password, $new_password, $confirm_password";
        //exit;

        // GET CURRENT PASSWORD
        $email = $_SESSION['email'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($current_password, $user['password'])) {
            if($new_password == $current_password) {
                echo "<script>
                alert('New password cannot be the same as your current password!');
              </script>";
            } 
            elseif($new_password == $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
                $stmt->execute([$hashed_password, $email]);
                echo "<script>
                alert('Password changed successfully!');
                window.location.href = 'studentdashboard.php';
              </script>";
                exit();
            } else {
                echo "<script>
                alert('New passwords do not match!');
              </script>";
            }
        } else {
            echo "<script>
            alert('Current password is incorrect!');
          </script>";
        }
    }

} catch (PDOException $e) {
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
    <title>Change Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2c3e50;
            color: white;
            position: fixed;
            padding-top: 30px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar h2 {
            text-align: center;
            padding: 20px;
            font-size: 20px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        /* MAIN CONTENT */
        .main {
            margin-left: 250px;
            padding: 40px;
        }

        .main h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 32px;
        }

        .main p {
            color: #2c3e50;
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* FORM STYLING */
        .main input[type="password"],
        .main input[type="text"] {
            width: 100%;
            max-width: 300px;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
        }

        .main input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 500;
        }

        .main input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .logout {
            color: #e74c3c;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<?php include 'studentsidebar.php'; ?>

<!-- MAIN CONTENT -->

<div class="main">

<?php echo "<p><strong> Welcome, " . $_SESSION['username'] . "</strong></p>"; ?>
    <h1>Change Password</h1>

    <form method="POST">
        Current Password:<br>
        <input type="password" name="current_password" required><br><br>

        New Password:<br>
        <input type="password" name="new_password" required><br><br>

        Confirm New Password:<br>
        <input type="password" name="confirm_password" required><br><br>

        <input type="submit" name="change" value="Change Password">
    </form>
</div>

</body>
</html>