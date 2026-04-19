<?php
include "connection.php";

// CHECK IF USER IS LOGGED IN AND IS ADMIN
if(!isset($_SESSION['email']) || $_SESSION['rolez'] != 1) {
    header("Location: index.php");
    exit();
}

try {


    // Get ID from URL
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND rolez = 1");
        $stmt->execute([$id]);

        echo "<script>
                alert('Admin deleted successfully!');
                window.location.href = 'createadmin.php';
              </script>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>