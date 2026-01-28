<?php include "config.php"; check_login();

$msg = "";
if(isset($_POST['restock'])){
  $pid = $_POST['product'];
  $qty = $_POST['qty'];
  
  # Get product info
  $p = $conn->query("SELECT * FROM products WHERE id=$pid")->fetch_assoc();
  if($p){
    $expense = $p['buying_price'] * $qty;

    # Log restock
    $conn->query("INSERT INTO restock_log(product_id,qty,expense) VALUES($pid,$qty,$expense)");
    # Update stock
    $conn->query("UPDATE products SET stock=stock+$qty WHERE id=$pid");

    $msg = "Restock recorded!";
  }
}

$prods=$conn->query("SELECT * FROM products");
$logs=$conn->query("SELECT r.*,p.name FROM restock_log r JOIN products p ON p.id=r.product_id ORDER BY r.id DESC LIMIT 10");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Restock</title>
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
<body class="bg-light">
<?php include 'navbar.php'; ?>

<div class="container mt-4">
  <div class="card p-4 shadow-sm">
    <h2>Restock</h2>
    <?php if($msg): ?>
      <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post" class="row g-2 mb-4">
      <div class="col-md-5">
        <select name="product" class="form-select">
          <?php while($r=$prods->fetch_assoc()): ?>
            <option value="<?= $r['id']?>"><?= $r['name']?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-3">
        <input type="number" name="qty" value="1" class="form-control">
      </div>
      <div class="col-md-2">
        <button name="restock" class="btn btn-primary w-100">Restock</button>
      </div>
    </form>

    <h3>Recent Restocks</h3>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr><th>Product</th><th>Qty</th><th>Expense</th><th>Time</th></tr>
      </thead>
      <tbody>
      <?php while($r=$logs->fetch_assoc()): ?>
        <tr>
          <td><?= $r['name']?></td>
          <td><?= $r['qty']?></td>
          <td><?= $r['expense']?></td>
          <td><?= $r['restock_time']?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
  </div>
</div>
</body>
</html>
