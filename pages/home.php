<?php
// query the db
$result = exec_sql_query(
  $db,
  "SELECT * FROM posts;"
);


// get records from query
$records = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="../public/styles/site.css">
  <title>Cornnect - Home</title>
</head>

<body>
  <?php include 'includes/header.php'; ?>
  <main>

    <?php
    // write a table row for each record
    foreach ($records as $record) { ?>
      <div class="card">
        <div class="head">
          <ul><?php echo htmlspecialchars($record['netid']); ?></ul> |
          <ul><?php echo htmlspecialchars($record['date']); ?></ul> |
          <ul><?php echo htmlspecialchars($record['location']); ?></ul> |
        </div>
        <div class="photo">
          <img src="public/uploads/placeholder.jpg" alt="">
        </div>
        <div class="desc">
          <ul><?php echo htmlspecialchars($record["desc"]); ?></ul>
        </div>
        <div class="more">
          <a href="/details?id=<?php echo htmlspecialchars($record['id']); ?>">More</a>
        </div>
      </div>
    <?php } ?>


  </main>
</body>

</html>
