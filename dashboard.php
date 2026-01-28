<?php include "config.php"; check_login(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
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
    .container {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      background-color: rgba(8, 1, 31, 0.95);
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(3, 0, 0, 0.3);
      backdrop-filter: blur(10px);
      max-width: 600px;
      width: 100%;
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    h3 {
      color: #f6f9fcff;
      font-weight: 700;
      border-bottom: 2px solid #1889e6ff;
      padding-bottom: 10px;
    }
    .text-muted {
      color: #f8fafaff !important;
      font-size: 1.1rem;
    }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
  <div class="card shadow-sm p-5 text-center">
    <h3 class="mb-4">Welcome! <?= $_SESSION['username']?>!</h3>
    <p class="text-muted lead">The above menu is to be used for managing the system!!</p>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>