<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=school_records", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        } 
        else {
            // CHECK IF EMAIL EXISTS
            $stmtEmail = $conn->prepare("SELECT * FROM students_info WHERE email = ?");
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

            $stmt = $conn->prepare($sql);

          $stmt->execute([$first_name, $last_name, $age, $grade, $enrollment_date, $gender, $email]);
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

        <!-- Image (Optional) -->
        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*"><br><br>


        <!-- Submit Button -->
        <input type="submit" name ="submit" value="Submit">
        
    </form>
</div>

</body>
</html>
