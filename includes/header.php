  <header>
    <h1>Cornnect</h1>
    <h2>The place for all your pals!</h2>
    <nav class="navbar">
      <div class="nav-pages">
        <a href="/"><button>Home</button></a>
        <a href="/new_post"> <button>New post!</button></a>
        <a href="/users"> <button>Users</button></a>
      </div>
      <div class="nav-search">
        <search-box>
          <form id="tag_search" method="get" action="/">
            <input type="search" id="search-box" name="tag" placeholder="Search for a tag...">
            <input type="submit" id="search-button" value="Search">
          </form>
        </search-box>
      </div>
      <div class="profiles">
        <a href="/profile"> <button>Profile</button></a>
        <?php
        if (is_user_logged_in()) { ?>
          <a href="<?php echo logout_url(); ?>">
            <button>Sign Out</button></a>
          <?php
          if ($is_admin) {
            echo "ADMIN MODE ENABLED"; ?>
          <?php }
        } else { ?>
          <a href="/profile"><button>Log in!</button></a>
        <?php } ?>
      </div>
    </nav>
  </header>

  <!-- hide the header when scrolling -->
  <script>
    var prevScrollpos = window.pageYOffset;
    window.onscroll = function() {
      var currentScrollPos = window.pageYOffset;
      if (prevScrollpos > currentScrollPos) {
        document.querySelector("header").style.top = "0";
      } else {
        document.querySelector("header").style.top = "-135px";
      }
      prevScrollpos = currentScrollPos;
    }
  </script>
