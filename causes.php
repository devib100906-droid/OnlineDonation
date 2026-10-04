<?php

include("db/database.php");

$sql = "SELECT * FROM causes";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Causes - DonateHope</title>

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


<!-- Causes Heading -->

<section class="intro">

    <h2>Support Our Causes</h2>

    <p>
        Choose a cause and make a meaningful contribution
        to support people in need.
    </p>

</section>


<!-- Dynamic Causes -->

<section class="features">

    <div class="feature-container">


        <?php

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

        ?>

                <div class="feature-card">

                    <h3>
                        <?php echo htmlspecialchars($row["cause_name"]); ?>
                    </h3>

                    <p>
                        <?php echo htmlspecialchars($row["description"]); ?>
                    </p>

                    <br>

                    <p>
                        <strong>
                            Target Amount:
                            ₹<?php echo number_format($row["target_amount"], 2); ?>
                        </strong>
                    </p>

                    <br>

                    <a href="donate.php?cause_id=<?php echo $row["cause_id"]; ?>"
                       class="donate-button">

                        Donate

                    </a>

                </div>

        <?php

            }

        } else {

            echo "<p>No causes available at the moment.</p>";

        }

        ?>

    </div>

</section>


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