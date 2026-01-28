<?php 
include "config.php"; 
session_start();

if ($_SERVER['REQUEST_METHOD']=="POST") {
  $u = $_POST['username']; 
  $p = md5($_POST['password']);

  $q = $conn->query("SELECT * FROM users WHERE username='$u' AND password='$p'");
  if($q->num_rows > 0){ 
    $user = $q->fetch_assoc();
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    header("Location: dashboard.php"); 
    exit;
  } else {
    $error = "Invalid login!";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(rgba(16, 11, 31, 0.7), rgba(0, 0, 0, 0.7)), 
                  url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
  </style>
</head>
<body class="d-flex align-items-center" style="height:100vh;">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow p-4">
        <h3 class="text-center mb-3">Login</h3>
        <?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="post">
          <div class="mb-3">
            <input class="form-control" name="username" placeholder="Username" required>
          </div>
          <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>
          <button class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
