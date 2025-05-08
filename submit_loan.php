<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "sidu_portal");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize inputs
$full_name = $_POST['full_name'];
$id_number = $_POST['id_number'];
$nationality = $_POST['nationality'];
$town = $_POST['town'];
$phone = $_POST['phone'];
$alt_phone = $_POST['alt_phone'];
$email = $_POST['email'];
$marital_status = $_POST['marital_status'];
$spouse_name = $_POST['spouse_name'];
$spouse_id = $_POST['spouse_id'];
$spouse_phone = $_POST['spouse_phone'];
$res_location = $_POST['res_location'];
$plot_name = $_POST['plot_name'];
$house_no = $_POST['house_no'];
$landmark = $_POST['landmark'];
$gate_color = $_POST['gate_color'];
$business_ownership = $_POST['business_ownership'];
$business_name = $_POST['business_name'];
$years_operation = $_POST['years_operation'];
$registration_no = $_POST['registration_no'];
$licence_no = $_POST['licence_no'];
$business_mode = $_POST['business_mode'];
$business_location = $_POST['business_location'];
$business_landmark = $_POST['business_landmark'];
$business_value = $_POST['business_value'];
$daily_income = $_POST['daily_income'];
$loan_amount = $_POST['loan_amount'];
$loan_words = $_POST['loan_words'];
$loan_purpose = $_POST['loan_purpose'];
$interest_rate = $_POST['interest_rate'];
$repayment_period = $_POST['repayment_period'];
$repayment_plan = $_POST['repayment_plan'];
$acceptance_signature = $_POST['acceptance_signature'];
$collateral_description = $_POST['collateral_description'];

$stmt = $conn->prepare("INSERT INTO loan_applications 
(user_id, full_name, id_number, nationality, town, phone, alt_phone, email, marital_status, spouse_name, spouse_id, spouse_phone, res_location, plot_name, house_no, landmark, gate_color, business_ownership, business_name, years_operation, registration_no, licence_no, business_mode, business_location, business_landmark, business_value, daily_income, loan_amount, loan_words, loan_purpose, interest_rate, repayment_period, repayment_plan, acceptance_signature, collateral_description)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssssssssssssssssssssssssssssssss", 
    $_SESSION['user_id'], $full_name, $id_number, $nationality, $town, $phone, $alt_phone, $email, $marital_status, $spouse_name, $spouse_id, $spouse_phone, $res_location, $plot_name, $house_no, $landmark, $gate_color, $business_ownership, $business_name, $years_operation, $registration_no, $licence_no, $business_mode, $business_location, $business_landmark, $business_value, $daily_income, $loan_amount, $loan_words, $loan_purpose, $interest_rate, $repayment_period, $repayment_plan, $acceptance_signature, $collateral_description
);

if ($stmt->execute()) {
    echo "Loan application submitted successfully. <a href='user-dashboard.php'>Go to Dashboard</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
