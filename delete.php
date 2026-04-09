<?php
include "conn2.php";
try {
    

    // Get ID from URL
    if(isset($_GET['id'])) {

        $id = $_GET['id'];

        // Delete query
        $stmt = $conn->prepare("DELETE FROM students_info WHERE student_id = ?");
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