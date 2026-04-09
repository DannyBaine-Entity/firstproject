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

        .card {
            background: #f4f4f4;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
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