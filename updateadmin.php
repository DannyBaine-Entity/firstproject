<?php

include "connection.php";

// CHECK IF USER IS LOGGED IN AND IS ADMIN
if(!isset($_SESSION['email']) || $_SESSION['rolez'] != 1) {
    header("Location: index.php");
    exit();
}

// GET ID AND FETCH DATA
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND rolez = 1");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$user) {
        echo "<script>alert('Record not found!');
         window.location.href = 'createadmin.php';</script>";
        exit;
    }
}

// UPDATE DATA
if(isset($_POST['update'])) {

    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $image_path = $user['image']; // default to existing

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if it's an image and allowed format
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        $allowed = array("jpg", "jpeg", "png", "gif");
        if($check !== false && in_array($imageFileType, $allowed) && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        }
        }
        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, image = ? WHERE id = ? AND rolez = 1");
        $stmt->execute([$username, $email, $image_path, $id]);

        echo "<script>
                alert('Admin updated successfully!');
                window.location.href = 'createadmin.php';
                </script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin</title>
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
    <h1>Update Admin</h1>

    <form method="POST">
    
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
    
        Username:<br>
        <input type="text" name="username" value="<?php echo $user['username']; ?>"><br>
    
        Email:<br>
        <input type="email" name="email" value="<?php echo $user['email']; ?>"><br><br>
    
        <input type="submit" name="update" value="Update Admin">
    
    </form>

    <a href="createadmin.php">Back to Admin List</a>

</div>

</body>
</html>
