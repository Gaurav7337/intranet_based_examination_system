<?php
session_start();
include 'database.php';

$common_password = "exam123"; // Set your universal password

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate against DB
    $stmt = $conn->prepare("SELECT * FROM students WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1 && $password === $common_password) {
        $_SESSION['student_id'] = $username;

        // Optional: Log login time
        $log = $conn->prepare("INSERT INTO login_logs (student_id) VALUES (?)");
        $log->bind_param("s", $username);
        $log->execute();

        // ✅ Redirect to exam selection/dashboard page
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Student ID or Password.";
    }
}
?>

<!-- Frontend HTML form -->
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    input {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      background: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background: #45a049;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Student Login</h2>
    <form method="POST">
      <input type="text" name="username" placeholder="Student ID" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  </div>
</body>
</html>
