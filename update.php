<?php

include "connection2.php";

// GET ID AND FETCH DATA
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmtCheck = $pdo2->prepare("SELECT * FROM students_info WHERE student_id = ?");
    $stmtCheck->execute([$id]);

    $stmt = $pdo2->prepare("SELECT * FROM students_info WHERE student_id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$student) {
        echo "<script>alert('Record not found!');
         window.location.href = 'viewrecords.php';</script>";
        exit;
    }
}

// UPDATE DATA
if(isset($_POST['update'])) {

    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $grade = $_POST['grade'];
    $enrollment_date = $_POST['enrollment_date'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];

    $image_path = $student['image']; // default to existing

    // HANDLE IMAGE UPLOAD
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

    $stmt = $pdo2->prepare("UPDATE students_info
        SET first_name=?, last_name=?, age=?, grade=?, enrollment_date=?, gender=?, email=?, image=?
        WHERE student_id=?");

    $stmt->execute([$first_name,$last_name,$age,$grade,$enrollment_date,$gender,$email,$image_path,$id]);

    echo "<script>
            alert('Record updated successfully!');
            window.location.href = 'viewrecords.php';
          </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>

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

        /* MAIN */
        .main {
            margin-left: 250px;
            padding: 40px 30px;
            min-height: 100vh;
        }

        .main h2 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .main h2::after {
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
            max-width: 600px;
        }

        form label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            margin-top: 15px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        select {
            padding: 12px;
            width: 100%;
            margin-bottom: 15px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 14px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        input[type="file"]:focus,
        select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group img {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            margin-bottom: 15px;
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

            .main h2 {
                font-size: 22px;
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

            .main h2 {
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
<?php include 'sidebar.php'; ?>

<div class="main">

<h2>Update Student</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?php echo $student['student_id']; ?>">

    First Name:<br>
    <input type="text" name="first_name" value="<?php echo $student['first_name']; ?>"><br>

    Last Name:<br>
    <input type="text" name="last_name" value="<?php echo $student['last_name']; ?>"><br>

    Age:<br>
    <input type="number" name="age" value="<?php echo $student['age']; ?>"><br>

    Grade:<br>
    <input type="text" name="grade" value="<?php echo $student['grade']; ?>"><br>

    Enrollment Date:<br>
    <input type="date" name="enrollment_date" value="<?php echo $student['enrollment_date']; ?>"><br>

    Gender:<br>
    <select name="gender">
        <option value="male" <?php if($student['gender']=="male") echo "selected"; ?>>Male</option>
        <option value="female" <?php if($student['gender']=="female") echo "selected"; ?>>Female</option>
    </select><br>

    Email:<br>
    <input type="email" name="email" value="<?php echo $student['email']; ?>"><br><br>

    Image:<br>
    <?php if($student['image']) { ?>
        <img src="<?php echo $student['image']; ?>" width="100" alt="Current Image"><br>
    <?php } ?>
    <input type="file" name="image"><br><br>

    <input type="submit" name="update" value="Update Student">

</form>

</div>

</body>
</html>