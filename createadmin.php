<?php
include "connection.php";

// CHECK IF USER IS LOGGED IN AND IS ADMIN
if(!isset($_SESSION['email']) || $_SESSION['rolez'] != 1) {
    header("Location: index.php");
    exit();
}

try {
    if(isset($_POST['create'])) {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $rolez = $_POST['rolez'];
    
        if(empty($username) || empty($email) || empty($password) || empty($rolez)) {
            $message = "<script>alert('All fields are required.');</script>";
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "<script>alert('Invalid email format.');</script>";
        } else {
            // CHECK IF EMAIL EXISTS
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $message = "<script>alert('Email already exists.');</script>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, rolez) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $email, $hashed_password, $rolez]);
                $message = "<script>alert('Admin created successfully.');</script>";
            }
        }
    }
} catch (PDOException $e) {
    $message = "<script>alert('Error: " . $e->getMessage() . "');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin</title>
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
<?php include 'sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="main">
    <h1>Create New Admin</h1>

    <form method="POST">
        Username:<br>
        <input type="text" name="username" required><br><br>

        Email:<br>
        <input type="email" name="email" required><br><br>

        Password:<br>
        <input type="password" name="password" required><br><br>

        Role:<br>
        <select name="rolez" required>
            <option value="1">Admin</option>
        </select><br><br>

        <input type="submit" name="create" value="Create User">
    </form>

</div>

</body>
</html>