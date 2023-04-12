<?php

// query the db
$result = exec_sql_query(
  $db,
  "SELECT * FROM posts;"
);

$records = $result->fetchAll();

// default page state.
$show_confirmation = False;

// // feedback message CSS classes
// $form_feedback_classes = array(
//   'name' => 'hidden',
//   'year' => 'hidden',
//   'netid' => 'hidden'
// );

// // values
// $form_values = array(
//   'name' => '',
//   'netid' => '',
//   'year' => '',
//   'major' => NULL,
//   'club' => NULL,
// );

// // sticky values
// $sticky_values = array(
//   'name' => '',
//   'netid' => '',
//   '2026' => '',
//   '2025' => '',
//   '2024' => '',
//   '2023' => '',
//   'year' => NULL,
//   'major' => NULL,
//   'clubs' => NULL
// );

// // validates if form was submitted:
// if (isset($_POST['add-user'])) {
//   $form_values['name'] = trim($_POST['name']);
//   $form_values['netid'] = trim($_POST['netid']);
//   $form_values['year'] = trim($_POST['year']);
//   $form_values['major'] = trim($_POST['major']);
//   $form_values['club'] = trim($_POST['club']);

//   // make sure major and club are NULL if empty
//   if ($form_values['major'] == '') {
//     $form_values['major'] = NULL;
//   }

//   if ($form_values['club'] == '') {
//     $form_values['club'] = NULL;
//   }

//   $form_valid = True;

//   // check if one of the years was selected
//   if ($form_values['year'] == NULL) {
//     $form_valid = False;
//     $form_feedback_classes['year'] = NULL;
//     $retry_form = True;
//   }

//   if ($form_values['name'] == '') {
//     $form_valid = False;
//     $form_feedback_classes['name'] = '';
//     $retry_form = True;
//   }

//   if ($form_values['netid'] == '') {
//     $form_valid = False;
//     $form_feedback_classes['netid'] = '';
//     $retry_form = True;
//   }

//   // show confirmation if form is valid, otherwise set sticky values and echo them
//   if ($form_valid) {
//     exec_sql_query(
//       $db,
//       "INSERT INTO cornellians (name, netid, year, major, club) VALUES (:name, :netid, :year, :major, :club);",
//       array(
//         ':name' => $form_values['name'],
//         ':netid' => $form_values['netid'],
//         ':year' => $form_values['year'],
//         ':major' => $form_values['major'],
//         ':club' => $form_values['club']
//       )
//     );
//     $retry_form = False;
//     $show_confirmation = True;
//   } else {
//     $retry_form = True;

//     $sticky_values['name'] = $form_values['name'];
//     $sticky_values['netid'] = $form_values['netid'];
//     $sticky_values['major'] = $form_values['major'];
//     $sticky_values['club'] = $form_values['club'];

//     $sticky_values['2026'] = ($form_values['year'] == '2026' ? 'checked' : '');
//     $sticky_values['2025'] = ($form_values['year'] == '2025' ? 'checked' : '');
//     $sticky_values['2024'] = ($form_values['year'] == '2024' ? 'checked' : '');
//     $sticky_values['2023'] = ($form_values['year'] == '2023' ? 'checked' : '');
//   }
// }
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
    <div class="add-form">

      <h2>Add new post!</h2>
      <form method="post" action="/post" novalidate>
        <p class="feedback <?php echo $form_feedback_classes['netid']; ?>">Please provide your netID</p>
        <div class="label-input">
          <label for="netid_field">netID:</label>
          <input id="netid_field" type="text" name="netid" value="<?php echo $sticky_values['netid']; ?>">
        </div>
        <p class="feedback <?php echo $form_feedback_classes['netid']; ?>">Please provide an image</p>
        <div class="label-input">
          <label for="image_field">Image:</label>
          <input id="image_field" type="text" name="image" value="<?php echo $sticky_values['image']; ?>">
        </div>
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

  <?php if ($show_confirmation) { ?>
    <div class="confirmation">
      <section>
        <h3>You've Been Added!</h3>
        <p>Thank you <?php echo htmlspecialchars($form_values['name']); ?>. Classmates can now find you on the World Wide Web! Hopefully you can find other <?php echo htmlspecialchars(YEAR[$form_values['year']]); ?>s in similar majors/clubs! </p>
        <?php $show_form = FALSE ?>
      </section>
    </div>
  <?php } ?>
</body>


</html>
