<?php

// ==========================================
// Student Dashboard
// ==========================================

session_start();

// CHECK IF USER IS LOGGED IN
if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
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
            margin-bottom: 10px;
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

        /* CARDS */
        .card {
            background: white;
            padding: 30px;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-top: 4px solid #3498db;
        }

        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .card p {
            font-size: 15px;
            line-height: 1.6;
            color: #555;
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

            .card {
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
    <h1>Welcome, <?php echo $username; ?> 👋</h1>

    <div class="card">
        <h3>Overview</h3>
        <p>This is your student dashboard.</p>
    </div>

    <div class="card">
        <h3>Notifications</h3>
        <p>No new notifications.</p>
    </div>
</div>

</body>
</html>