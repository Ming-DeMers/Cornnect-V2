<?php
include_once('includes/db.php');

// User Messages
$session_messages = array();
$signup_messages = array();

// cookie duration expiration time in seconds
define('SESSION_COOKIE_DURATION', 60 * 60 * 1); // 1 hour = 60 sec * 60 min * 1 hr

// find user's record from netid
function find_user($db, $netid)
{
  $records = exec_sql_query(
    $db,
    "SELECT * FROM users WHERE netid = :netid;",
    array(':netid' => $netid)
  )->fetchAll();
  if ($records) {
    // users are unique, there should only be 1 record
    return $records[0];
  }
  return NULL;
}

// find group's record from netid
function find_group($db, $group_id)
{
  $records = exec_sql_query(
    $db,
    "SELECT * FROM groups WHERE id = :group_id;",
    array(':group_id' => $group_id)
  )->fetchAll();
  if ($records) {
    // groups are unique, there should only be 1 record
    return $records[0];
  }
  return NULL;
}

// find user's record from session hash
function find_session($db, $session)
{
  if (isset($session)) {
    $records = exec_sql_query(
      $db,
      "SELECT * FROM sessions WHERE session = :session;",
      array(':session' => $session)
    )->fetchAll();
    if ($records) {
      // sessions are unique, so there should only be 1 record
      return $records[0];
    }
  }
  return NULL;
}

// provide a function alternative to  $current_user
function current_user()
{
  global $current_user;
  return $current_user;
}

// Did the user log in?
function is_user_logged_in()
{
  global $current_user;

  // if $current_user is not NULL, then a user is logged in!
  return ($current_user != NULL);
}

// is the user a member
function is_user_member_of($db, $group_id)
{
  global $current_user;
  if ($current_user === NULL) {
    return False;
  }

  $records = exec_sql_query(
    $db,
    "SELECT id FROM user_groups WHERE (group_id = :group_id) AND (netid = :netid);",
    array(
      ':group_id' => $group_id,
      ':netid' => $current_user['netid']
    )
  )->fetchAll();
  if ($records) {
    return True;
  } else {
    return False;
  }
}

// login with netid and password
function password_login($db, &$messages, $netid, $password)
{
  global $current_user;
  global $sticky_login_netid;

  $netid = trim($netid);
  $password = trim($password);
  $sticky_login_netid = $netid;

  if (isset($netid) && isset($password)) {
    // Does this netid even exist in our database?
    $records = exec_sql_query(
      $db,
      "SELECT * FROM users WHERE netid = :netid;",
      array(':netid' => $netid)
    )->fetchAll();
    if ($records) {
      // netid is UNIQUE, so there should only be 1 record.
      $user = $records[0];

      // Check password against hash in DB
      if (password_verify($password, $user['password'])) {
        // Generate session
        $session = session_create_id();

        // Store session ID in database
        $result = exec_sql_query(
          $db,
          "INSERT INTO sessions (netid, session, last_login) VALUES (:netid, :session, datetime());",
          array(
            ':netid' => $user['netid'],
            ':session' => $session
          )
        );
        if ($result) {
          // Success, session stored in DB

          // Send this back to the user.
          setcookie("session", $session, time() + SESSION_COOKIE_DURATION, '/');

          error_log("  login via password successful");
          $current_user = $user;
          return $current_user;
        } else {
          array_push($messages, "Log in failed.");
        }
      } else {
        array_push($messages, "Invalid netid or password.");
      }
    } else {
      array_push($messages, "Invalid netid or password.");
    }
  } else {
    array_push($messages, "No netid or password given.");
  }

  error_log("  failed to login via password");
  $current_user = NULL;
  return $current_user;
}

// login via session cookie
function cookie_login($db, $session)
{
  global $current_user;

  // Did we find the existing session?
  if ($session) {

    // has the session expired?
    $login_expiration = new DateTime($session['last_login']);
    $login_expiration->modify('+ ' . SESSION_COOKIE_DURATION . ' seconds');
    $current_datetime = new DateTime();
    if ($login_expiration >= $current_datetime) {
      // session has not expired

      $current_user = find_user($db, $session['netid']);

      // update the last login in the DB
      exec_sql_query(
        $db,
        "UPDATE sessions SET last_login = datetime() WHERE (id = :session_id);",
        array(':session_id' => $session['id'])
      );

      // Renew the cookie for 1 more hour
      setcookie("session", $session['session'], time() + SESSION_COOKIE_DURATION, '/');

      error_log("  login via cookie successful");
      return $current_user;
    } else {
      // session has expired
      error_log("  session expired");
      logout($db, $session);
    }
  }

  error_log("  failed to login via cookie");
  $current_user = NULL;
  return NULL;
}

// logout
function logout($db, $session)
{
  if ($session) {
    // Delete session from database.
    // Note: You probably also need a "cron" job that cleans up expired sessions.
    exec_sql_query(
      $db,
      "DELETE FROM sessions WHERE (session = :session_id);",
      array(':session_id' => $session['session'])
    );
  }

  // Remove the session from the cookie and force it to expire (go back in time).
  setcookie('session', '', time() - SESSION_COOKIE_DURATION, '/');

  // $current_user keeps track of logged in user, set to NULL to forget.
  global $current_user;
  $current_user = NULL;

  error_log("  logout successful");

  // Remove logout query string parameter
  $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

  // Remove a logout query string parameter
  $params = $_GET;
  unset($params['logout']);

  // Add logout param to current page URL.
  $redirect_url = htmlspecialchars($request_uri) . '?' . http_build_query($params);

  // Send the user back to the transcript page
  header('Location: ' . $redirect_url);
  exit();
}

// logout url for the current page
function logout_url()
{
  $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

  // Add a logout query string parameter
  $params = $_GET;
  $params['logout'] = '';

  // Add logout param to current page URL.
  $logout_url = htmlspecialchars($request_uri) . '?' . http_build_query($params);

  return $logout_url;
}

// render login form
function login_form($action, $messages)
{
  global $sticky_login_netid;
  ob_start();
?>
  <ul class="login">
    <?php
    foreach ($messages as $message) {
      echo "<li class=\"feedback\"><strong>" . htmlspecialchars($message) . "</strong></li>\n";
    } ?>
  </ul>

  <form class="login" action="<?php echo htmlspecialchars($action) ?>" method="post" novalidate>
    <div class="label-input">
      <label for="netid">netid:</label>
      <input id="netid" type="text" name="login_netid" value="<?php echo htmlspecialchars($sticky_login_netid); ?>" required />
    </div>

    <div class="label-input">
      <label for="password">Password:</label>
      <input id="password" type="password" name="login_password" required />
    </div>

    <div class="align-right">
      <button name="login" type="submit">Sign In</button>
    </div>
  </form>
<?php
  $html = ob_get_clean();
  return $html;
}

// Check for login, logout requests. Or check to keep the user logged in.
function process_session_params($db, &$messages)
{
  // Is there a session? If so, find it!
  $session = NULL;
  if (isset($_COOKIE["session"])) {
    $session_hash = $_COOKIE["session"];

    $session = find_session($db, $session_hash);
  }

  if (isset($_GET['logout']) || isset($_POST['logout'])) { // Check if we should logout the user
    error_log("  attempting to logout...");
    logout($db, $session);
  } else if (isset($_POST['login'])) { // Check if we should login the user
    error_log("  attempting to login with netid and password...");
    password_login($db, $messages, $_POST['login_netid'], $_POST['login_password']);
  } else if ($session) { // check if logged in already via cookie
    error_log("  attempting to login via cookie...");
    cookie_login($db, $session);
  }
}

// alias for process_session_params
function process_login_params($db, &$messages)
{
  process_session_params($db, $messages);
}

// function to create user account
function create_account($db, $name, $netid, $password, $password_confirmation, $year, $major)
{
  global $signup_messages;

  global $sticky_signup_netid;
  global $sticky_signup_name;

  $name = trim($name);
  $netid = trim($netid);
  $password = trim($password);
  $year = trim($year);
  $major = trim($major);
  $password_confirmation = trim($password_confirmation);

  $sticky_signup_netid = $netid;
  $sticky_signup_name = $name;

  $account_valid = True;

  $db->beginTransaction();

  // check if netid is unique, give error message if not.
  if (empty($netid)) {
    $account_valid = False;
    array_push($signup_messages, "Please provide a netid.");
  } else {
    $records = exec_sql_query(
      $db,
      "SELECT netid FROM users WHERE (netid = :netid);",
      array(
        ':netid' => $netid
      )
    )->fetchAll();
    if (count($records) > 0) {
      $account_valid = False;
      array_push($signup_messages, "netid is already taken, please pick another netid.");
    }
  }

  if (empty($password)) {
    $account_valid = False;
    array_push($signup_messages, "Please provide a password.");
  }

  // Check if passwords match
  if ($password != $password_confirmation) {
    $account_valid = False;
    array_push($signup_messages, "Password confirmation doesn't match your password. Please reenter your password.");
  } else {
    // hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  }

  if ($account_valid) {
    $result = exec_sql_query(
      $db,
      "INSERT INTO users (name, netid, password, year, major) VALUES (:name, :netid, :password, :year, :major);",
      array(
        ':name' => $name,
        ':netid' => $netid,
        ':password' => $hashed_password,
        ':year' => $year,
        ':major' => $major
      )
    );
    if ($result) {
      // account creation was successful. Login.
      password_login($db, $messages, $netid, $password);
    } else {
      array_push($messages, "Password confirmation doesn't match your password. Please reenter your password.");
    }
  }

  $db->commit();
}

// render sign up form
function signup_form($action, $signup_messages)
{
  global $sticky_signup_netid;
  global $sticky_signup_name;
  ob_start();
?>
  <ul class="signup">
    <?php
    foreach ($signup_messages as $message) {
      echo "<li class=\"feedback\"><strong>" . htmlspecialchars($message) . "</strong></li>\n";
    } ?>
  </ul>



  <form class="signup" action="<?php echo htmlspecialchars($action) ?>" method="post" novalidate>
    <h2>Sign up for Cornnect!</h2>
    <em>Please note this feature does not currently work</em>
    <div class="label-input">
      <label for="name">Name:</label>
      <input id="name" type="text" name="signup_name" value="<?php echo htmlspecialchars($sticky_signup_name); ?>" required />
    </div>

    <div class="label-input">
      <label for="netid">netid:</label>
      <input id="netid" type="text" name="signup_netid" value="<?php echo htmlspecialchars($sticky_signup_netid); ?>" required />
    </div>

    <div class="label-input">
      <label for="password">Password:</label>
      <input id="password" type="password" name="signup_password" required />
    </div>

    <div class="label-input">
      <label for="confirm_password">Confirm Password:</label>
      <input id="confirm_password" type="password" name="signup_confirm_password" required />
    </div>

    <div class="label-input">
      <label for="year">Year:</label>
      <input id="year" type="number" name="signup_number" required />
    </div>

    <div class="label-input">
      <label for="major">Major:</label>
      <input id="major" type="text" name="signup_major" required />
    </div>

    <div class="align-right">
      <button name="signup" type="submit">Sign Up</button>
    </div>

  </form>
<?php
  $html = ob_get_clean();
  return $html;
}

// Check for sign up request
function process_signup_params($db)
{
  // Check if we should login the user
  if (isset($_POST['signup'])) {
    create_account($db, $_POST['signup_name'], $_POST['signup_netid'], $_POST['signup_password'], $_POST['signup_confirm_password'], $_POST['signup_year'], $_POST['signup_major']);
  }
}
