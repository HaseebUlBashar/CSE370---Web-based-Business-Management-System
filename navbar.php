<?php if(!isset($_SESSION)) session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0d0d0eff;">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">CSE370-Business Management System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="products.php">Products Management</a></li>
        <li class="nav-item"><a class="nav-link" href="employees.php">Employee Management</a></li>
        <li class="nav-item"><a class="nav-link" href="sales.php">Sales Management</a></li>
        <li class="nav-item"><a class="nav-link" href="restock.php">Restock</a></li>
        <li class="nav-item"><a class="nav-link" href="to_be_restocked.php">Products To Be Restocked</a></li>
        <li class="nav-item"><a class="nav-link" href="revenue.php">Total Reveneue</a></li>
      </ul>
      <span class="ms-auto navbar-text">
        <?= $_SESSION['username']??'' ?> (<?= $_SESSION['role']??'' ?>) 
        | <a href="logout.php" style="background-color: #051663ff; color: white;">>Logout</a>
      </span>
    </div>
  </div>
</nav>
