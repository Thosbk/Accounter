<!DOCTYPE html>

<html>

<body>

<?php
$sha_url = 0;
empty($_GET['sha']) ? $sha_url = 0 : $sha_url = (int)$_GET['sha'];
echo '<p>SHA FROM URL= '.$sha_url.'</p>'
?>

<?php 
// on se connecte � MySQL 
try
{
$db = new PDO('mysql:host=localhost;dbname=dividethebill;charset=utf8', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

echo '<h1>SHA = GOOD ? </h1>';


try
{
	$reponse = $db->query('SELECT * FROM test_sha WHERE sha='.$sha_url);
}
catch (Exception $e)
{
    echo '�chec lors de la connexion : ' . $e->getMessage();
}
// on fait une boucle qui va faire un tour pour chaque enregistrement 
if($data = $reponse->fetch()) 
    { 
    // on affiche les informations de l'enregistrement en cours 
    echo '<p>Welcome brother</p>';
    } 
	else
	{
    echo '<p>Go back home dude</p>';
	}	
$reponse->closeCursor();

echo '<h1>Table</h1>';
$reponse = $db->query('SELECT * FROM test_sha');
// on fait une boucle qui va faire un tour pour chaque enregistrement 
echo '<table style="width:100%" border="1" >';
while($data = $reponse->fetch()) 
    { 
	echo ' <tr>';
    echo '<td>'.$data['id'].'</td>';
    echo '<td>'.$data['sha'].'</td> ';
	echo '  </tr>';
	}
echo'</table>';

?> 

</body>
</html>