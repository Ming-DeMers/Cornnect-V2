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
  <!-- <?php include 'includes/login.php'; ?> -->

  <?php
  echo login_form('/profile', $session_messages);
  if (is_user_logged_in()) {
    echo 'User is logged in!';
    if ($is_admin) {
      echo 'User is an admin!';
    }
  }
  ?>
  Not a user?
  <h3>Create an account</h3>
  <?php echo signup_form('/profile', $session_messages);
  ?>
</body>

</html>
