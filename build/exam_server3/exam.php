<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_POST['exam_id'])) {
    echo "No exam selected.";
    exit();
}

$exam_id = $_POST['exam_id'];
$_SESSION['exam_id'] = $exam_id; // Store in session for later use
?>
