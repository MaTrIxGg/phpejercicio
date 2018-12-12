<?php
header('Content-Type: application/json');
$pdo=new PDO('mysql:host=localhost;port=3306;dbname=tiendan', 'root');
$statement=$pdo->prepare("SELECT DISTINCT(genero), COUNT(*) as cantidad FROM `estudiante` where 1 group by genero");
$statement->execute();
$results=$statement->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results);
echo $json;
?>
