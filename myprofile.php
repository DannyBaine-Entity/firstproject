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

        .main h3 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 22px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }

        /* PROFILE IMAGE */
        .main img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #3498db;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        /* PROFILE INFO */
        .main p {
            color: #555;
            font-size: 16px;
            margin: 15px 0;
            line-height: 1.6;
        }

        .main p strong {
            color: #2c3e50;
            font-weight: 600;
        }

        /* LINKS */
        .main a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-weight: 500;
            margin-right: 10px;
        }

        .main a:hover {
            background-color: #2980b9;
        }

        .logout {
            background-color: #e74c3c;
        }

        .logout:hover {
            background-color: #c0392b;
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
    <img src="<?php echo $student['image'] ?: 'default-profile.jpg'; ?>" alt="Profile Image" width="150"><br><br>
    
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