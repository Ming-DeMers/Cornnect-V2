<?php
if (is_user_logged_in()) {
  $user = exec_sql_query(
    $db,
    "SELECT * FROM users WHERE users.netid = " . "'" . $current_user['netid'] . "'" . ";"
  )->fetchAll();
  $posts = exec_sql_query(
    $db,
    "SELECT * FROM posts WHERE posts.netid = " . "'" . $current_user['netid'] . "'" . ";"
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
  <title>Document</title>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <main>
    <?php if (!is_user_logged_in()) { ?>
      <div class="modal">
        <h2>Welcome to Cornnect!</h2>
        <?php
        include 'includes/login.php'; ?>
      </div>
    <?php
    } else { ?>
      <?php if (count($user) == 0) { ?>
        <p>User not found!</p>
      <?php } else { ?>
        <div class="profile">
          <div class="profile-details">
            <?php
            foreach ($user as $user) { ?>
              <h2>More about <?php echo htmlspecialchars($user['name']); ?>
              </h2>
              <strong>Netid:</strong>
              <?php echo htmlspecialchars($user['netid']); ?>
              <strong>Year:</strong>
              <?php echo htmlspecialchars($user['year']); ?>
              <strong>Major</strong>
              <?php echo htmlspecialchars($user['major']); ?>
              <div class="photo">
                <?php $file_url = '/public/uploads/users/' . $user['netid'] . '.' . 'jpg'; ?>
                <img src="<?php echo htmlspecialchars($file_url); ?>" alt="<?php echo htmlspecialchars($user['netid'] . 'profile picture'); ?>">
              </div>
              <strong>Bio</strong>
              <?php echo htmlspecialchars($user['bio']); ?>
          </div>
        <?php } ?>

        <div class='profile-posts'>
          <h2>Posts by <?php echo htmlspecialchars($user['name']); ?></h2>
          <?php include 'includes/posts.php'; ?>
        </div>
        </div>
      <?php } ?>
    <?php }
    ?>
  </main>
  <?php include 'includes/footer.php'; ?>


</body>

</html>
