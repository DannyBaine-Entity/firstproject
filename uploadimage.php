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
                $stmt = $pdo2->prepare("UPDATE students_info SET image = ? WHERE email = ?");
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

        /* FORM STYLING */
        .main input[type="file"],
        .main input[type="submit"] {
            margin: 15px 0;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #bdc3c7;
        }

        .main input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
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
    <h1>Upload Image</h1>

    <form method="POST" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="image" id="image" required>
        <input type="submit" value="Upload Image" name="upload">
    </form>

</div>

</body>
</html>