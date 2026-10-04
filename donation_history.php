<?php

session_start();

include("db/database.php");


// Check whether user is logged in

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

$user_id = $_SESSION["user_id"];


// Get user's donation history

$sql = "SELECT donations.donation_id,
               causes.cause_name,
               donations.amount,
               donations.payment_method,
               donations.donation_date
        FROM donations
        INNER JOIN causes
        ON donations.cause_id = causes.cause_id
        WHERE donations.user_id = ?
        ORDER BY donations.donation_date DESC";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Donations - DonateHope</title>

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
            <a href="causes.php">Causes</a>
        </li>

        <li>
            <a href="donation_history.php">My Donations</a>
        </li>

        <li>
            <a href="logout.php">Logout</a>
        </li>

    </ul>

</nav>


<!-- Heading -->

<section class="intro">

    <h2>My Donation History</h2>

    <p>
        View your previous donations below.
    </p>

</section>


<!-- Donation Table -->

<div class="table-container">

    <?php

    if ($result->num_rows > 0) {

    ?>

        <table>

            <thead>

                <tr>

                    <th>Donation ID</th>
                    <th>Cause</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

            <?php

            while ($row = $result->fetch_assoc()) {

            ?>

                <tr>

                    <td>
                        <?php echo $row["donation_id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["cause_name"]); ?>
                    </td>

                    <td>
                        ₹<?php echo number_format($row["amount"], 2); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["payment_method"]); ?>
                    </td>

                    <td>
                        <?php echo $row["donation_date"]; ?>
                    </td>

                </tr>

            <?php

            }

            ?>

            </tbody>

        </table>

    <?php

    } else {

        echo "<p class='no-data'>You have not made any donations yet.</p>";

    }

    ?>

</div>


<!-- Footer -->

<footer>

    <p>
        © 2026 DonateHope | Online Donation Management System
    </p>

</footer>


</body>

</html>

<?php

$stmt->close();

$conn->close();

?>