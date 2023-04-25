<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/styles/site.css">

  <title>Sign Up</title>
</head>

<body>
  <?php include 'includes/header.php'; ?>
  <main>
    <?php echo signup_form('/profile', $session_messages);
    ?>
  </main>
  <?php include 'includes/footer.php'; ?>

</body>

</html>
