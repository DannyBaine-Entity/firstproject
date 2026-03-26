<?php
// ==========================================
// Super Simple Registration for Beginners
// ==========================================


/*PDO stands for PHP Data Objects.

It’s a PHP extension that allows you to interact with databases (like MySQL, SQLite, PostgreSQL, etc.).

The main benefits of PDO:

Works with many types of databases using the same code.

Provides prepared statements which help prevent SQL injection.

Lets you handle errors cleanly.*/

// Connect to the database
$conn = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//$conn->setAttribute() → we are setting a “behavior” for the connection.

//PDO::ATTR_ERRMODE → this is the attribute for error reporting.

//PDO::ERRMODE_EXCEPTION → this tells PDO to throw an exception whenever there is a database error. This way, we can catch it and handle it gracefully.

$message = "";

// Handle form submission
if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        
    $sql = "INSERT INTO users(username, email, password) 
            VALUES ('$username', '$email', '$password')";

            

    try {
        $conn->exec($sql);
        $message = "Registered successfully!";
    } catch (PDOException $e) {
        $message = "Registration failed: " . $e->getMessage();
    }
}

/*CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(50) NOT NULL,
 email VARCHAR(100) NOT NULL, 
 password VARCHAR(255) NOT NULL );*/

?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
    <h2>Register</h2>
    <?php if($message != "") echo "<p>$message</p>"; ?>
    <form method="post">
        Username:<br>
        <input type="text" name="username" required><br>
        Email:<br>
        <input type="email" name="email" required><br>
        Password:<br>
        <input type="password" name="password" required><br><br>
        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>