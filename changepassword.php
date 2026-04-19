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