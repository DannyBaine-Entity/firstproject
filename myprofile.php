<?php

include "connection.php";
include "connection2.php";

// CHECK IF USER IS LOGGED IN
if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

try {
    $stmt = $pdo2->prepare("SELECT * FROM students_info WHERE email = ?");
    $stmt->execute([$_SESSION['email']]);
    $student = $stmt->fetch();

    if (!$student) {
        echo "<script>alert('Your profile is not set up yet. Please contact the administrator.'); window.location.href = 'studentdashboard.php';</script>";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
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
    <h1>My Profile</h1>

    <h3>Profile Information</h3>
    <?php if($student['image']) { ?>
        <img src="<?php echo $student['image']; ?>" alt="Profile Image" width="150"><br><br>
    <?php } ?>
    
    <p><strong>Student ID:</strong> <?php echo $student['id']; ?></p>
    <p><strong>First Name:</strong> <?php echo $student['first_name']; ?></p>
    <p><strong>Last Name:</strong> <?php echo $student['last_name']; ?></p>
    <p><strong>Age:</strong> <?php echo $student['age']; ?></p>
    <p><strong>Grade:</strong> <?php echo $student['grade']; ?></p>
    <p><strong>Enrollment Date:</strong> <?php echo date('d-m-Y', strtotime($student['enrollment_date'])); ?></p>
    <p><strong>Gender:</strong> <?php echo $student['gender']; ?></p>
    <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
    <p><a href="uploadimage.php">Upload/Change Profile Image</a></p>
    <p><a href="changepassword.php">Change Password</a></p>
</div>

</body>
</html>