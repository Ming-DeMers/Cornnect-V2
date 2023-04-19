<?php
$tag_param = $_GET['tag'] ?? NULL;
$NOT_FOUND = False;
$message = '';

if ($tag_param != NULL) {
  $result = exec_sql_query(
    $db,
    "SELECT *, posts.id AS id, tags.tag AS 'tag' FROM posts INNER JOIN tags ON (tags.post_id = posts.id) WHERE tags.tag = " . "'" . $tag_param . "'"
  );
} else {
  // query the db
  $result = exec_sql_query(
    $db,
    "SELECT * FROM posts;"
  );
}

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
    <?php if (isset($tag_param)) { ?>
      Posts with the tag: <strong><?php echo htmlspecialchars($tag_param) ?></strong>
      <?php if (count($posts) == 0) { ?>
        <p>No posts found!</p>
      <?php } ?>

    <?php } ?>
    <?php include 'includes/posts.php'; ?>
  </main>
</body>

</html>
