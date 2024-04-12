<?php
// Include your database connection file
include('../settings/connection.php');

// Check if the book ID is provided in the URL
if(isset($_GET['id'])) {
    // Retrieve the book ID from the URL
    $bookId = $_GET['id'];

    // Prepare a SQL statement to fetch existing reviews for the book
    $sql = "SELECT Rating, ReviewText, DatePosted FROM reviewid WHERE BookID = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("i", $bookId);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any reviews
    if ($result->num_rows > 0) {
        // Display the reviews
        echo "<h3>Reviews</h3>";
        while ($row = $result->fetch_assoc()) {
            $rating = $row['Rating'];
            $reviewText = $row['ReviewText'];
            $datePosted = $row['DatePosted'];

            // Display each review
            echo "<div>";
            echo "<p>Rating: $rating stars</p>";
            echo "<p>Date Posted: $datePosted</p>";
            echo "<p>Review: $reviewText</p>";
            echo "</div>";
        }
    } else {
        // No reviews found
        echo "<p>No reviews found for this book.</p>";
    }

    // Close the prepared statement
    $stmt->close();

} else {
    // Book ID not provided
    echo "<p>Book ID is missing.</p>";
}

// Close the database connection
$conn->close();
?>
