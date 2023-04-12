<?php

// query the db
$posts = exec_sql_query(
  $db,
  "SELECT * FROM posts;"
)->fetchAll();

// default page state.
$show_confirmation = False;
$show_form = True;

// feedback message CSS classes
$form_feedback_classes = array(
  'netid' => 'hidden',
  'location' => 'hidden'
);

// values
$form_values = array(
  'netid' => '',
  'location' => '',
  'desc' => NULL,
);

// validates if form was submitted:
if (isset($_POST['add-post'])) {
  $form_values['netid'] = trim($_POST['netid']);
  $form_values['location'] = trim($_POST['location']);
  $form_values['desc'] = trim($_POST['desc']);

  $form_valid = True;

  // validate form values
  if ($form_values['netid'] == '') {
    $form_valid = False;
    $form_feedback_classes['netid'] = '';
  }

  if ($form_values['location'] == '') {
    $form_valid = False;
    $form_feedback_classes['location'] = '';
  }

  // show confirmation if form is valid, otherwise set sticky values and echo them
  if ($form_valid) {
    exec_sql_query(
      $db,
      "INSERT INTO posts (netid, location, desc, date) VALUES (:netid, :location, :desc, :date);",
      array(
        ':netid' => $form_values['netid'],
        ':location' => $form_values['location'],
        ':desc' => $form_values['desc'],
        ':date' => date('Y-m-d H:i:s')
      )
    );
    $retry_form = False;
    $show_confirmation = True;
    $show_form = False;
  } else {
    $retry_form = True;
    $sticky_values['netid'] = $form_values['netid'];
    $sticky_values['location'] = $form_values['location'];
    $sticky_values['desc'] = $form_values['desc'];
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../public/styles/site.css">
  <title>Cornnect - New Post</title>
</head>

<body>
  <?php include 'includes/header.php'; ?>
  <section>
    <div class="add-post">

      <h2>Add new post!</h2>
      <?php if ($show_form) { ?>
        <form method="post" action="/new_post" novalidate>
          <p class="feedback <?php echo $form_feedback_classes['netid']; ?>">Please provide your netID</p>
          <div class="label-input">
            <label for="netid_field">netID:</label>
            <input id="netid_field" type="text" name="netid" value="<?php echo $sticky_values['netid']; ?>">
          </div>
          <!-- <p class="feedback <?php echo $form_feedback_classes['netid']; ?>">Please provide an image</p> -->
          <div class="label-input">
            <label for="image_field">Image:</label>
            <input id="image_field" type="text" name="image" value="<?php echo $sticky_values['image']; ?>">
          </div>
          <p class="feedback <?php echo $form_feedback_classes['location']; ?>">Where are you?</p>
          <div class="label-input">
            <label for="location_field">Location:</label>
            <input id="location_field" type="text" name="location" value="<?php echo $sticky_values['location']; ?>">
          </div>
          <div class="label-input">
            <label for="desc_field">Description:</label>
            <input id="desc_field" type="text" name="desc" value="<?php echo $sticky_values['desc']; ?>">
          </div>
          <div class="add-button">
            <input type="submit" value="Add post!" name="add-post">
          </div>
        </form>
    </div>
  </section>

<?php } ?>

<?php if ($show_confirmation) { ?>
  <div class="confirmation">
    <section>
      <h3>Post Pubbed!</h3>
      <p>Thank you <?php echo htmlspecialchars($form_values['netid']); ?>. Your post has been added!</p>
      <?php $show_form = FALSE ?>
    </section>
  </div>
<?php } ?>
</body>


</html>
