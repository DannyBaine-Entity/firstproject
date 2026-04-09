<?php
session_start(); // store user data across pages

try {
    // CONNECT TO DATABASE
    $conn = new PDO("mysql:host=localhost;dbname=testdb", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // CHECK IF FORM IS SUBMITTED
    if(isset($_POST['submit'])) {

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // =========================
        // VALIDATION
        // =========================
        if(empty($email) || empty($password)) {
            echo "<script>alert('All fields are required!');</script>";
        } 
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format!');</script>";
        } 
        else {

            // =========================
            // CHECK USER IN DATABASE
            // =========================
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])) {

                // =========================
                // STORE SESSION DATA
                // =========================
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['rolez'] = $user['rolez'];

                // =========================
                // SIMPLE ROLE-BASED REDIRECT
                // =========================
                if($user['rolez'] == 1) {
                    echo "<script>
                            alert('Login successful!');
                            window.location.href = 'admindashboard.php';
                          </script>";
                } else {
                    echo "<script>
                            alert('Login successful!');
                            window.location.href = 'studentdashboard.php';
                          </script>";
                }

                exit();

            } else {
                echo "<script>alert('Invalid email or password!');</script>";
            }
        }
    }

} catch(PDOException $e) {
    echo "<script>alert('Login failed!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form method="post">
    Email:<br>
    <input type="email" name="email" required><br>

    Password:<br>
    <input type="password" name="password" required><br><br>

    <input type="submit" name="submit" value="Login">
</form>

<p>Don't have an account? <a href="register.php">Register here</a></p>

</body>
</html>