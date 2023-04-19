<?php
foreach ($posts as $post) { ?>
  <div class="card">
    <div class="head">
      <a class="user-link" href="/user?netid=<?php echo htmlspecialchars($post['netid']); ?>"><?php echo htmlspecialchars($post['netid']); ?></a> |
      <?php echo htmlspecialchars($post['date']); ?> |
      <?php echo htmlspecialchars($post['location']); ?> |
    </div>
    <div class="photo">
      <?php $file_url = '/public/uploads/posts/' . $post['id'] . '.' . $post['file_ext']; ?>
      <a href="/post?id=<?php echo htmlspecialchars($post['id']); ?>">
        <img src="<?php echo htmlspecialchars($file_url); ?>" alt="<?php echo htmlspecialchars($record['file_name']); ?>">
      </a>
    </div>
    <div class="desc">
      <ul><?php echo htmlspecialchars($post["desc"]); ?></ul>
    </div>
    <div class="more">
      <a href="/post?id=<?php echo htmlspecialchars($post['id']); ?>">More details...</a>
    </div>
  </div>
<?php } ?>
