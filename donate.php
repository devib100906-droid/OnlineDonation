<?php

session_start();

include("db/database.php");


/* Check whether user is logged in */

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");

    exit();

}


/* Check whether cause ID is provided */

if (!isset($_GET["cause_id"])) {

    header("Location: causes.php");

    exit();

}


$cause_id = $_GET["cause_id"];


/* Get cause details */

$sql = "SELECT * FROM causes WHERE cause_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $cause_id);

$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows != 1) {

    echo "Cause not found.";

    exit();

}


$cause = $result->fetch_assoc();

$stmt->close();


$message = "";


/* Process Donation */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $amount = $_POST["amount"];

    $payment_method = $_POST["payment_method"];

    $user_id = $_SESSION["user_id"];


    $sql = "INSERT INTO donations
            (user_id, cause_id, amount, payment_method)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "iids",
        $user_id,
        $cause_id,
        $amount,
        $payment_method
    );


    if ($stmt->execute()) {

        $message = "Donation successful! Thank you for your contribution.";

    } else {

        $message = "Donation failed. Please try again.";

    }


    $stmt->close();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Make a Donation - DonateHope</title>

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
            <a href="donation_history.php">
                My Donations
            </a>
        </li>

        <li>
            <a href="logout.php">
                Logout
            </a>
        </li>

    </ul>

</nav>


<!-- Donation Heading -->

<section class="intro">

    <h2>
        Make a Donation
    </h2>

    <p>
        Your contribution can make a difference.
    </p>

</section>


<!-- Donation Form -->

<div class="form-container">


    <!-- Cause Details -->

    <h3>
        <?php echo htmlspecialchars($cause["cause_name"]); ?>
    </h3>

    <br>

    <p>
        <?php echo htmlspecialchars($cause["description"]); ?>
    </p>

    <br>

    <p>
        <strong>
            Target Amount:
            ₹<?php echo number_format($cause["target_amount"], 2); ?>
        </strong>
    </p>

    <br>


    <!-- Form -->

    <form
        method="POST"
        action="donate.php?cause_id=<?php echo $cause_id; ?>"
        onsubmit="return validateDonationForm();">


        <!-- Donation Amount -->

        <label>
            Donation Amount
        </label>

        <input
            type="number"
            id="amount"
            name="amount"
            min="1"
            step="0.01"
            placeholder="Enter donation amount"
            required
        >


        <!-- Payment Method -->

        <label>
            Payment Method
        </label>

        <select
            id="payment_method"
            name="payment_method"
            required>

            <option value="">
                Select Payment Method
            </option>

            <option value="UPI">
                UPI
            </option>

            <option value="Debit Card">
                Debit Card
            </option>

            <option value="Credit Card">
                Credit Card
            </option>

            <option value="Net Banking">
                Net Banking
            </option>

        </select>


        <br>


        <!-- Donate Button -->

        <button
            type="submit"
            class="donate-button">

            Donate Now

        </button>

    </form>


    <!-- Donation Message -->

    <?php

    if ($message != "") {

        echo "<p class='message'>$message</p>";

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

$conn->close();

?>