<?php include "config.php"; check_login();

# Products below threshold (50)
$low=$conn->query("SELECT *,(50-stock) AS need FROM products WHERE stock<50");
?>
<!DOCTYPE html>
<html>
<head>
  <title>To Be Restocked</title>
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
<body style="background-color: #09041bff; color: white;">
<?php include 'navbar.php'; ?>

<div class="container mt-4">
  <div class="card shadow-sm p-4">
    <h3>Products Needing Restock:</h3>
    <p style="background-color: #4b0505ff; color: white;">>These products have stock below 50 units.</p>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr><th>Product</th><th>Stock</th><th>Needed</th></tr>
      </thead>
      <tbody>
      <?php while($r=$low->fetch_assoc()): if($r['need']<=0) continue; ?>
        <tr>
          <td><?= $r['name']?></td>
          <td><?= $r['stock']?></td>
          <td><?= $r['need']?></td>
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