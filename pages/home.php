<?php
$tag_param = $_GET['tag'] ?? NULL;
$select_clause = "SELECT * FROM posts";
$operator = '?';

if ($tag_param != NULL) {
  $select_clause = "SELECT *, posts.id AS id, tags.tag AS 'tag' FROM posts INNER JOIN tags ON (tags.post_id = posts.id) WHERE tags.tag = " . "'" . $tag_param . "'";
}

if ($_GET['order'] == 'old') {
  $order_clause = "ORDER BY date ASC";
} else {
  $order_clause = "ORDER BY date DESC";
}

$sql_query = $select_clause . " " . $order_clause . ';';

$posts = exec_sql_query(
  $db,
  $sql_query
)->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../public/styles/site.css">
  <title>Cornnect - Home</title>
</head>


<body>
  <header>
    <?php include 'includes/header.php'; ?>
  </header>
  <main>
    <div class="sidebar">
      <?php include 'includes/sidebar.php'; ?>
    </div>
    <div class="feed">
      <?php if (isset($tag_param)) { ?>
        Posts with the tag: <strong><?php echo htmlspecialchars($tag_param) ?></strong>
        <?php if (count($posts) == 0) { ?>
          <p>No posts found!</p>
        <?php } ?>
      <?php } ?>
      <?php include 'includes/posts.php'; ?>
    </div>

  </main>
  <footer>
    <?php include 'includes/footer.php'; ?>
  </footer>
</body>

</html>
