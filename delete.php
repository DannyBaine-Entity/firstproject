<?php
include "connection2.php";
try {
    

    // Get ID from URL
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        // Delete query
        $stmt = $pdo2->prepare("DELETE FROM students_info WHERE id = ?");
        $stmt->execute([$id]);

        echo "<script>
                alert('Record deleted successfully!');
                window.location.href = 'viewrecords.php';
              </script>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>