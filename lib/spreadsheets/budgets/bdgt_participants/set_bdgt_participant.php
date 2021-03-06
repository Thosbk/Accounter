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
Lib: Add a row in the bdgt_participants SQL table
 */
include_once(__DIR__.'/../../../get_db.php');

include_once(LIBPATH.'/members/get_member_by_id.php');
include_once(LIBPATH.'/spreadsheets/get_spreadsheet_by_id.php');
include_once(LIBPATH.'/spreadsheets/budgets/bdgt_participants/get_bdgt_participant_by_member_id.php');

include_once(LIBPATH.'/hashid/validate_hashid.php');


function set_bdgt_participant($account_id_arg, $hashid_arg, $spreadsheet_id_arg, $member_id_arg, $percent_of_benefit_arg)
{
	$db = get_db();

	$account_id = (int)$account_id_arg;
	$hashid = $hashid_arg;
	$spreadsheet_id = (int)$spreadsheet_id_arg;
	$member_id = (int)$member_id_arg;
	$percent_of_benefit = (float)$percent_of_benefit_arg;
	
	//Check
	$the_bdgt = get_spreadsheet_by_id($account_id, $spreadsheet_id);
	if(empty($the_bdgt)){return false;}
	$the_member = get_member_by_id($account_id, $member_id);
	if(empty($the_member)){return false;}
	//Same account ? (double check)
	if($the_member['account_id'] != $the_bdgt['account_id'])
	{return false;}

	if(validate_hashid($hashid) === false)
	{return false;}

	//check that the entry is not already existant
	$check_member = get_bdgt_participant_by_member_id($account_id, $spreadsheet_id, $member_id);
	if(!empty($check_member))
	{return false;}
	
	$percent_of_benefit = is_null($percent_of_benefit)?100:$percent_of_benefit;
	
	if($percent_of_benefit > 100 || $percent_of_benefit < 0)
	{
		return false;
	}
	
	$isgood= false;
	try
	{
		$myquery = 'INSERT INTO '.TABLE_BDGT_PARTICIPANTS.'(id, account_id, spreadsheet_id, hashid, member_id, percent_of_benefit) 
		VALUES(NULL, :account_id, :spreadsheet_id, :hashid, :member_id, :percent_of_benefit)';
		$prepare_query = $db->prepare($myquery);
		$prepare_query->bindValue(':account_id', $account_id, PDO::PARAM_INT);
		$prepare_query->bindValue(':spreadsheet_id', $spreadsheet_id, PDO::PARAM_INT);
		$prepare_query->bindValue(':hashid', $hashid, PDO::PARAM_STR);
		$prepare_query->bindValue(':member_id', $member_id, PDO::PARAM_INT);
		$prepare_query->bindValue(':percent_of_benefit', $percent_of_benefit, PDO::PARAM_STR);
		$isgood = $prepare_query->execute();
		$prepare_query->closeCursor();
	}
	catch (Exception $e)
	{
		return false;
	//	echo 'Fail to connect: ' . $e->getMessage();
	}
	return $isgood;
}