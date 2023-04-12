<?php
foreach ($posts as $post) { ?>
  <div class="card">
    <div class="head">
      <?php echo htmlspecialchars($post['netid']); ?> |
      <?php echo htmlspecialchars($post['date']); ?> |
      <?php echo htmlspecialchars($post['location']); ?> |
    </div>
    <div class="photo"> <a href="/post?id=<?php echo htmlspecialchars($post['id']); ?>"> <img src="public/uploads/placeholder.jpg" alt=""></a>


    </div>
    <div class="desc">
      <ul><?php echo htmlspecialchars($post["desc"]); ?></ul>
    </div>
    <div class="more">
      <a href="/post?id=<?php echo htmlspecialchars($post['id']); ?>">More details...</a>
    </div>
  </div>
<?php } ?>
