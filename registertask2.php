<?php

/*Database Exercise: Student Management System

Assignment Description:
You are tasked with creating a simple Student Management System database. The goal is to practice creating databases, tables, and inserting data using SQL.

Database & Table Details

Database Name: school_records
Table Name: students_info

Table Structure:

Column Name	Data Type	Description
student_id	INT PRIMARY KEY	
first_name	VARCHAR(50)	
last_name	VARCHAR(50)	
age	        INT	        
grade	 VARCHAR(10)	
enrollment_date	DATE	
gender    ENUM('male', 'female')


Tasks

Create the database school_records.

Create the table students_info with the columns listed above.

Insert at least 5 sample student records into students_info.

Extra Challenge (Optional)

Add a new column email to the students_info table.*/

$conn = new PDO("mysql:host=localhost;dbname=school_records", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$message = "";

// Handle form submission
if(isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $grade = $_POST['grade'];
    $enrollment_date = $_POST['enrollment_date'];
    $gender = $_POST['gender'];
   
        
    $sql = "INSERT INTO students_info (first_name, last_name, age, grade, enrollment_date, gender) 
            VALUES ('$first_name', '$last_name', $age,'$grade', '$enrollment_date', '$gender')";

            

    try {
        $conn->exec($sql);
        $message = "Student Added Successfully!";
    } catch (PDOException $e) {
        $message = "Student Addition failed: " . $e->getMessage();
    }
}


?>
<!DOCTYPE html>
<html>
<head><title>School records</title></head>
<body>
    <h2>Register</h2>
    <?php if($message != "") echo "<p>$message</p>"; ?>
    <form method="post">
        firstname:<br>
        <input type="text" name="first_name" required><br>
        lastname:<br>
        <input type="text" name="last_name" required><br>
        age:<br>
        <input type="number" name="age" required><br>
        grade:<br>
        <input type="text" name="grade" required><br>
        enrollment_date:<br>
        <input type="date" name="enrollment_date" required><br>
        gender:<br>
          <select name="gender" id="gender" required>
            <option value="">select an option</option>
                <option value="male">male</option>
                <option value="female">female</option>

        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>