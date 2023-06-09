<?php

define("MAX_FILE_SIZE", 1000000);
$logged_in = false;
$upload_feedback = array(
  'general_error' => False,
  'type_error' => False,
  'too_large' => False
);

// upload fields
$upload_file_name = NULL;
$upload_file_ext = NULL;

// query the db
if (is_user_logged_in()) {
  $logged_in = true;
  $posts = exec_sql_query(
    $db,
    "SELECT * FROM posts;"
  )->fetchAll();
}

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
  'file_name' => '',
  'file_ext' => ''
);

// validates if form was submitted:
if (isset($_POST['add-post'])) {
  $form_values['netid'] = $current_user['netid'];
  $form_values['location'] = trim($_POST['location']);
  $form_values['desc'] = trim($_POST['desc']);
  $form_values['tags'] = trim($_POST['tag']);

  // get the info about the uploaded files.
  $upload = $_FILES['image'];

  $form_valid = True;

  if ($form_values['location'] == '') {
    $form_valid = False;
    $form_feedback_classes['location'] = '';
  }


  if ($upload['error'] == UPLOAD_ERR_OK) {
    $upload_file_name = basename($upload['name']);
    $upload_file_ext = strtolower(pathinfo($upload_file_name, PATHINFO_EXTENSION));
  } else {
    $form_valid = False;
    $upload_feedback['general_error'] = True;
  }
  if (($upload['error'] == UPLOAD_ERR_INI_SIZE) || ($upload['error'] == UPLOAD_ERR_FORM_SIZE)) {
    $form_valid = False;
    $upload_feedback['too_large'] = True;
    // ensure the field is a jpg
  } else if ($upload_file_ext != 'jpg') {
    $form_valid = False;
    $upload_feedback['type_error'] = True;
  }

  // show confirmation if form is valid, otherwise set sticky values and echo them
  if ($form_valid) {
    exec_sql_query(
      $db,
      "INSERT INTO posts (netid, location, desc, date, file_name, file_ext) VALUES (:netid, :location, :desc, :date, :file_name, :file_ext);",
      array(
        ':netid' => $form_values['netid'],
        ':location' => $form_values['location'],
        ':desc' => $form_values['desc'],
        ':date' => date('Y-m-d H:i:s'),
        'file_name' => $upload_file_name,
        'file_ext' => $upload_file_ext
      )
    );
    // parse a string by its hashtags into a list
    $retry_form = False;
    $show_confirmation = True;
    $show_form = False;
    $record_id = $db->lastInsertId('id');
    $upload_storage_path = 'public/uploads/posts/' . $record_id . '.' . $upload_file_ext;
    if (move_uploaded_file($upload["tmp_name"], $upload_storage_path) == False) {
      error_log("Failed to permanently store the uploaded file on the file server. Please check that the server folder exists.");
    }
    $tags_list = explode("#", $_POST['tag']);
    //remove spaces from the tags
    foreach ($tags_list as $tag) {
      $tag = trim($tag);
    }
    // remove the first element in the list
    array_shift($tags_list);
    $post_id = $db->lastInsertId('id');
    $tags = exec_sql_query(
      $db,
      "SELECT * FROM tags;"
    )->fetchAll();
    // for each tag, insert it into the tags table and associate it to the post
    foreach ($tags_list as $tag) {
      exec_sql_query(
        $db,
        "INSERT INTO tags (post_id, tag) VALUES (:post_id, :tag);",
        array(
          ':post_id' => $post_id,
          ':tag' => $tag
        )
      );
    }
  } else {
    $retry_form = True;
    $sticky_values['location'] = $form_values['location'];
    $sticky_values['desc'] = $form_values['desc'];
    $sticky_values['tags'] = $form_values['tags'];
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
  <main>
    <?php if ($logged_in) { ?>
      <section>
        <div class="add-post">
          <h2>Add new post!</h2>
          <?php if ($show_form) { ?>
            <form method="post" action="/new_post" enctype="multipart/form-data" novalidate>
              <p class="feedback <?php echo $form_feedback_classes['location']; ?>">Where are you?</p>
              <div class="label-input">
                <label for="location_field">Location:</label>
                <input id="location_field" type="text" name="location" value="<?php echo $sticky_values['location']; ?>">
              </div>
              <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>">
              <?php if ($upload_feedback['too_large']) { ?>
                <p class="feedback">Files must be less than 1MB.</p>
              <?php } ?>
              <?php if ($upload_feedback['type_error']) { ?>
                <p class="feedback">We only accept jpg files.</p>
              <?php } ?>
              <?php if ($upload_feedback['general_error']) { ?>
                <p class="feedback">Please provide an image.</p>
              <?php } ?>
              <div class="label-input">
                <label for="upload-file">Image:</label>
                <input id="upload-file" type="file" name="image">
              </div>
              <div class="label-input">
                <label for="desc_field">Description:</label>
                <input id="desc_field" type="text" name="desc" value="<?php echo $sticky_values['desc']; ?>">
              </div>
              <!-- input to allow inserting of tags -->
              <div class="label-input">
                <label for="tag_field">Tags (hashtag seperated):</label>
                <input id="tag_field" type="text" name="tag">
              </div>
              <div class="add-button">
                <button type="submit" name="add-post">Add post! </button>
              </div>
            </form>
        </div>
      </section>
    <?php } ?>
    <?php if ($show_confirmation) { ?>
      <div class="confirmation">
        <section>
          <h3>Post Pubbed!</h3>
          <p>Thank you <?php echo htmlspecialchars($current_user['name']); ?>. Your post has been added! <?php echo $upload_file_ext ?>
          <p><a href="/post?id=<?php echo htmlspecialchars($post_id); ?>">See the post...</a></p>
        </section>
      </div>
    <?php } ?>
  <?php } else { ?>
    <div class="modal">
      <h2>Log in to see this user!</h2>
      <?php include 'includes/login.php'; ?>
    </div>
  <?php } ?>

  </main>
  <?php include 'includes/footer.php'; ?>
</body>


</html>
