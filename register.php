<?php

include("db/database.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    /* Hash the password before storing it */
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    /* Insert user into database */
    $sql = "INSERT INTO users (name, email, phone, password)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssss",
        $name,
        $email,
        $phone,
        $hashed_password
    );

    if ($stmt->execute()) {

        $message = "Registration successful! You can now login.";

    } else {

        $message = "Registration failed. Email may already exist.";

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

    <title>Register - DonateHope</title>

    <link rel="stylesheet" href="css/style.css">

    <!-- JavaScript -->
    <script src="js/script.js"></script>

</head>

<body>


<!-- Navigation -->

<nav class="navbar">

    <div class="logo">
        DonateHope
    </div>

    <ul class="nav-links">

        <li>
            <a href="index.php">
                Home
            </a>
        </li>

        <li>
            <a href="about.php">
                About
            </a>
        </li>

        <li>
            <a href="causes.php">
                Causes
            </a>
        </li>

        <li>
            <a href="login.php">
                Login
            </a>
        </li>

        <li>
            <a href="register.php"
               class="nav-button">
                Register
            </a>
        </li>

    </ul>

</nav>


<!-- Registration Heading -->

<section class="intro">

    <h2>
        Create Your Account
    </h2>

    <p>
        Register to support causes and manage your donations.
    </p>

</section>


<!-- Registration Form -->

<div class="form-container">

    <form method="POST"
          action="register.php"
          onsubmit="return validateRegistrationForm();">


        <!-- Name -->

        <label>
            Full Name
        </label>

        <input
            type="text"
            id="name"
            name="name"
            placeholder="Enter your full name"
            required
        >


        <!-- Email -->

        <label>
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            placeholder="Enter your email"
            required
        >


        <!-- Phone -->

        <label>
            Phone Number
        </label>

        <input
            type="text"
            id="phone"
            name="phone"
            placeholder="Enter your phone number"
            required
        >


        <!-- Password -->

        <label>
            Password
        </label>

        <input
            type="password"
            id="password"
            name="password"
            placeholder="Create a password"
            required
        >


        <!-- Register Button -->

        <button
            type="submit"
            class="donate-button">

            Register

        </button>

    </form>


    <!-- Registration Message -->

    <?php

    if ($message != "") {

        echo "<p class='message'>$message</p>";

    }

    ?>


    <!-- Login Link -->

    <p class="login-link">

        Already have an account?

        <a href="login.php">
            Login here
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