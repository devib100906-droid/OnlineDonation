<?php

session_start();

if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: login.php");
    exit();
}

include("../db/database.php");

$sql = "SELECT user_id, name, email, phone
        FROM users
        ORDER BY user_id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Users - Admin</title>

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
            <a href="../index.php">
                Website
            </a>
        </li>

    </ul>

</nav>


<!-- Heading -->

<section class="intro">

    <h2>Registered Users</h2>

    <p>
        View users registered in the donation system.
    </p>

</section>


<!-- Users Table -->

<div class="table-container">

    <?php

    if ($result->num_rows > 0) {

    ?>

        <table>

            <thead>

                <tr>

                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>

                </tr>

            </thead>


            <tbody>

            <?php

            while ($row = $result->fetch_assoc()) {

            ?>

                <tr>

                    <td>
                        <?php echo $row["user_id"]; ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["name"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["email"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["phone"]); ?>
                    </td>

                </tr>

            <?php

            }

            ?>

            </tbody>

        </table>

    <?php

    } else {

        echo "<p class='no-data'>No registered users found.</p>";

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