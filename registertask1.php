<?php

/* Library Book Registration System

Description: Students create a database to keep track of books in a small library.

Database & Table Details:

Database Name: library_db

Table Name: books

Table Structure:

Column Name	Data Type	Description
book_id	INT PRIMARY KEY	Unique ID for each book
title	VARCHAR(100)	Title of the book
author	VARCHAR(50)	Author name
published_year	YEAR	Year the book was published
genre	ENUM('Adventure', 'Historical Fiction', 'Mystery', 'Thriller', 'Fantasy', 'Science Fiction', 'Dystopian', 'Magical Realism', 'Romance', 'Contemporary Fiction', 'Coming-of-Age', 'Horror', 'Supernatural', 'Graphic Novels')	Book genre

CREATE TABLE books (
    book_id INT PRIMARY KEY,
    title VARCHAR(100),
    author VARCHAR(50),
    published_year YEAR,
    genre ENUM(
        'Adventure',
        'Historical Fiction',
        'Mystery',
        'Thriller',
        'Fantasy',
        'Science Fiction'
    )
);


*/

$conn = new PDO("mysql:host=localhost;dbname=library_db", "root", "");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$message = "";

// Handle form submission
if(isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author= $_POST['author'];
    $published_year = $_POST['year'];
    $genre = $_POST['genre'];

        
    $sql = "INSERT INTO books(title, author, year, genre) 
            VALUES ('$title', '$author', '$published_year', '$genre')";

            

    try {
        $conn->exec($sql);
        $message = "Registered successfully!";
    } catch (PDOException $e) {
        $message = "Registration failed: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
    <h2>Register</h2>
    <?php if($message != "") echo "<p>$message</p>"; ?>
    <form method="post">
        Title:<br>
        <input type="text" name="title" required><br>
        Author:<br>
        <input type="text" name="author" required><br>
        Year:<br>
        <input type="text" name="year" required><br>
        Genre:
        <input type="text" name="genre" required><br><br>
        
        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>