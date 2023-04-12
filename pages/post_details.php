<?php

$sql_select_post_query = "SELECT * FROM posts WHERE posts.id = " . $_GET['id'];
$sql_select_tags_query = "SELECT posts.id AS id, tags.tag AS 'tag'
FROM posts INNER JOIN tags ON (tags.post_id = posts.id) WHERE posts.id = " . $_GET['id'];

$sql_select_query = $sql_select_clause . ';';

$post = exec_sql_query(
  $db,
  $sql_select_tags_query,
)->fetchAll();

$tags = exec_sql_query(
  $db,
  $sql_select_tags_query,
)->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/styles/site.css">
  <title>Cornnect - Details</title>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <p>A post of your choosing would go here...</p>
  <div class="card">
    <div class="head">
      <ul><?php echo htmlspecialchars($post['netid']); ?></ul> |
      <ul><?php echo htmlspecialchars($post['date']); ?></ul> |
      <ul><?php echo htmlspecialchars($post['location']); ?></ul> |
    </div>
    <div class="photo">
      <img src="public/uploads/placeholder.jpg" alt="">
    </div>
    <div class="desc">
      <ul><?php echo htmlspecialchars($post["desc"]); ?></ul>
    </div>
  </div>
  <div class="tags">
    Tags!
    <?php
    foreach ($tags as $tag) { ?>
      <?php echo htmlspecialchars($tag['tag']); ?>,</div>
<?php } ?>

</body>

</html>
