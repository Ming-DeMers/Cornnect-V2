<?php
// query the db
if (isset($_GET['netid'])) {
  $users = exec_sql_query(
    $db,
    "SELECT * FROM users WHERE users.id = " . $_GET['netid'] . ";"
  )->fetchAll();
} else {
  $users = exec_sql_query(
    $db,
    "SELECT * FROM users;"
  )->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../public/styles/site.css">
  <title>Cornnect - Users</title>
</head>

<body>
  <?php include 'includes/header.php'; ?>
  <main>

    <?php
    foreach ($users as $user) { ?>
      <div class="card">
        <div class="head">
          <?php echo htmlspecialchars($user['name']); ?> |
          <?php echo htmlspecialchars($user['netid']); ?> |
          <?php echo htmlspecialchars($user['year']); ?> |
        </div>
        <div class="photo"> <a href="/user?netid=<?php echo htmlspecialchars($user['netid']); ?>"> <img src="public/uploads/placeholder.jpg" alt=""></a>
        </div>
      </div>
    <?php } ?>


  </main>


</body>

</html>
