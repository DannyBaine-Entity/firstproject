<?php
include "connection2.php";

// CHECK IF USER IS LOGGED IN
if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}



if(isset($_POST['upload'])) {
    // Check if file was uploaded without errors
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_file = "uploads/" . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if it's a real image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        $allowed = array("jpg", "jpeg", "png", "gif");
        
        $maxsize = 5 * 1024 * 1024; // 5MB
     
        if($check !== false && in_array($imageFileType, $allowed)&& ($_FILES["image"]["size"] <= $maxsize)) {
      
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {    
                $email = $_SESSION['email'];
                $stmt = $pdo->prepare("UPDATE students_info SET image = ? WHERE email = ?");
                $stmt->execute([$target_file, $email]);

                echo "<script>alert('Image uploaded successfully.');
                  window.location.href = 'myprofile.php';
                </script>";
            } else {
                echo "<script>alert('Error uploading file.');</script>";
            }
        } else {
            echo "<script>alert('File is not an allowed image type.');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
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
    <h1>Upload Image</h1>

    <form method="POST" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="image" id="image" required>
        <input type="submit" value="Upload Image" name="upload">
    </form>

</div>

</body>
</html>