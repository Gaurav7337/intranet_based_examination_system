<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';

// Fetch available exams
$exams = $conn->query("SELECT * FROM exams");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Exam Selection</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      padding: 40px;
      text-align: center;
    }
    .container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      display: inline-block;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    select, button {
      padding: 10px;
      font-size: 16px;
      margin: 20px 0;
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Welcome, <?php echo $_SESSION['student_id']; ?></h2>
    <p>Select your exam from the list below:</p>

    <form method="POST" action="exam.php">
      <select name="exam_id" required>
        <option value="">-- Select Exam --</option>
        <?php while($row = $exams->fetch_assoc()): ?>
          <option value="<?php echo $row['id']; ?>">
            <?php echo $row['exam_name']; ?>
          </option>
        <?php endwhile; ?>
      </select>
      <button type="submit">Start Exam</button>
    </form>
  </div>
</body>
</html>
