  <h1>Cornnect</h1>
  <h2>The place for all your pals!</h2>
  <nav class="navbar">
  <a href="/"><button>Home</button></a>
    <a href="/new_post"> <button>New post!</button></a>
    <a href="/profile"> <button>Profile</button></a>
    <a href="/users"> <button>Users</button></a>
    <form id="tag_search" method="get" action="/">
      <input type="search" name="tag" placeholder="Search for a tag...">
      <input type="submit" value="Search">
    </form>
  </nav>

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
