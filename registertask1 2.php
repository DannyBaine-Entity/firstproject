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
    $author = $_POST['author'];
     $published_year = $_POST['published_year'];
    $genre = $_POST['genre'];
   
        
    $sql = "INSERT INTO books (title, author, published_year, genre) 
            VALUES ('$title', '$author', '$published_year','$genre')";

            

    try {
        $conn->exec($sql);
        $message = "Book Registered successfully!";
    } catch (PDOException $e) {
        $message = "Book Registration failed: " . $e->getMessage();
    }
}



?>
   
<!DOCTYPE html>
<html>
<head><title>Library</title></head>
<body>
    <h2>Register</h2>
    <?php if($message != "") echo "<p>$message</p>"; ?>
    <form method="post">
       title:<br>
        <input type="text" name="title" required><br>
      author:<br>
        <input type="text" name="author" required><br>
       published_year:<br>
        <input type="year" name="published_year" required><br>

          genre:<br>
          <select name="genre" id="genre" required>
             <option value="">select an option</option>
            <option value="Adventure">Adventure</option>
            <option value="Historical Fiction">Historical Fiction</option>
              <option value="Thriller">Thriller</option>
            <option value="Fantasy">Fantasy</option>
            
               </select><br><br>



        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>