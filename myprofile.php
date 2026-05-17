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

        .main h3 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 22px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
            font-weight: 600;
        }

        /* PROFILE IMAGE */
        .main img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #3498db;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .main img:hover {
            transform: scale(1.05);
        }

        /* PROFILE INFO */
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .main p {
            color: #555;
            font-size: 16px;
            margin: 15px 0;
            line-height: 1.6;
        }

        .main p strong {
            color: #2c3e50;
            font-weight: 600;
            display: inline-block;
            min-width: 140px;
        }

        /* ACTION BUTTONS */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .main a {
            display: inline-block;
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .main a:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .logout:hover {
            background-color: #c0392b;
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

            .profile-card {
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

            .action-buttons {
                flex-direction: column;
            }

            .main a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<?php include 'studentsidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="main">
    <h1>My Profile</h1>

    <div class="profile-card">
        <h3>Profile Information</h3>
        <img src="<?php echo $student['image'] ?: 'default-profile.jpg'; ?>" alt="Profile Image">
        
        <p><strong>Student ID:</strong> <?php echo $student['id']; ?></p>
        <p><strong>First Name:</strong> <?php echo $student['first_name']; ?></p>
        <p><strong>Last Name:</strong> <?php echo $student['last_name']; ?></p>
        <p><strong>Age:</strong> <?php echo $student['age']; ?></p>
        <p><strong>Grade:</strong> <?php echo $student['grade']; ?></p>
        <p><strong>Enrollment Date:</strong> <?php echo date('d-m-Y', strtotime($student['enrollment_date'])); ?></p>
        <p><strong>Gender:</strong> <?php echo $student['gender']; ?></p>
        <p><strong>Email:</strong> <?php echo $student['email']; ?></p>
        
        <div class="action-buttons">
            <a href="uploadimage.php">Upload Profile Image</a>
            <a href="changepassword.php">Change Password</a>
        </div>
    </div>
</div>

</body>
</html>