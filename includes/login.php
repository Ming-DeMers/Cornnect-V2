<div class="login">
  <h3>Login</h3>
  <?php
  echo login_form('/profile', $session_messages);
  if (is_user_logged_in()) {
    echo 'User is logged in!';
    if ($is_admin) {
      echo 'User is an admin!';
    }
  }
  ?>
  <h3>Not a user?</h3>
  <a href="/signup"><button>Sign up!</button></a>

</div>
