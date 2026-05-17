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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #333;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: white;
            position: fixed;
            padding-top: 30px;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 40px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #ecf0f1;
        }

        .sidebar a {
            display: block;
            color: #ecf0f1;
            padding: 15px 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-weight: 500;
            margin: 5px 0;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #3498db;
            padding-left: 25px;
        }

        .sidebar a.logout {
            color: #e74c3c;
            margin-top: 30px;
        }

        .sidebar a.logout:hover {
            background-color: rgba(231, 76, 60, 0.1);
            border-left-color: #e74c3c;
        }

        /* MAIN CONTENT */
        .main {
            margin-left: 250px;
            padding: 40px 30px;
            min-height: 100vh;
        }

        .main h1 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .main h1::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2ecc71);
            margin-top: 15px;
            border-radius: 2px;
        }

        /* FORM STYLING */
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }

        form label,
        form p {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .main input[type="file"] {
            padding: 12px;
            width: 100%;
            margin-bottom: 20px;
            border: 2px dashed #3498db;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .main input[type="file"]:hover {
            border-color: #2980b9;
        }

        .main input[type="file"]:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        .main input[type="submit"] {
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

        .main input[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .logout {
            color: #e74c3c;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 180px;
            }

            .main {
                margin-left: 180px;
                padding: 20px;
            }

            .main h1 {
                font-size: 24px;
            }

            form {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 140px;
            }

            .main {
                margin-left: 140px;
                padding: 15px;
            }

            .main h1 {
                font-size: 18px;
            }

            .sidebar a {
                padding: 10px 12px;
                font-size: 13px;
            }
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