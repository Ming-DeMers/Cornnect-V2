<?php
// query the db
$result = exec_sql_query(
  $db,
  "SELECT * FROM posts;"
);


// get records from query
$posts = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../public/styles/site.css">
  <title>Cornnect - Home</title>
</head>

<body>
  <?php include 'includes/header.php'; ?>
  <main>
    <?php include 'includes/posts.php'; ?>
  </main>
</body>

</html>
