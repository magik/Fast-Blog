<?php
include('config.php');

if ( !( $db = mysql_connect($dbserver, $dbuser, $dbpword) ) ) die("Error connecting to the database!");

session_start();

$needlogin = !(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true);

if ( ( $needlogin === true ) && ( isset($_POST['login']) ) && ( $_POST['login'] == "1" ) ) {
  // CREATE TABLE login (id int PRIMARY KEY AUTO_INCREMENT, user varchar(256), pword varchar(32));
  // INSERT into login (id, user, pword) VALUES(1, "root", MD5("salt123password"));
  if ( !( $r = mysql_db_query("blog", "SELECT * FROM login WHERE id=1;", $db) ) ) die("Error talking to db");
  $creds = mysql_fetch_assoc($r);

  if ( $creds['user'] == $_POST['user'] ) {
    if ( $creds['pword'] == md5($salt.$_POST['pword']) ) { 
      $_SESSION['loggedin'] = true;
      $needlogin = false;
    }
  }
}


if ( $needlogin === false ) {
  if ( ( isset($_POST['newpost']) ) && ( $_POST['newpost'] == "1" ) ) {
    mysql_db_query("blog", "CREATE TABLE IF NOT EXISTS posts (id int(8) PRIMARY KEY AUTO_INCREMENT, title VARCHAR(256), author VARCHAR(256), body VARCHAR(20000), tstamp timestamp DEFAULT CURRENT_TIMESTAMP);", $db);
  
    if (!mysql_db_query("blog", "INSERT INTO posts (title, author, body) VALUES('$_POST[title]','$_POST[author]','$_POST[body]');")) die("Could not insert into db...");

    $status = "New post added...";

  } else if ( ( isset($_POST['changepassword'] ) ) && ( $_POST['changepassword'] == "1" ) ) {
    if ( isset($_POST['password1'],$_POST['password2']) && $_POST['password1'] == $_POST['password2'] ) {
      $hash = md5( $salt. $_POST['password1'] );
      if (!mysql_db_query("blog", "UPDATE TABLE posts SET password=$hash WHERE id=1")) die("Error changing password");
      $status = "Password changed";
    }
  }
}


?>

<html>
  <head><title>Blog Admin Page</title></head>
  <body>
<?php
echo $status."<BR>";

if ($needlogin === true ) {
?>
    Please login:
    <form action="admin.php" method="POST">
      Username:<input type="text" size="40" name="user"> Password:<input type="password" size="40" name="pword"><BR>
      <input type="submit" value="Login"><input type="hidden" name="login" value="1">
    </form>
    <BR><BR>
<?php

} else {

?>
    <form action="admin.php" method="POST">
      Title:<input type="text" size="40" name="title"> Author:<input type="text" size="40" name="author"><BR>
      Body:<BR><textarea name="body" rows="10" cols="80"></textarea><BR>
      <input type="submit" value="Submit"><input type="hidden" name="newpost" value="1">
    </form>
    Change password:
    <form action="admin.php" method="POST">
      New password:<input type="password" size="40" name="password1"><BR>
      Confirm password:<input type="password" size="40" name="password2"><BR>
      <input type="submit" value="Change password"><input type="hidden" name="changepassword" value="1">
    </form>
<?php

}

?>

  </body>
</html>
