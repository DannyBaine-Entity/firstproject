<?php
// ==========================================
// Simple Registration with Email Check + JS Alert
// ==========================================

try {
    // DATABASE CONNECTION
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['submit'])) {

        // GET INPUTS SAFELY
          $username = trim($_POST['username']);
          $email = trim($_POST['email']);
          $password = $_POST['password'];

        // VALIDATION
        if(empty($username) || empty($email) || empty($password)) {
            echo "<script>alert('All fields are required!');</script>";
        } 
        elseif(strlen($password) < 6) {
            echo "<script>alert('Password must be at least 6 characters!');</script>"; //CHECKS IF THE PASSWORD IS LESS THAN 6
        }
        elseif(!preg_match('/[A-Z]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password))
            {
                echo "<script>alert('Password must be at least one capital and special character');</script>";
            }
        else {
            // CHECK IF EMAIL EXISTS
            $stmtEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmtEmail->execute([$email]);
            $emailExists = $stmtEmail->fetch(PDO::FETCH_ASSOC);

            if($emailExists) {
                echo "<script>alert('Email already exists!');</script>";
            } 
            else {
                // INSERT USER
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                $stmtInsert = $conn->prepare($sql);
                $stmtInsert->execute([$username, $email, $hashedPassword]);

                // SUCCESS MESSAGE + REDIRECT
                echo "<script>
                        alert('Registration successful!');
                        window.location.href = 'index.php';
                      </script>";
                exit();
            }
        }
    }

}  catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>

<h2>Register</h2>

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