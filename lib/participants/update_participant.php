<?php
include_once(__DIR__.'/../get_db.php');
include_once(LIBPATH.'/participants/get_participant_by_id.php');
include_once(LIBPATH.'/participants/get_participant_by_name.php');

function update_participant($account_id_arg, $participant_id_arg, $name_of_contrib_arg, $nb_of_people_arg, $email_arg)
{
	$db = get_db();

	$account_id = (int)$account_id_arg;
	$participant_id = (int)$participant_id_arg;
	$new_name_of_contrib = $name_of_contrib_arg;
	$new_nb_of_people = (int)$nb_of_people_arg;
	$new_email = $email_arg;

	if(!is_null($new_email))
	{
		$new_email = filter_var($new_email, FILTER_SANITIZE_EMAIL);
		$new_email = filter_var($new_email, FILTER_VALIDATE_EMAIL);
		if($new_email == false)
		{return false;}
	}
	
	$contrib = get_participant_by_id($account_id, $participant_id);
	if(empty($contrib))
	{		return false;	}
	
	if($new_nb_of_people < 0)
	{return false;}
	
	//Nothing to change?
	if($new_name_of_contrib === $contrib['name'] 
	&& $new_nb_of_people == $contrib['nb_of_people']
	&& $new_email == $contrib['email'])
	{
		return true;
	}
	
	//If the name changes, we have to check if it's free
	if($new_name_of_contrib != $contrib['name'])
	{
		$isthenamefree = get_participant_by_name($account_id, $new_name_of_contrib);
		if(!empty($isthenamefree))
		{			return false;		}
	}
	
	try
	{
		$myquery = 'UPDATE  '.TABLE_PARTICIPANTS.' 
		 SET name=:new_name_of_contrib, nb_of_people=:new_nb_of_people, email=:new_email
		WHERE id=:participant_id';
		$prepare_query = $db->prepare($myquery);
		$prepare_query->bindValue(':new_name_of_contrib', $new_name_of_contrib, PDO::PARAM_STR);
		$prepare_query->bindValue(':new_nb_of_people', $new_nb_of_people, PDO::PARAM_INT);
		$prepare_query->bindValue(':participant_id', $participant_id, PDO::PARAM_INT);
		$prepare_query->bindValue(':new_email', $new_email, (is_null($new_email))?(PDO::PARAM_NULL):(PDO::PARAM_STR));
		$isgood = $prepare_query->execute();
		$prepare_query->closeCursor();
	}
	catch (Exception $e)
	{
	//	echo 'Fail to connect: ' . $e->getMessage();
	}
	return $isgood;
}
