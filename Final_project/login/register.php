<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Sign Up Page</title>
</head>
<body>
    <header>
        <img src="../images/book_logo2.jpg" alt="Logo">
        <h1>BookishBabble</h1>
    </header>
    <form action="../actions/register_user2.php" method="post" enctype="multipart/form-data" name="signupform" id="signup">
        <h2>Sign Up</h2>
        <div class="entries">
            <?php 
                if (!empty($_SESSION["errors"])) {
                    echo "<div>";
                    foreach($_SESSION["errors"] as $error)
                    {
                        echo "<p id='error_paragraph'>$error</p><br>";
                    }
                    echo "</div>";
                } 
            ?>
            <label for="fname" class="fname"></label>
            <input placeholder="First Name" type="fname" name="first_name" id="fname" value="<?php echo isset($_SESSION['signup_data']['first_name']) ? htmlspecialchars($_SESSION['signup_data']['first_name']) : ''; ?>">
            <label for="lname" class="lname"></label>
            <input placeholder="Last Name" type="lname" name="last_name" id="lname" value="<?php echo isset($_SESSION['signup_data']['last_name']) ? htmlspecialchars($_SESSION['signup_data']['last_name']) : ''; ?>">
            <label for="email"></label>
            <input placeholder="Email" type="email" name="emailaddress" id="emailaddress" value="<?php echo isset($_SESSION['signup_data']['emailaddress']) ? htmlspecialchars($_SESSION['signup_data']['emailaddress']) : ''; ?>">
            <label for="password"></label>
            <input placeholder="Password" type="password" name="password" id="password" value="<?php echo isset($_SESSION['signup_data']['password']) ? htmlspecialchars($_SESSION['signup_data']['password']) : ''; ?>">
            <button type="submit" name="registerbtn" id="signup">Sign Up</button>
        </div>
        <p id="signinlink">Already have an account? <a href="login.php">Sign In</a></p>
    </form>
    <script src="../js/register.js"></script>
</body>
</html>
