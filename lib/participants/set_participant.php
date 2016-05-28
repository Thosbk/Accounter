<?php
include_once(__DIR__.'/../get_db.php');
include_once(LIBPATH.'/participants/get_participant_by_name.php');


function set_participant($account_id_arg, $name_of_participant_arg, $nb_of_people_arg, $email_arg)
{
	$db = get_db();

	$account_id = (int)$account_id_arg;
	$name_of_participant = htmlspecialchars($name_of_participant_arg);
	$nb_of_people = (int)$nb_of_people_arg;
	$email = htmlspecialchars($email_arg);
	$email = (empty($email))?null:$email;
	
	$does_this_guy_exists = get_participant_by_name($account_id, $name_of_participant);
	if(!empty($does_this_guy_exists))
	{
?>
<script type="text/javascript">
  alert('participant with the same name already reccorded!');
</script>
<?php
		return false;
	}
	
	//Hashid
	do {
		$hashid = bin2hex(openssl_random_pseudo_bytes(8));
	}
	while(!$hashid);
	
	try
	{
		$myquery = 'INSERT INTO participants(id, account_id, hashid, name, nb_of_people, email) 
		VALUES(NULL, :account_id, :hashid, :name_of_participant, :nb_of_people, :email)';
		$prepare_query = $db->prepare($myquery);
		$prepare_query->bindValue(':account_id', $account_id, PDO::PARAM_INT);
		$prepare_query->bindValue(':hashid', $hashid, PDO::PARAM_STR);
		$prepare_query->bindValue(':name_of_participant', $name_of_participant, PDO::PARAM_STR);
		$prepare_query->bindValue(':nb_of_people', $nb_of_people, PDO::PARAM_INT);
		$prepare_query->bindValue(':email', $email, (is_null($email))?(PDO::PARAM_NULL):(PDO::PARAM_STR));
		$isgood = $prepare_query->execute();
		$prepare_query->closeCursor();
	}
	catch (Exception $e)
	{
		echo 'Fail to connect: ' . $e->getMessage();
	}
	return $isgood;
}