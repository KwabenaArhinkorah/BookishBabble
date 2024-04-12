<?php

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/forgotpassword.css">
    <title>Forgot Password</title>
</head>
<body>
    <header>
        <img src="../images/book_logo2.jpg" alt="Logo">
        <h1>BookishBabble</h1>
    </header>
    <form action="../actions/forgetpassword_action.php" method="post" name="forgotpasswordform" id="forgotpassword">
        <h2>Find Your Account</h2>
        <?php echo (isset($_SESSION['message'])) ? "<p style='color: green;'>". $_SESSION['message'] . "</p>" : '' ; ?>
        <?php 
            if (!isset($_SESSION['successful_email'])) 
            {
                echo '<p>Please enter your email to search for your account.</p>';
                echo "<input type='text' id='email' name='email' placeholder='Email' required>";
                echo "<button type='submit'>Submit</button>";
            }
            else 
            {
                echo "<input type='text' id='token' name='token' placeholder='Token' required>";
                echo "<input type='password' id='password' name='password' placeholder='New Password' required>";
                echo '<input type="hidden" id="submitted_email" name="submitted_email" value="' . $_SESSION['successful_email'] . '">';
                echo "<button type='submit'>Submit</button>";
            }
        ?>
        <a class="btl" href="../login/login.php"><u>Back to Login</u></a>
    </form>
</body>
</html>