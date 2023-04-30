<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-post'])) {
  if (unlink("public/uploads/posts/" . $_GET['id'] . ".jpg")) {
    $post_id = $_GET['id'];
    exec_sql_query(
      $db,
      "DELETE FROM posts WHERE posts.id = " . $post_id,
    );
    exec_sql_query(
      $db,
      "DELETE FROM tags WHERE tags.post_id = " . $post_id,
    );
    exec_sql_query(
      $db,
      "DELETE FROM comments WHERE comments.post_id = " . $post_id,
    );
  }
  //redirect to home page
  header("Location: /home");
  echo ('Post sucessfully deleted.');
  exit();
}
?>
<form method="post">
  <button type="submit" name="delete-post">Delete this post permanantly</button>
</form>
