<?php
include('config.php');

?>
<html>
  <head>
    <title>Blog</title>
    <style>
.blogpost {
  border: 1px black solid;
  margin: 5px;
}
.title {
  border: 1px black solid;
}
.author {
  border: 1px black solid;
}
.tstamp {
  border: 1px black solid;
}
.body {
  border: 1px black solid;
}
    </style>
  </head>
  <body>

<?php
// grab posts from DB here
  if ( !( $db = mysql_connect($dbserver, $dbuser, $dbpword) ) ) die("Error connecting to the database!");

  $p = (isset($_GET['p'])) ? $_GET['p'] : 0;
  $perpage = 5;
  $start = $p*$perpage;
  
  if ( !($r = mysql_db_query("blog", "SELECT * FROM posts ORDER BY tstamp DESC LIMIT $start,$perpage", $db)) ) die("Error getting blog posts!");
  while ($post = mysql_fetch_assoc($r) ) {
?>
    <div class="blogpost">
      <span class="title"><?php echo $post['title'];?></span>
      <span class="author"><?php echo $post['author'];?></span>
      <span class="tstamp"><?php echo $post['tstamp'];?></span><BR>
      <span class="body"><?php echo $post['body'];?></span>
    </div>
<?php
  }
  if ($start != 0 ) {
    echo "<a href='?p=".($p-1)."'>prev</a>";
  }
  echo "<a href='?p=".($p+1)."'>next</a>";
?>
  </body>
</html>
