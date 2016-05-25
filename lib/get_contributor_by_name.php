<?php
include_once('/lib/get_db.php');

function get_contributor_by_name($account_id_arg, $contrib_name_arg)
{
	$db = get_db();

	$account_id = (int)$account_id_arg;
	$contrib_name = htmlspecialchars($contrib_name_arg);
	
	try
	{
		$myquery = 'SELECT * FROM contributors WHERE account_id=:account_id AND upper(name)=upper(:contrib_name)';
		$prepare_query = $db->prepare($myquery);
		$prepare_query->bindValue(':account_id', $account_id, PDO::PARAM_INT);
		$prepare_query->bindValue(':contrib_name', $contrib_name, PDO::PARAM_STR); 
		$prepare_query->execute();
	}
	catch (Exception $e)
	{
		echo 'Fail to connect: ' . $e->getMessage();
	}
	$reply = $prepare_query->fetchAll();
	$prepare_query->closeCursor();
	if(!empty($reply))
	{
		return $reply;
	}
	else
	{
		return array();
	}
}