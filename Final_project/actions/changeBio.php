<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect the user to the login page if not logged in
    header("Location: ../login.php");
    exit(); // Stop further execution
}

// Check if the new bio data is sent via POST request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['bio'])) {
    // Include your database connection file
    include('../settings/connection.php');

    // Sanitize the new bio data
    $newBio = mysqli_real_escape_string($conn, $_POST['bio']);

    // Update the user's bio in the database
    $userId = $_SESSION['userId'];
    $sql = "UPDATE user SET Bio = '$newBio' WHERE UserID = $userId";

    if (mysqli_query($conn, $sql)) {
        // Update the session variable with the new bio
        $_SESSION['bio'] = $newBio;
        // Send a success response
        echo json_encode(['success' => true, 'newbio' => $newBio]);
    } else {
        // Send an error response if the database update fails
        echo json_encode(['success' => false, 'message' => 'Failed to update bio']);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Send an error response if the request method is not POST or bio data is not provided
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
