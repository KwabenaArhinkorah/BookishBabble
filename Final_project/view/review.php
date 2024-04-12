<?php
// Include your database connection file
include('../settings/connection.php');

// Retrieve the BookID from the URL parameter
$bookId = $_GET['id'];

// Fetch book details based on BookID including the synopsis
$sql = "SELECT Title, Author, CoverImageURL, Synopsis FROM book WHERE BookID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookId);
$stmt->execute();
$result = $stmt->get_result();
$bookDetails = $result->fetch_assoc();

// Fetch existing reviews for the book
$sql = "SELECT Rating, ReviewText FROM reviewid WHERE BookID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookId);
$stmt->execute();
$reviews = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculate average rating for the book
$sql = "SELECT AVG(Rating) AS AvgRating FROM reviewid WHERE BookID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookId);
$stmt->execute();
$avgRating = $stmt->get_result()->fetch_assoc()['AvgRating'];

// Close the database connection to avoid resource leaks
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Book Review - <?php echo $bookDetails['Title']; ?></h2>
        <div class="book-details">
            <div class="book-info">
                <img src="<?php echo $bookDetails['CoverImageURL']; ?>" alt="<?php echo $bookDetails['Title']; ?>">
                <div class="synopsis">
                    <p><strong>Author:</strong> <?php echo $bookDetails['Author']; ?></p>
                    <p><strong>Synopsis:</strong> <?php echo $bookDetails['Synopsis']; ?></p>
                    <p><strong>Average Rating:</strong> <?php echo number_format($avgRating, 1); ?> stars</p>
                </div>
            </div>
        </div>
        <h3>Existing Reviews</h3>
        <ul class="reviews">
            <?php foreach ($reviews as $review): ?>
                <li class="review">
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= $review['Rating']): ?>
                                <span class="star">&#9733;</span>
                            <?php else: ?>
                                <span class="star">&#9734;</span>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <p><?php echo $review['ReviewText']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
        <h3>Submit a Review</h3>
        <form class="form-container" action="../actions/submit_review.php" method="POST">
            <label for="rating">Rating (1-5 stars):</label><br>
            <input type="number" id="rating" name="rating" min="1" max="5" required><br>
            <label for="review">Review:</label><br>
            <textarea id="review" name="review" rows="4" cols="50" required></textarea><br>
            <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
            <input type="submit" value="Submit Review">
        </form>
        <a href="../view/homepage.php">Go back to Homepage</a>
    </div>
</body>
</html>

