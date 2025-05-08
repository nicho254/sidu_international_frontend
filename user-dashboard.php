<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$mysqli = new mysqli("localhost", "root", "", "sidu_portal");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Get current user ID
$user_id = $_SESSION['user_id'];

// Fetch loan application for user
$query = "SELECT loan_amount, loan_status, due_date FROM loan_applications WHERE user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$loan = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - Sidu International</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
        }
        .dashboard {
            background: #fff;
            border: 1px solid #ddd;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            color: #0077cc;
        }
        .info {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome to Your Dashboard</h2>
        <?php if ($loan): ?>
            <div class="info">
                <p><strong>Loan Amount:</strong> Ksh <?php echo htmlspecialchars($loan['loan_amount']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($loan['loan_status']); ?></p>
                <p><strong>Due Date:</strong> <?php echo htmlspecialchars($loan['due_date']); ?></p>
            </div>
        <?php else: ?>
            <p>You have not submitted a loan application yet.</p>
        <?php endif; ?>

        <a href="loan-form.php">Apply for a Loan</a> |
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
