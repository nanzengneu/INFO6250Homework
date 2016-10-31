<?php
$db_host = "localhost";
$db_username = "root";
$db_pass = "lovenan92";
$db_name = "test_database";
@mysql_connect("$db_host","$db_username", "$db_pass") or die ("could not connect to MySQL");
@mysql_select_db("$db_name") or die ("no database");
@mysql_query("UPDATE viewcounter SET `views` = `views` +1 WHERE id='1'");
?>
