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
}

?>
    <form action="admin.php" method="POST">
      Title:<input type="text" size="40" name="title"> Author:<input type="text" size="40" name="author"><BR>
      Body:<BR><textarea name="body" rows="10" cols="80"></textarea><BR>
      <input type="submit" value="Submit"><input type="hidden" name="newpost" value="1">
    </form>
  </body>
</html>
