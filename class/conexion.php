<?php
$dbname='Ailee';
$host = "localhost";
$user = "carolina";
$pass = "Cqcq9tzHcxKj5zugYc8WwXfk";
try {
        $gbd = new PDO("pgsql:dbname=$dbname;host=$host",$user,$pass);
} catch(PDOException $e){
        print "<p>Error: Data Error.</p>\n";
        print "<p>Error: " . $e->getMessage() . "</p>\n";
}

//Colocar la siguiente línea en donde se vaya a utilizar
//include './pages/class/conexion.php';
//ejemplo de como utilizar
// $sqlPaises = 'select * from blocked_countries where bloqueo = false';
// $stmtex = $gbd->prepare($sqlPaises);
// $stmtex->execute();
// $datos = $stmtex->fetchAll(PDO::FETCH_ASSOC);

?>