<?php

session_start();

if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: login.php");
    exit();
}

include("../db/database.php");

$message = "";


// Add new cause

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cause_name = $_POST["cause_name"];
    $description = $_POST["description"];
    $target_amount = $_POST["target_amount"];

    $sql = "INSERT INTO causes
            (cause_name, description, target_amount)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssd",
        $cause_name,
        $description,
        $target_amount
    );

    if ($stmt->execute()) {

        $message = "Cause added successfully!";

    } else {

        $message = "Failed to add cause.";

    }

    $stmt->close();
}


// Get all causes

$sql = "SELECT * FROM causes ORDER BY cause_id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Causes Management - Admin</title>

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
            <a href="../index.php">
                Website
            </a>
        </li>

    </ul>

</nav>


<!-- Heading -->

<section class="intro">

    <h2>Causes Management</h2>

    <p>
        Add and manage donation causes.
    </p>

</section>


<!-- Add Cause Form -->

<div class="form-container">

    <h3>Add New Cause</h3>

    <br>

    <form method="POST"
          action="causes.php">


        <label>Cause Name</label>

        <input
            type="text"
            name="cause_name"
            placeholder="Enter cause name"
            required
        >


        <label>Description</label>

        <textarea
            name="description"
            placeholder="Enter cause description"
            rows="5"
            required
        ></textarea>


        <label>Target Amount</label>

        <input
            type="number"
            name="target_amount"
            min="1"
            step="0.01"
            placeholder="Enter target amount"
            required
        >


        <button
            type="submit"
            class="donate-button">

            Add Cause

        </button>

    </form>


    <?php

    if ($message != "") {

        echo "<p class='message'>$message</p>";

    }

    ?>

</div>


<!-- Existing Causes -->

<section class="intro">

    <h2>Existing Causes</h2>

</section>


<div class="table-container">

    <?php

    if ($result->num_rows > 0) {

    ?>

        <table>

            <thead>

                <tr>

                    <th>Cause ID</th>
                    <th>Cause Name</th>
                    <th>Description</th>
                    <th>Target Amount</th>

                </tr>

            </thead>

            <tbody>

            <?php

            while ($row = $result->fetch_assoc()) {

            ?>

                <tr>

                    <td>
                        <?php echo $row["cause_id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["cause_name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["description"]); ?>
                    </td>

                    <td>
                        ₹<?php echo number_format($row["target_amount"], 2); ?>
                    </td>

                </tr>

            <?php

            }

            ?>

            </tbody>

        </table>

    <?php

    } else {

        echo "<p class='no-data'>No causes found.</p>";

    }

    ?>

</div>


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