<?php
// Include your database connection file
include('../settings/connection.php');

// Retrieve the genre from the search form
$genre = $_GET['genre'];

// Prepare a SQL statement to fetch books matching the genre
$sql = "SELECT BookID, Title, Author, CoverImageURL FROM book WHERE genre LIKE ?";

// Bind the genre parameter to the SQL statement
$genreParam = '%' . $genre . '%'; // Using '%' to match any genre containing the provided keyword
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $genreParam);

// Execute the prepared statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Close the prepared statement to avoid conflicts
$stmt->close();

// Close the database connection to avoid resource leaks
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        /* Add your custom CSS styles here */
        .book-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }
        .book-card {
            width: 200px;
            margin-bottom: 20px;
            text-align: center;
        }
        .book-card img {
            max-width: 100%;
            height: auto;
        }
        .new-search-btn {
            margin-top: 20px;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>
    <h2>Search Results</h2>

    <div class="book-container">
        <?php
        // Check if there are any matching books
        if ($result->num_rows > 0) {
            // Output each book as a link to its review page
            while ($row = $result->fetch_assoc()) {
                $bookId = $row['BookID']; // Fetch the book ID from the result set
                $title = $row['Title'];
                $author = $row['Author'];
                $coverImageURL = $row['CoverImageURL'];
                // Output HTML for each book including the image
                echo "<div class='book-card'>";
                echo "<img src='$coverImageURL' alt='$title'>";
                echo "<p><a href='../view/review.php?id=$bookId'>$title by $author</a></p>";
                echo "</div>";
            }
        } else {
            echo "<p>No books found for the genre: $genre</p>";
            // Redirect to homepage if no results found
            header("Location: ../view/homepage.php");
            exit();
        }
        ?>
    </div>

    <!-- New Search Button -->
    <div class="new-search-btn">
        <a href="../view/homepage.php">Start a New Search</a>
    </div>
</body>
</html>
