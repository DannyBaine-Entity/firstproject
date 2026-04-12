<?php

include "connection2.php";

// GET ID AND FETCH DATA
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmtCheck = $conn->prepare("SELECT * FROM students_info WHERE student_id = ?");
    $stmtCheck->execute([$id]);

    $stmt = $conn->prepare("SELECT * FROM students_info WHERE student_id = ?");
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

    $stmt = $conn->prepare("UPDATE students_info
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
        body {
            margin: 0;
            font-family: Arial;
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

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        /* MAIN */
        .main {
            margin-left: 200px;
            padding: 20px;
        }

        input, select {
            padding: 8px;
            width: 300px;
            margin-bottom: 10px;
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