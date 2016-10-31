<?php
        mysql_connect("104.197.56.237", "root", "lovenan92");
        mysql_select_db("test_database");
        mysql_query("UPDATE statistics SET value=value+1 WHERE name='hits'");
        $result = mysql_query("SELECT * FROM statistics WHERE name='hits'");
        while($row = mysql_fetch_array($result)) {
                echo "hits: ".$row['value'];
        }
?>
