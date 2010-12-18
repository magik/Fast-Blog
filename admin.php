<?php
include('config.php');

if ( !( $db = mysql_connect($dbserver, $dbuser, $dbpword) ) ) {
  die("Error connecting to the database!");
}

?>

<html>
  <head><title>Blog Admin Page</title></head>
  <body>
<?php

if ( isset($_POST['newpost']) && $_POST['newpost'] == "1" ) {
  echo "posted new message...\n";
  mysql_db_query("blog", "CREATE TABLE IF NOT EXISTS posts (id int(8) PRIMARY KEY AUTO_INCREMENT, title VARCHAR(256), author VARCHAR(256), body VARCHAR(20000), tstamp timestamp DEFAULT CURRENT_TIMESTAMP);", $db);

  if (!mysql_db_query("blog", "INSERT INTO posts (title, author, body) VALUES('$_POST[title]','$_POST[author]','$_POST[body]');")) die("Could not insert into db...");
}

?>
    <form action="admin.php" method="POST">
      Title:<input type="text" size="40" name="title"> Author:<input type="text" size="40" name="author"><BR>
      Body:<BR><textarea name="body" rows="10" cols="80"></textarea><BR>
      <input type="submit" value="Submit"><input type="hidden" name="newpost" value="1">
    </form>
  </body>
</html>
