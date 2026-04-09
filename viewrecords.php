<?php

try {
    // DATABASE CONNECTION
    $conn = new PDO("mysql:host=localhost;dbname=school_records", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // FETCH ALL STUDENTS
    $stmt = $conn->prepare("SELECT * FROM students_info ");
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    </style>
</head>

<body>

<!-- SIDEBAR -->
<?php include 'sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="main">

    <h2>All Students</h2>

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
        //$counter = 1;
        if(!empty($students)) {

            foreach($students as $row) {

                echo "<tr>";
                
                echo "<td>" . $row['student_id'] . "</td>"; // ✅ ID column
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['age'] . "</td>";
                echo "<td>" . $row['grade'] . "</td>";
                echo "<td>" . $row['enrollment_date'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . ($row['image'] ? "<img src='" . $row['image'] . "' width='50' alt='Image'>" : "No Image") . "</td>";

                echo "<td>
                        <a href='update.php?id=".$row['student_id']."'>Update</a> |
                        <a href='delete.php?id=".$row['student_id']."'>Delete</a>
                      </td>";

                echo "</tr>";
                // $counter++;
            }

        } else {
            echo "<tr><td colspan='10'>No records found</td></tr>";
        }
        ?>

    </table>

</div>

</body>
</html>