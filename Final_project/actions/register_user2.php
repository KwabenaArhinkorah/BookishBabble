<?php
session_start(); 
unset($_SESSION['errors']);
unset($_SESSION['signup_data']);

$error_array = array();

include('../settings/connection.php');

// Define variables and initialize with empty values
$first_name = $last_name = $email = $password = "";
$first_name_err = $last_name_err = $email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate first name
    // Validate first name
    if (empty(trim($_POST["first_name"]))) 
    {
        array_push($error_array,"Please enter your first name.");
    } else {
        $first_name = trim($_POST["first_name"]);
    }

    // Validate last name
    if (empty(trim($_POST["last_name"]))) {
        array_push($error_array, "Please enter your last name.");
    } else {
        $last_name = trim($_POST["last_name"]);
    }

    // Validate email
    if (empty(trim($_POST["emailaddress"]))) 
    {
        array_push($error_array, "Please enter your email address.<br>");
    } 
    elseif (!filter_var(trim($_POST["emailaddress"]), FILTER_VALIDATE_EMAIL)) 
    {
        array_push($error_array, "Invalid email format. Please enter a valid email address.<br>");
    } 
    else 
    {
        $param_email = trim($_POST["emailaddress"]);
        $email_domain = substr(strrchr($param_email, "@"), 1);

        {
            $sql = "SELECT * FROM user WHERE email = ?";
            if ($stmt = $conn->prepare($sql)) 
            {
                $stmt->bind_param("s", $param_email);
                if ($stmt->execute()) {
                    $stmt->store_result();
                    if ($stmt->num_rows == 1) {
                        array_push($error_array, "This email is already taken.<br>");
                    } else {
                        $email = $param_email;
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.<br>";
                }
                $stmt->close();
            }

        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        array_push($error_array, "Please enter a password.<br>");
    } elseif (strlen(trim($_POST["password"])) < 6) {
        array_push($error_array, "Password must have at least 6 characters.<br>");
    } else {
        $password = trim($_POST["password"]);
    }

  
    // Check input errors before inserting into database
    if (empty($error_array)) 
    {
        // Prepare an insert statement
        echo "Hello";
        $sql = "INSERT INTO user (FirstName, LastName, Email, passwd, RegistrationDate) VALUES (?, ?, ?, ?, NOW())";

        if ($stmt = $conn->prepare($sql)) 
        {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_first_name, $param_last_name, $param_email, $param_password);
        
            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_email = $email;
            $param_password = password_hash(trim($password), PASSWORD_DEFAULT); // Creates a password hash
        
            // Attempt to execute the prepared statement
            if ($stmt->execute()) 
            {
                // Redirect to login page
                header("location: ../login/login.php");
                exit();
            } 
            else 
            {
                echo "Something went wrong. Please try again later.<br>";
            }
        
            // Close statement
            $stmt->close();
        }
    }
    // Close connection
    else
    {
        $_SESSION['signup_data'] = $_POST;
        $_SESSION['errors'] = $error_array;
        header("Location: ../login/register.php");
        exit();
    }

    $conn->close();
}