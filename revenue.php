<?php include "config.php"; check_login();

# Clear sales + restock logs (Manager only)
if($_SESSION['role']=='manager' && isset($_POST['clear'])){
  $conn->query("TRUNCATE TABLE sales_log");
  $conn->query("TRUNCATE TABLE restock_log");
}

# Calculate totals from logs + employees
$totals = $conn->query("
  SELECT 
    (SELECT IFNULL(SUM(price),0) FROM sales_log) AS total_earning,
    (
      (SELECT IFNULL(SUM(expense),0) FROM restock_log) +
      (SELECT IFNULL(SUM(monthly_salary/30),0) FROM employees)
    ) AS total_expenses
")->fetch_assoc();

$totals['total_profit'] = $totals['total_earning'] - $totals['total_expenses'];

# Daily breakdown (earnings & expenses per day, with employee daily salary included)
$res = $conn->query("
  SELECT 
    d.date,
    IFNULL(SUM(s.price),0) AS earning,
    (IFNULL(SUM(r.expense),0) + (SELECT IFNULL(SUM(monthly_salary/30),0) FROM employees)) AS expenses,
    (IFNULL(SUM(s.price),0) - (IFNULL(SUM(r.expense),0) + (SELECT IFNULL(SUM(monthly_salary/30),0) FROM employees))) AS profit
  FROM (
    SELECT CURDATE() as date
    UNION
    SELECT DISTINCT DATE(sale_time) FROM sales_log
    UNION
    SELECT DISTINCT DATE(restock_time) FROM restock_log
  ) d
  LEFT JOIN sales_log s ON DATE(s.sale_time)=d.date
  LEFT JOIN restock_log r ON DATE(r.restock_time)=d.date
  GROUP BY d.date
  ORDER BY d.date DESC
  LIMIT 30
");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Revenue</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(rgba(16, 11, 31, 0.7), rgba(0, 0, 0, 0.7)), 
                  url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1920&q=80');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      min-height: 100vh;
    }
  </style>
</head>
<body class="text-light">
<?php include 'navbar.php'; ?>

<div class="container mt-4">
  <div class="card shadow-sm p-4 bg-white text-dark">
    <div class="d-flex justify-content-between align-items-center">
      <h3>Total Revenue</h3>
      <?php if($_SESSION['role']=='manager'): ?>
      <form method="post" onsubmit="return confirm('Clear ALL sales and restock logs? This cannot be undone.');">
        <button name="clear" class="btn btn-danger btn-sm">Clear All</button>
      </form>
      <?php endif; ?>
    </div>

    <!-- Totals Summary -->
    <div class="row text-center mb-4 mt-3">
      <div class="col-md-4">
        <div class="p-3 bg-success text-white rounded">
          <h5>Total Earnings</h5>
          <p class="fs-5"><?= $totals['total_earning'] ?></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-3 bg-danger text-white rounded">
          <h5>Total Expenses</h5>
          <p class="fs-5"><?= $totals['total_expenses'] ?></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-3 bg-info text-white rounded">
          <h5>Total Profit</h5>
          <p class="fs-5"><?= $totals['total_profit'] ?></p>
        </div>
      </div>
    </div>

    <!-- Daily Breakdown -->
    <h4>Daily Revenue (Last 30 days)</h4>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr><th>Date</th><th>Earning</th><th>Expenses</th><th>Profit</th></tr>
      </thead>
      <tbody>
      <?php while($r=$res->fetch_assoc()): ?>
        <tr>
          <td><?= $r['date']?></td>
          <td><?= $r['earning']?></td>
          <td><?= $r['expenses']?></td>
          <td><?= $r['profit']?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Back</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
