<?php
// ==========================================
// Library Book Registration (PDO + Validation)
// ==========================================

$message = "";

try {
    $conn = new PDO("mysql:host=localhost;dbname=library_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['submit'])) {

        $title = trim($_POST['title']); // TRIm removes the whitespaces preceeding the values entered
        $author = trim($_POST['author']);
        $published_year = $_POST['published_year'];
        $genre = $_POST['genre'];

        // ✅ VALIDATION
        if(empty($title) || empty($author) || empty($published_year) || empty($genre)) {
            $message = "All fields are required!";
        } elseif(!is_numeric($published_year)) {
            $message = "Published year must be a number!";
        } else {

            // ✅ INSERT USING PREPARED STATEMENT
            $sql = "INSERT INTO books (title, author, published_year, genre) 
                    VALUES (?, ?, ?, ?)"; // PREVENTS SQL INJECTIONS

            $stmtInsert = $conn->prepare($sql);
            $stmtInsert->execute([$title, $author, $published_year, $genre]);
            // ✅ SUCCESS MESSAGE
            $message = "✅ Book registered successfully!";
        }
    }

} catch (PDOException $e) {
    $message = "Registration failed!";
}
?>

<!DOCTYPE html>
<html>
<head><title>Library</title></head>
<body>

<h2>Register Book</h2>

<?php if($message != "") echo "<p>$message</p>"; ?>

<form method="post">

    Title:<br>
    <input type="text" name="title" required><br>

    Author:<br>
    <input type="text" name="author" required><br>

    Published Year:<br>
    <input type="number" name="published_year" required><br>

    Genre:<br>
    <select name="genre" required>
        <option value="">Select an option</option>
        <option value="Adventure">Adventure</option>
        <option value="Historical Fiction">Historical Fiction</option>
        <option value="Mystery">Mystery</option>
        <option value="Thriller">Thriller</option>
        <option value="Fantasy">Fantasy</option>
        <option value="Science Fiction">Science Fiction</option>
    </select><br><br>

    <input type="submit" name="submit" value="Register">

</form>

</body>
</html>