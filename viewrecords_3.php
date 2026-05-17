<?php

try {
    include 'connection2.php';

    $search = '';
    if(!empty($_GET['search'])) {
        $search = $_GET['search'];
    }

    if($search !== '') {
        $like = '%' . $search . '%';
        $stmt = $pdo2->prepare("SELECT * FROM students_info WHERE first_name LIKE ? OR last_name LIKE ? OR email LIKE ? ORDER BY first_name ASC");
        $stmt->execute([$like, $like, $like]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $pdo2->prepare("SELECT * FROM students_info ORDER BY first_name ASC");
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>

    <!-- ✅ CSS MUST BE INSIDE STYLE -->
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
            padding: 30px 30px;
            min-height: 100vh;
        }

        .main h2 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .main h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2ecc71);
            margin-top: 10px;
            border-radius: 2px;
        }

        /* SEARCH FORM */
        form {
            margin-bottom: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
            padding: 10px;
            width: 250px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #3498db;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* TABLE STYLING */
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        table th {
            background: linear-gradient(90deg, #3498db, #2980b9);
            color: white;
            font-weight: 600;
            padding: 15px;
            text-align: left;
        }

        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ecf0f1;
        }

        table tr:hover {
            background-color: #f8f9fa;
        }

        table img {
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        table a {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        table a:hover {
            color: #2980b9;
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

            input[type="text"] {
                width: 100%;
            }

            table {
                font-size: 14px;
            }

            table th, table td {
                padding: 8px;
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

            table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<?php include 'sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="main">
    <h2>All Students</h2>

    <!-- Simple search form -->
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search name or email..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Grade</th>
            <th>Enrollment Date</th>
            <th>Gender</th>
            <th>Email</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>

        <?php
        $counter = 1;
        if(!empty($students)) {
            foreach($students as $row) {
                echo "<tr>";
                echo "<td>" . $counter . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['age'] . "</td>";
                echo "<td>" . $row['grade'] . "</td>";
                echo "<td>" . $row['enrollment_date'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . (isset($row['image']) && $row['image'] ? "<img src='" . $row['image'] . "' width='50'>" : "No Image") . "</td>";
                echo "<td>
                        <a href='update.php?id=" . $row['id'] . "'>Update</a> |
                        <a href='delete.php?id=" . $row['id'] . "'>Delete</a>
                      </td>";
                echo "</tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='10'>No records found</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>