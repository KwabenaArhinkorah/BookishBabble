<?php
session_start();
include_once "../settings/connection.php";

if (isset($_POST['savebtn'])) {
    if (isset($_POST["bio"])) {
        $bio = mysqli_real_escape_string($conn, $_POST["bio"]);

        $sql = "UPDATE user SET bio = '$bio' WHERE user_id = {$_SESSION['user_id']}";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['bio'] = $bio;
            header("Location: ../view/profile.php");
            exit();
        } else {
            echo "Error updating bio: " . mysqli_error($conn);
        }
    } else {
        echo "Bio field is empty";
    }
} else {
    echo "Form is not submitted";
}
?>
