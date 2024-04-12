<?php
include_once "../settings/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $token = bin2hex(random_bytes(5));

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If email exists, update the user's token in the database
    if ($result->num_rows > 0) {
        $updateSql = "UPDATE users SET reset_token = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $token, $email);
        $updateStmt->execute();

        // Send email to user with reset link containing the token
        $resetLink = "http://example.com/reset_password.php?token=$token";
        $to = $email;
        $subject = "Password Reset";
        $message = "Click the link below to reset your password:\n$resetLink";
        $headers = "From: admin@example.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "An email has been sent to your email address with instructions to reset your password.";
        } else {
            echo "Error: Unable to send email. Please try again later.";
        }
    } else {
        echo "Error: Email not found in our records.";
    }

    $stmt->close();
    $updateStmt->close();
    $conn->close();
}
?>
