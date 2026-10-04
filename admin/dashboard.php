<?php

session_start();

/* Check whether admin is logged in */
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: login.php");
    exit();
}

include("../db/database.php");


/* Total Users */
$user_query = "SELECT COUNT(*) AS total_users FROM users";
$user_result = $conn->query($user_query);
$user_data = $user_result->fetch_assoc();
$total_users = $user_data["total_users"];


/* Total Causes */
$cause_query = "SELECT COUNT(*) AS total_causes FROM causes";
$cause_result = $conn->query($cause_query);
$cause_data = $cause_result->fetch_assoc();
$total_causes = $cause_data["total_causes"];


/* Total Donations */
$donation_query = "SELECT COUNT(*) AS total_donations FROM donations";
$donation_result = $conn->query($donation_query);
$donation_data = $donation_result->fetch_assoc();
$total_donations = $donation_data["total_donations"];


/* Total Donation Amount */
$amount_query = "SELECT SUM(amount) AS total_amount FROM donations";
$amount_result = $conn->query($amount_query);
$amount_data = $amount_result->fetch_assoc();

$total_amount = $amount_data["total_amount"];

if ($total_amount == NULL) {
    $total_amount = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - DonateHope</title>

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
            <a href="dashboard.php">
                Dashboard
            </a>
        </li>

        <li>
            <a href="donations.php">
                Donations
            </a>
        </li>

        <li>
            <a href="users.php">
                Users
            </a>
        </li>

        <li>
            <a href="causes.php">
                Causes
            </a>
        </li>

        <li>
            <a href="logout.php">
                Logout
            </a>
        </li>

        <li>
            <a href="../index.php">
                Website
            </a>
        </li>

    </ul>

</nav>


<!-- Dashboard Heading -->

<section class="intro">

    <h2>
        Admin Dashboard
    </h2>

    <p>
        Overview of the Online Donation Management System
    </p>

</section>


<!-- Dashboard Statistics -->

<section class="features">

    <div class="feature-container">


        <!-- Total Users -->

        <div class="feature-card">

            <h3>
                Total Users
            </h3>

            <p class="dashboard-number">
                <?php echo $total_users; ?>
            </p>

        </div>


        <!-- Total Causes -->

        <div class="feature-card">

            <h3>
                Total Causes
            </h3>

            <p class="dashboard-number">
                <?php echo $total_causes; ?>
            </p>

        </div>


        <!-- Total Donations -->

        <div class="feature-card">

            <h3>
                Total Donations
            </h3>

            <p class="dashboard-number">
                <?php echo $total_donations; ?>
            </p>

        </div>


        <!-- Total Amount -->

        <div class="feature-card">

            <h3>
                Total Amount
            </h3>

            <p class="dashboard-number">
                ₹<?php echo number_format($total_amount, 2); ?>
            </p>

        </div>


    </div>

</section>


<!-- Footer -->

<footer>

    <p>
        © 2026 DonateHope | Admin Dashboard
    </p>

</footer>


</body>

</html>

<?php

$conn->close();

?>