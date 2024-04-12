<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if a file was uploaded without errors
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        // Define upload directory
        $uploadDir = "../uploads/";
        
        // Get file name and move the uploaded file to the designated directory
        $fileName = $_FILES["profile_picture"]["name"];
        $tempName = $_FILES["profile_picture"]["tmp_name"];
        $targetPath = $uploadDir . $fileName;

        // Check if the file already exists
        if (file_exists($targetPath)) {
            echo json_encode(["success" => false, "message" => "File already exists."]);
        } else {
            // Move the file to the uploads directory
            if (move_uploaded_file($tempName, $targetPath)) {
                // Update the session with the new profile picture path
                $_SESSION["picturePath"] = $targetPath;
                echo json_encode(["success" => true, "message" => "Profile picture updated successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error uploading file."]);
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "No file uploaded or an error occurred."]);
    }
} else {
    // If the request method is not POST
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
