<?php include "config.php"; check_login();

$msg = "";
if(isset($_POST['sell'])){
  $pid = $_POST['product'];
  $qty = $_POST['qty'];
  $p = $conn->query("SELECT * FROM products WHERE id=$pid")->fetch_assoc();
  
  if($p && $p['stock'] >= $qty){
    $price = $p['selling_price'] * $qty;

    # Log sale
    $conn->query("INSERT INTO sales_log(product_id,qty,price) VALUES($pid,$qty,$price)");
    # Update stock and sold count
    $conn->query("UPDATE products SET stock=stock-$qty, sold=sold+$qty WHERE id=$pid");

    $msg = "Sale recorded!";
  } else {
    $msg = "Not enough stock!";
  }
}

$prods = $conn->query("SELECT * FROM products");
$sales = $conn->query("SELECT s.*,p.name FROM sales_log s JOIN products p ON p.id=s.product_id ORDER BY s.id DESC LIMIT 10");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sales</title>
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
<body class="bg-light">
<?php include 'navbar.php'; ?>

<div class="container mt-4">
  <div class="card p-4 shadow-sm">
    <h2>Sales</h2>
    <?php if($msg): ?>
      <div class="alert alert-info"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post" class="row g-2 mb-4">
      <div class="col-md-5">
        <select name="product" class="form-select">
          <?php while($r=$prods->fetch_assoc()): ?>
            <option value="<?= $r['id']?>"><?= $r['name']?> (stock:<?= $r['stock']?>)</option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-3">
        <input type="number" name="qty" value="1" class="form-control">
      </div>
      <div class="col-md-2">
        <button name="sell" class="btn btn-primary w-100">Sell</button>
      </div>
    </form>

    <h3>Recent Sales</h3>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr><th>Product</th><th>Qty</th><th>Price</th><th>Time</th></tr>
      </thead>
      <tbody>
      <?php while($s=$sales->fetch_assoc()): ?>
        <tr>
          <td><?= $s['name']?></td>
          <td><?= $s['qty']?></td>
          <td><?= $s['price']?></td>
          <td><?= $s['sale_time']?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
  </div>
</div>
</body>
</html>
