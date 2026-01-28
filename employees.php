<?php include "config.php"; check_login();

# Add 
if($_SESSION['role']=='manager' && isset($_POST['add'])){
  $name=$_POST['name']; $shift=$_POST['shift']; $salary=$_POST['salary']; $start=$_POST['start'];
  $conn->query("INSERT INTO employees(name,shift,monthly_salary,start_date) 
                VALUES('$name','$shift',$salary,'$start')");
}

# Update
if($_SESSION['role']=='manager' && isset($_POST['update'])){
  $id=$_POST['id']; $name=$_POST['name']; $shift=$_POST['shift']; $salary=$_POST['salary']; $start=$_POST['start'];
  $conn->query("UPDATE employees SET name='$name',shift='$shift',monthly_salary=$salary,start_date='$start' WHERE id=$id");
}

# Delete 
if($_SESSION['role']=='manager' && isset($_GET['del'])){
  $id=$_GET['del'];
  $conn->query("DELETE FROM employees WHERE id=$id");
}

$res=$conn->query("SELECT * FROM employees");
$editId = isset($_GET['edit']) ? $_GET['edit'] : null;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Employees</title>
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
    <h3 class="mb-3">Employees</h3>

    <!-- Add Employee Form -->
    <?php if($_SESSION['role']=='manager'): ?>
    <form method="post" class="row g-2 mb-3">
      <div class="col-md-3"><input name="name" class="form-control" placeholder="Name"></div>
      <div class="col-md-2"><input name="shift" class="form-control" placeholder="Shift"></div>
      <div class="col-md-2"><input name="salary" class="form-control" placeholder="Salary"></div>
      <div class="col-md-3"><input type="date" name="start" class="form-control"></div>
      <div class="col-md-2"><button name="add" class="btn btn-success w-100">Add</button></div>
    </form>
    <?php endif; ?>

    <!-- Employees Table -->
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th><th>Name</th><th>Shift</th><th>Monthly</th>
          <th>Per Day</th><th>Start</th>
          <?php if($_SESSION['role']=='manager'): ?><th>Action</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
      <?php while($e=$res->fetch_assoc()): ?>
        <tr>
        <?php if($editId==$e['id']): ?>
          <!-- Inline edit form -->
          <form method="post">
            <td><?= $e['id']?><input type="hidden" name="id" value="<?= $e['id']?>"></td>
            <td><input name="name" class="form-control" value="<?= $e['name']?>"></td>
            <td><input name="shift" class="form-control" value="<?= $e['shift']?>"></td>
            <td><input name="salary" class="form-control" value="<?= $e['monthly_salary']?>"></td>
            <td><?= $e['monthly_salary']/30?></td>
            <td><input type="date" name="start" class="form-control" value="<?= $e['start_date']?>"></td>
            <td>
              <button name="update" class="btn btn-primary btn-sm">Save</button>
              <a href="employees.php" class="btn btn-secondary btn-sm">Cancel</a>
            </td>
          </form>
        <?php else: ?>
          <!-- Normal row -->
          <td><?= $e['id']?></td>
          <td><?= $e['name']?></td>
          <td><?= $e['shift']?></td>
          <td><?= $e['monthly_salary']?></td>
          <td><?= $e['monthly_salary']/30?></td>
          <td><?= $e['start_date']?></td>
          <?php if($_SESSION['role']=='manager'): ?>
          <td>
            <a href="?edit=<?= $e['id']?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="?del=<?= $e['id']?>" class="btn btn-sm btn-danger" 
               onclick="return confirm('Delete this employee?');">Delete</a>
          </td>
          <?php endif; ?>
        <?php endif; ?>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>