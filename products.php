<?php include "config.php"; check_login(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Add or Remove Products</title>
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
<?php
if(isset($_POST['add'])){
  $name=$_POST['name']; $buy=$_POST['buying']; $sell=$_POST['selling']; $stock=$_POST['stock'];
  $conn->query("INSERT INTO products(name,buying_price,selling_price,stock) VALUES('$name',$buy,$sell,$stock)");
}
if(isset($_GET['del'])){ $id=$_GET['del']; $conn->query("DELETE FROM products WHERE id=$id"); }
$res=$conn->query("SELECT * FROM products");
?>
<div class="card shadow-sm p-3">
  <h3>Products</h3>
  <form method="post" class="row g-2">
    <div class="col-md-3"><input name="name" class="form-control" placeholder="Name"></div>
    <div class="col-md-2"><input name="buying" class="form-control" placeholder="Buying"></div>
    <div class="col-md-2"><input name="selling" class="form-control" placeholder="Selling"></div>
    <div class="col-md-2"><input name="stock" class="form-control" placeholder="Stock"></div>
    <div class="col-md-2"><button name="add" class="btn btn-primary w-100">Add</button></div>
  </form>
</div>
<div class="card mt-3 shadow-sm">
  <div class="card-body">
    <table class="table table-bordered table-striped">
      <thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Buy</th><th>Sell</th><th>Stock</th><th>Action</th><th></th></tr></thead>
      <tbody>
      <?php while($r=$res->fetch_assoc()): ?>
        <tr>
          <td><?= $r['id']?></td><td><?= $r['name']?></td>
          <td><?= $r['buying_price']?></td><td><?= $r['selling_price']?></td>
          <td><?= $r['stock']?></td>
          <td><a href="?del=<?= $r['id']?>" class="btn btn-sm btn-danger">Delete</a></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>