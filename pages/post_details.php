<?php
$logged_in = false;

function format_date($date_string)
{
  if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $date_string)) {
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $date_string);
  } else {
    $date = DateTime::createFromFormat('Ymd', $date_string);
  }
  return $date->format('M d Y');
}

if (is_user_logged_in()) {
  $logged_in = true;
  $sql_select_post_query = "SELECT * FROM posts WHERE posts.id = " . $_GET['id'];
  $sql_select_tags_query = "SELECT posts.id AS id, tags.tag AS 'tag'
FROM posts INNER JOIN tags ON (tags.post_id = posts.id) WHERE posts.id = " . $_GET['id'];
  $sql_select_comments_query = "SELECT * FROM comments WHERE comments.post_id = " . $_GET['id'];

  $post = exec_sql_query(
    $db,
    $sql_select_post_query,
  )->fetchAll();

  $tags = exec_sql_query(
    $db,
    $sql_select_tags_query,
  )->fetchAll();

  $comments = exec_sql_query(
    $db,
    $sql_select_comments_query,
  )->fetchAll();
}
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
  <main id="post_details">
    <?php if ($logged_in) {
      if ($is_admin) {
        include 'includes/delete_post.php';
      } ?>
      <div class="details">
        <?php foreach ($post as $post) { ?>
          <div class="head">
            <h3>Posted by <a class="user-link" id="user-link-post-details" href="/user?netid=<?php echo htmlspecialchars($post['netid']); ?>"><?php echo htmlspecialchars($post['netid']); ?></a>, at
              <?php echo htmlspecialchars($post['location']); ?>,
              <?php echo format_date(htmlspecialchars($post['date'])); ?></h3>
          </div>
          <div class="post-photo">
            <?php $file_url = '/public/uploads/posts/' . $post['id'] . '.' . $post['file_ext']; ?>
            <img src="<?php echo htmlspecialchars($file_url); ?>" alt="<?php echo htmlspecialchars($record['file_name']); ?>">
          </div>
          <div class="desc">
            <ul><?php echo htmlspecialchars($post["desc"]); ?></ul>
          </div>
        <?php } ?>
        <div class="tags">
          <h3>Tags:</h3>
          <?php
          foreach ($tags as $tag) { ?>
            <a href="home?tag=<?php echo htmlspecialchars(($tag['tag'])); ?>"><?php echo htmlspecialchars($tag['tag']); ?></a>
        </div>
      <?php } ?>
      <div class="comments">
        <h3>Comments:</h3>
        <?php
        foreach ($comments as $comment) { ?>
          <div class="comment">
            <a class="user-link" id="user-link-comment" href="/user?netid=<?php echo htmlspecialchars($comment['netid']); ?>"><?php echo htmlspecialchars($comment['netid']); ?></a>) <?php echo htmlspecialchars($comment['comment']); ?>
          </div>
          <p></p>
        <?php } ?>
      </div>
    <?php } else { ?>
      <div class="modal">
      <?php echo "<h2>Log in to view post details!</h2>";
      include 'includes/login.php';
    } ?>
      </div>
      </div>
  </main>
  <?php include 'includes/footer.php'; ?>
</body>

</html>
