<?php
/**
 * This software is governed by the CeCILL-B license. If a copy of this license
 * is not distributed with this file, you can obtain one at
 * http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 *
 * Author of Accounter: Bertrand THIERRY (bertrand.thierry1@gmail.com)
 *
 */
 
/*
Return the member of name $member_name_arg associated to the account of id $account_id_arg.
A member is a row in the members SQL table.
*/
include_once(__DIR__.'/../get_db.php');

function get_member_by_name($account_id_arg, $member_name_arg)
{
	$db = get_db();

	$account_id = (int)$account_id_arg;
	$member_name = $member_name_arg;
	
	try
	{
		$myquery = 'SELECT * FROM  '.TABLE_MEMBERS.' 
		 WHERE account_id=:account_id AND upper(name)=upper(:member_name)';
		$prepare_query = $db->prepare($myquery);
		$prepare_query->bindValue(':account_id', $account_id, PDO::PARAM_INT);
		$prepare_query->bindValue(':member_name', $member_name, PDO::PARAM_STR); 
		$prepare_query->execute();
	}
	catch (Exception $e)
	{
	//	echo 'Fail to connect: ' . $e->getMessage();
	}
	$reply = $prepare_query->fetchAll();
	$prepare_query->closeCursor();
	if(!empty($reply))
	{
		return $reply[0];
	}
	else
	{
		return array();
	}
}
