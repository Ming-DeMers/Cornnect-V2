<div class="login">
  <?php if (!is_user_logged_in()) { ?>
    <h2>Sign In</h2>
  <?php echo login_form('/profile', $session_messages);
  } ?>

</div>
