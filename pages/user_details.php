<?php

$user = exec_sql_query(
  $db,
  "SELECT * FROM users WHERE users.netid = " . "'" . $_GET['netid'] . "'" . ";"
)->fetchAll();

$posts = exec_sql_query(
  $db,
  "SELECT * FROM posts WHERE posts.netid = " . "'" . $_GET['netid'] . "'" . ";"
)->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/styles/site.css">
  <title>Document</title>
</head>

<body>

  <?php include 'includes/header.php'; ?>

  <?php
  foreach ($user as $user) { ?>
    <h2>More about <?php echo htmlspecialchars($user['name']); ?>
    </h2>

    <?php echo htmlspecialchars($user['netid']); ?>
    <?php echo htmlspecialchars($user['year']); ?>
    <?php echo htmlspecialchars($user['major']); ?>
    <div class="photo">
      <img src="public/uploads/placeholder.jpg" alt="">
    </div>
    <?php echo htmlspecialchars($user['bio']); ?>
    </div>
  <?php } ?>

  <h2>Posts by <?php echo htmlspecialchars($user['name']); ?></h2>
  <?php include 'includes/posts.php'; ?>


</body>

</html>
