<?php
session_start();
require 'db.php';

// Simple admin check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.php");
    exit();
}

$sql = "SELECT users.full_name, users.id_number, loan_applications.* 
        FROM loan_applications 
        JOIN users ON loan_applications.user_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - View Loan Applications</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #dff0ff; }
    </style>
</head>
<body>
    <h2>Loan Applications</h2>
    <table>
        <tr>
            <th>Applicant</th>
            <th>ID Number</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Submitted On</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['id_number']); ?></td>
            <td>Ksh <?php echo htmlspecialchars($row['loan_amount']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['due_date']); ?></td>
            <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
