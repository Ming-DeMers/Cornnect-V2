<?php

$tags = exec_sql_query(
  $db,
  "SELECT * FROM tags"
)->fetchAll();
?>
<aside>
  <div class="sort">
    Sort by:
    <?php $current_url = strstr($_SERVER['REQUEST_URI'], 'order=old', true);
    if ($current_url == '') {
      $current_url = $_SERVER['REQUEST_URI'];
    }
    if (str_contains($current_url, '?')) {
      $operator = '&';
    } ?>
    <p><a href="<?php echo $current_url ?>">New First</a></p>
    <p><a href="<?php echo $current_url ?><?php echo $operator ?>order=old">Old First</a></p>
    <!-- <p>Clause: <?php echo $order_clause ?></p>
    <p>URL: <?php echo $current_url ?></p>
    <p>Op: <?php echo $operator ?></p> -->
  </div>

  <div class="filter">
    Tags:
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
