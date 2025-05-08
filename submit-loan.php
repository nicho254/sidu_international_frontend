<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];

// Collect form data safely
$full_name       = $_POST['full_name'] ?? '';
$id_number       = $_POST['id_number'] ?? '';
$dob             = $_POST['dob'] ?? '';
$gender          = $_POST['gender'] ?? '';
$phone_number    = $_POST['phone_number'] ?? '';
$email           = $_POST['email'] ?? '';
$nationality     = $_POST['nationality'] ?? '';
$residence       = $_POST['residence'] ?? '';
$employer_name   = $_POST['employer_name'] ?? '';
$job_title       = $_POST['job_title'] ?? '';
$employment_type = $_POST['employment_type'] ?? '';
$monthly_income  = $_POST['monthly_income'] ?? '';
$loan_amount     = $_POST['loan_amount'] ?? '';
$loan_purpose    = $_POST['loan_purpose'] ?? '';
$loan_term       = $_POST['loan_term'] ?? '';
$security_details = $_POST['security_details'] ?? '';
$referee_name    = $_POST['referee_name'] ?? '';
$referee_phone   = $_POST['referee_phone'] ?? '';
$referee_relation = $_POST['referee_relation'] ?? '';

if (
    $full_name && $id_number && $phone_number && $email &&
    $loan_amount && $loan_purpose
) {
    $stmt = $conn->prepare("INSERT INTO loan_applications 
        (user_id, full_name, id_number, dob, gender, phone_number, email, nationality, residence, employer_name, job_title, employment_type, monthly_income, loan_amount, loan_purpose, loan_term, security_details, referee_name, referee_phone, referee_relation) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "issssssssssssdsissss",
        $user_id, $full_name, $id_number, $dob, $gender, $phone_number, $email, $nationality, $residence,
        $employer_name, $job_title, $employment_type, $monthly_income, $loan_amount, $loan_purpose,
        $loan_term, $security_details, $referee_name, $referee_phone, $referee_relation
    );

    if ($stmt->execute()) {
        echo "<script>alert('Loan application submitted successfully.'); window.location.href='user-dashboard.php';</script>";
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Please fill all required fields.";
}

$conn->close();
?>
