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
  <?php include 'includes/header.php'; ?>
  <main>
    <?php if (isset($tag_param)) { ?>
      Posts with the tag: <strong><?php echo htmlspecialchars($tag_param) ?></strong>
      <?php if (count($posts) == 0) { ?>
        <p>No posts found!</p>
      <?php } ?>
    <?php } ?>
    <div class="sort">
      Sort by:
      <?php $current_url = strstr($_SERVER['REQUEST_URI'], 'order=old', true);
      if ($current_url == '') {
        $current_url = $_SERVER['REQUEST_URI'];
      }
      if (str_contains($current_url, '?')) {
        $operator = '&';
      } ?>
      <a href="<?php echo $current_url ?>">New First</a>
      |
      <a href="<?php echo $current_url ?><?php echo $operator ?>order=old">Old First</a>
      <p>Clause: <?php echo $order_clause ?></p>
      <p>URL: <?php echo $current_url ?></p>
      <p>Op: <?php echo $operator ?></p>

    </div>
    <?php include 'includes/posts.php'; ?>
  </main>
</body>

</html>
