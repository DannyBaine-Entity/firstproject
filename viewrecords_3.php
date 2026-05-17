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

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
        }

        /* Simple search */
        form { margin-bottom: 10px; }
        input[type="text"] { padding: 6px; width: 200px; }
        button { padding: 6px 12px; cursor: pointer; }
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