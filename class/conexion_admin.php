<?php
$dbname='administrador_ailee';
$host = "localhost";
$user = "carolina";
$pass = "Cqcq9tzHcxKj5zugYc8WwXfk";
try {
        $gbd = new PDO("pgsql:dbname=$dbname;host=$host",$user,$pass);
} catch(PDOException $e){
        print "<p>Error: Data Error.</p>\n";
        print "<p>Error: " . $e->getMessage() . "</p>\n";
}

?>