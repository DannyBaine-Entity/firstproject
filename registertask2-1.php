<?php
include 'connection.php';
include 'connection2.php';

try {

 if(isset($_POST['submit'])) {

        // GET FORM DATA
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $age = $_POST['age'];
        $grade = $_POST['grade'];
        $enrollment_date = $_POST['enrollment_date'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];

        // VALIDATION
        if (empty($first_name) || empty($last_name) || empty($age) || empty($grade) || empty($enrollment_date) || empty($gender)) {

            echo "<script>alert('All required fields must be filled!');</script>";

        } else {
            // CHECK IF EMAIL EXISTS
            $stmtEmail = $pdo2->prepare("SELECT * FROM students_info WHERE email = ?");
            $stmtEmail->execute([$email]);
            $emailExists = $stmtEmail->fetch(PDO::FETCH_ASSOC);

            if($emailExists) {
                echo "<script>alert('Email already exists!');</script>";
            } 

        else {

            // SQL QUERY
            $sql = "INSERT INTO students_info
                    (first_name, last_name, age, grade, enrollment_date, gender, email, image)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $pdo2->prepare($sql);

          $stmt->execute([$first_name, $last_name, $age, $grade, $enrollment_date, $gender, $email, $image]);
            // SUCCESS ALERT
            echo "<script>
                    alert('Student added successfully!'); 
                    window.location.href = 'viewrecords.php';
                  </script>";

        }
    }
 }
}catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System - Register</title>
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

        /* FORM STYLING */
        .main label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .main input[type="text"],
        .main input[type="number"],
        .main input[type="email"],
        .main input[type="date"],
        .main input[type="file"],
        .main select {
            width: 100%;
            max-width: 300px;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .main input[type="text"]:focus,
        .main input[type="number"]:focus,
        .main input[type="email"]:focus,
        .main input[type="date"]:focus,
        .main input[type="file"]:focus,
        .main select:focus {
            outline: none;
            border-color: #3498db;
        }

        .main input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        .main input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .logout {
            color: #e74c3c;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<?php include 'sidebar.php'; ?>

<!-- MAIN CONTENT -->
<div class="main">
    <h1>Add Student to the System</h1>
    <form method="POST" action="">
    
        <!-- First Name -->
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required><br><br>
        
        <!-- Last Name -->
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required><br><br>
        
        <!-- Age -->
        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required min="1"><br><br>
        
        <!-- Grade -->
        <label for="grade">Grade:</label>
        <input type="text" name="grade" id="grade" required><br><br>
        
        <!-- Enrollment Date -->
        <label for="enrollment_date">Enrollment Date:</label>
        <input type="date" name="enrollment_date" id="enrollment_date" required><br><br>
        
        <!-- Gender -->
        <label for="gender">Gender:</label>
        <select name="gender" id="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select><br><br>
        
        <!-- Email (Optional) -->
        <label for="email">Email</label>
        <input type="email" name="email" id="email"><br><br>

        <!-- Image Upload -->
         <form method="POST" enctype="multipart/form-data">
        <label for="image">Profile Image:</label>
        <input type="file" name="image" id="image" required><br><br>


        <!-- Submit Button -->
        <input type="submit" name ="submit" value="Submit">
        
    </form>
</div>

</body>
</html>
