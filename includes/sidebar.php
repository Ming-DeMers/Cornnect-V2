<?php

$tags = exec_sql_query(
  $db,
  "SELECT * FROM tags"
)->fetchAll();
?>
<aside>
  <div class="nav-search">
    <search-box>
      <form id="tag_search" method="get" action="/">
        <label for="search-box">
          <h3>Search by a tag!</h3>
        </label>
        <input type="search" id="search-box" name="tag" placeholder="Enter a tag...">
        <button type="submit" id="search-button">Search</button>
      </form>
    </search-box>

  </div>
  <div class="sort">
    <h3>Sort by:</h3>
    <?php $current_url = strstr($_SERVER['REQUEST_URI'], 'order=old', true);
    if ($current_url == '') {
      $current_url = $_SERVER['REQUEST_URI'];
    }
    if (str_contains($current_url, '?')) {
      $operator = '&';
    } ?>
    <p><a href="<?php echo $current_url ?>">Newest</a></p>
    <p><a href="<?php echo $current_url ?><?php echo $operator ?>order=old">Oldest</a></p>
    <!-- <p>Clause: <?php echo $order_clause ?></p>
    <p>URL: <?php echo $current_url ?></p>
    <p>Op: <?php echo $operator ?></p> -->
  </div>

  <div class="filter">
    <h3>Show posts with:</h3>
    <ul>
      <?php foreach ($tags as $tag) {
        $tag_url = '/home?tag=' . $tag['tag'];
      ?>
        <li>
          <a href="<?php echo htmlspecialchars($tag_url); ?>"><?php echo htmlspecialchars($tag['tag']); ?></a>
        </li>
      <?php } ?>
    </ul>
  </div>
</aside>
