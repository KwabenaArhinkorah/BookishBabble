<?php
// Include your database connection file
include('../settings/connection.php');

// Get the form data
$rating = $_POST['rating'];
$reviewText = $_POST['review'];
$bookId = $_POST['book_id'];

// Prepare and execute the SQL statement to insert the new review
$sql = "INSERT INTO reviewid (BookID, Rating, ReviewText, DatePosted) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $bookId, $rating, $reviewText);
$result = $stmt->execute();

// Check if the insertion was successful
if ($result) {
    echo "<p>Review submitted successfully!</p>";
    header("Location: ../view/review.php?id=$bookId");
} else {
    echo "<p>Error submitting review. Please try again later.</p>";
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();
?>
