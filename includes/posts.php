<?php
function format_date($date_string)
{
  if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $date_string)) {
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $date_string);
  } else {
    $date = DateTime::createFromFormat('Ymd', $date_string);
  }
  return $date->format('M d Y');
}
foreach ($posts as $post) { ?>
  <div class="card">
    <div class="head">
      <a class="user-link" href="/user?netid=<?php echo htmlspecialchars($post['netid']); ?>"><?php echo htmlspecialchars($post['netid']); ?></a> |
      <?php echo format_date(htmlspecialchars($post['date'])); ?> |
      <?php echo htmlspecialchars($post['location']); ?> |
    </div>
    <div class="photo">
      <?php $file_url = '/public/uploads/posts/' . $post['id'] . '.' . $post['file_ext']; ?>
      <a href="/post?id=<?php echo htmlspecialchars($post['id']); ?>">
        <img src="<?php echo htmlspecialchars($file_url); ?>" alt="post<?php echo htmlspecialchars($post['id']); ?>">
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
