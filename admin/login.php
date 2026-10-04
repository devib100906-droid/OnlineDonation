<?php

session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    /*
       Simple admin credentials for college project demo.
    */

    if ($username === "admin" && $password === "admin123") {

        $_SESSION["admin_logged_in"] = true;

        header("Location: dashboard.php");
        exit();

    } else {

        $message = "Invalid admin username or password.";

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Login - DonateHope</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>


<!-- Navigation -->

<nav class="navbar">

    <div class="logo">
        DonateHope Admin
    </div>

    <ul class="nav-links">

        <li>
            <a href="../index.php">
                Website
            </a>
        </li>

    </ul>

</nav>


<!-- Admin Login -->

<section class="intro">

    <h2>Admin Login</h2>

    <p>
        Login to access the administration panel.
    </p>

</section>


<div class="form-container">

    <form method="POST"
          action="login.php">


        <label>Username</label>

        <input
            type="text"
            name="username"
            placeholder="Enter admin username"
            required
        >


        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter admin password"
            required
        >


        <button
            type="submit"
            class="donate-button">

            Admin Login

        </button>

    </form>


    <?php

    if ($message != "") {

        echo "<p class='message'>$message</p>";

    }

    ?>

</div>


<!-- Footer -->

<footer>

    <p>
        © 2026 DonateHope | Admin Login
    </p>

</footer>


</body>

</html>