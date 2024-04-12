<?php
session_start();
include('../settings/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $error_array = [];

    if (empty($email) || empty($password)) 
    {
        $error_array[] = "Please enter your email and password.";
    } 
    else 
    {
        $sql = "SELECT Email, passwd, FirstName, LastName, RegistrationDate, Bio, ProfilePicture FROM user WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) 
        {
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) 
            {
                $stmt->store_result();
                if ($stmt->num_rows == 1) 
                {
                    $stmt->bind_result($email, $hashed_password, $first_name, $last_name, $join, $bio, $picture_path);
                    if ($stmt->fetch() && password_verify($password, $hashed_password)) 
                    {
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["username"] = $first_name . " " . $last_name;
                        $_SESSION["email"] = $email;
                        $_SESSION['joined'] = date("h:i d F", strtotime($join));
                        $_SESSION['bio'] = $bio;
                        $_SESSION['picturePath'] = $picture_path;
                        header("location: ../view/homepage.php");
                        exit();
                    } 
                    else 
                    {
                        $error_array[] = "The password you entered is not valid.";
                    }
                } 
                else 
                {
                    $error_array[] = "No account found with that email.";
                }
            } 
            else 
            {
                $error_array[] = "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $_SESSION['errors'] = $error_array;
    $_SESSION['signup_data'] = $_POST;
    header("location: ../login/login.php");
    exit();
}
?>
