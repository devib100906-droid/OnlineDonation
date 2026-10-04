<?php

session_start();

include("db/database.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: causes.php");
            exit();

        } else {

            $message = "Invalid email or password.";

        }

    } else {

        $message = "Invalid email or password.";

    }

    $stmt->close();
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - DonateHope</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>


<!-- Navigation Bar -->

<nav class="navbar">

    <div class="logo">
        DonateHope
    </div>

    <ul class="nav-links">

        <li>
            <a href="index.php">Home</a>
        </li>

        <li>
            <a href="about.php">About</a>
        </li>

        <li>
            <a href="causes.php">Causes</a>
        </li>

        <li>
            <a href="login.php">Login</a>
        </li>

        <li>
            <a href="register.php" class="nav-button">
                Register
            </a>
        </li>

    </ul>

</nav>


<!-- Login Heading -->

<section class="intro">

    <h2>Welcome Back</h2>

    <p>
        Login to manage your donations.
    </p>

</section>


<!-- Login Form -->

<div class="form-container">

    <form method="POST"
          action="login.php">

        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
        >


        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter your password"
            required
        >


        <button type="submit"
                class="donate-button">
            Login
        </button>

    </form>


    <?php

    if ($message != "") {

        echo "<p class='message'>$message</p>";

    }

    ?>


    <p class="login-link">

        Don't have an account?

        <a href="register.php">
            Register here
        </a>

    </p>

</div>


<!-- Footer -->

<footer>

    <p>
        © 2026 DonateHope | Online Donation Management System
    </p>

</footer>


</body>

</html>