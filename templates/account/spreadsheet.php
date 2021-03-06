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
Template to display all the spreadsheets
 */
 ?>
 
<!-- spreadsheetS -->
<!-- Loop on the spreadsheets -->
<?php if (is_array($my_spreadsheets) && sizeof($my_spreadsheets) > 0 )
{
$cpt_spreadsheet = -1;
foreach($my_spreadsheets as $spreadsheet)
{
	$cpt_spreadsheet ++;
	$this_type = $spreadsheet['type_of_sheet'];
	//Overlay setting
if($admin_mode 
&& $edit_mode == 'spreadsheet'
&& $edit_hashid === $spreadsheet['hashid'])
{
	$overlay=true;
	$ovl_highlight = 'highlight';
	$ovl_cursorpointer = '';
}
else{
	$overlay = false;
	$ovl_highlight = '';
	$ovl_cursorpointer = 'cursorpointer';
}
?>

<div class="row spreadsheet <?php echo 'spreadsheet-'.$cpt_spreadsheet?> <?php echo $ovl_highlight?>" 
	id="<?php echo 'spreadsheet-'.$cpt_spreadsheet?>">
	<div class="col-xs-12">
		<div class="panel panel-primary">
			<div class="panel-heading <?php echo $ovl_cursorpointer?>"
				<?php if($overlay==false){echo 'data-toggle="collapse" data-target="#panel-body_spreadsheet'.$cpt_spreadsheet.'"';}?>
				style="background-color:<?php echo '#'.$spreadsheet['color']?>">
				<div class="row">
	<?php 
//Edit the spreadsheet (name, description, ...)
		if($admin_mode 
				&& $edit_mode === 'spreadsheet' 
				&& $edit_hashid === $spreadsheet['hashid'])
				{
?>
					<div class="col-xs-12" id="<?php echo 'edit_tag_'.$edit_hashid?>">
						<form method="post" id="<?php echo "form_update_spreadsheet_".$cpt_spreadsheet?>"
							action="<?php echo ACTIONPATH.'/spreadsheets/update_spreadsheet.php'?>">
							<input type="hidden" name="p_hashid_account" value="<?php echo $my_account['hashid_admin']?>">
							<input type="hidden" name="p_hashid_spreadsheet" value="<?php echo $spreadsheet['hashid']?>">
							<input type="hidden" name="p_anchor" value="<?php echo '#spreadsheet-'.$cpt_spreadsheet?>">
							<h2>
								<label for="form_edit_spreadsheet_name">Title:</label>
								<input type="text" name="p_title_of_spreadsheet" id="form_edit_spreadsheet_name"
								class="form-control"	value="<?php echo htmlspecialchars($spreadsheet['title'])?>" required 
								title="Title">
							</h2>
							<p><strong>
							<?php
								if( $this_type == "budget")
								{
									?>Budget spreadsheet<?php
								}
								else if($this_type == "receipt")
								{
									?>Purchase receipt<?php
								}
								?>
							</strong></p>
						</form>
					</div>
<?php } 
		else{
?>
					<div class="col-md-9 col-lg-8">
						<h2 class="spreadsheet_title">
							<?php echo ($cpt_spreadsheet+1).'. '.htmlspecialchars($spreadsheet['title']) ?>
						</h2>
						<p><strong>
						<?php
							if( $this_type == "budget")
							{
								?>Budget spreadsheet<?php
							}
							else if($this_type == "receipt")
							{
								?>Purchase receipt<?php
							}
							?>
						</strong></p>
					</div>
					<div class="col-md-3 col-lg-4">
		<?php
					if($admin_mode && $edit_mode === false)
					{
						$link_tmp = $link_to_account_admin.'/edit/spreadsheet/'.$spreadsheet['hashid'].'#edit_tag_'.$spreadsheet['hashid'];
						if($spreadsheet['type_of_sheet'] == 'budget')
						{
							include(__DIR__.'/button_budget.php');
						}
						elseif($spreadsheet['type_of_sheet'] == 'receipt')
						{
							include(__DIR__.'/button_receipt.php');			
						}
					}
					?>
						<div class="button_spreadsheet_title">
							<button type="submit" value="" class="btn btn-default" title="Collapse/Expand"
							data-toggle="collapse" data-target="#<?php echo 'panel-body_spreadsheet'.$cpt_spreadsheet?>">
								<span class="glyphicon glyphicon-minus"></span>
							</button>							
						</div>
						<?php if($spreadsheet['rank'] > 0){?>
						<div class="button_spreadsheet_title">
							<form action="<?php echo ACTIONPATH.'/spreadsheets/move_spreadsheet.php'?>"
								method="post">
								<input type="hidden" name="p_hashid_account" value="<?php echo $my_account['hashid_admin']?>">
								<input type="hidden" name="p_hashid_spreadsheet" value="<?php echo $spreadsheet['hashid']?>">
								<input type="hidden" name="p_move" value="up">
								<button type="submit" value="" name="submit_move" class="btn btn-default" 
										title="Move up" onclick="event.stopPropagation();">
											<span class="glyphicon glyphicon-arrow-up"></span>
								</button>
							</form>
						</div>
						<?php }?>
						<?php if($spreadsheet['rank'] < (int)$n_spreadsheets-1){?>
						<div class="button_spreadsheet_title">
							<form action="<?php echo ACTIONPATH.'/spreadsheets/move_spreadsheet.php'?>"
								method="post">
								<input type="hidden" name="p_hashid_account" value="<?php echo $my_account['hashid_admin']?>">
								<input type="hidden" name="p_hashid_spreadsheet" value="<?php echo $spreadsheet['hashid']?>">
								<input type="hidden" name="p_move" value="down">
								<button type="submit" value="" name="submit_move" class="btn btn-default" 
										title="Move down" onclick="event.stopPropagation();">
											<span class="glyphicon glyphicon-arrow-down"></span>
								</button>
							</form>
						</div>
						<?php } ?>
					</div>
	<?php
				}
?>
				</div>
			</div>
<?php //PANEL BODY OF spreadsheet
$cred = hexdec(substr($spreadsheet['color'], 0, 2));
$cgreen = hexdec(substr($spreadsheet['color'], 2, 2));
$cblue = hexdec(substr($spreadsheet['color'], 4, 2));
?>
			<div id="<?php echo 'panel-body_spreadsheet'.$cpt_spreadsheet?>" class="panel-collapse collapse in">
				<div  class="panel-body"
					style="background-color: rgba(<?php echo $cred.','.$cgreen.','.$cblue?>, 0.5);">
										
<?php 
//Edit the spreadsheet (name, description, ...)
if($admin_mode 
				&& $edit_mode === 'spreadsheet' 
				&& $edit_hashid === $spreadsheet['hashid'])
				{
?>
					<div class="form-group">
						<label for="form_edit_spreadsheet_description">Description: </label>
						<textarea name="p_description" class="form-control"
						 form="<?php echo "form_update_spreadsheet_".$cpt_spreadsheet?>"><?php if(!empty($spreadsheet['description'])){echo htmlspecialchars($spreadsheet['description']);}?></textarea>
					</div>
					<button type="submit" name="submit_update_spreadsheet" value="Submit"
						form="<?php echo "form_update_spreadsheet_".$cpt_spreadsheet?>"
						class="btn btn-primary" title="Submit changes">
							Submit changes
					</button> 
					<button type="submit" name="submit_cancel" value="<?php echo '#spreadsheet-'.$cpt_spreadsheet?>" 
						form="form_cancel" class="btn btn-primary" title="Cancel">
						Cancel
					</button> 
<?php	
	}
	else{
		?>
			<h3>Description</h3>
			<p>
				<?php
				if(isset($spreadsheet['description'])
					&& !is_null($spreadsheet['description'])
					&& !empty($spreadsheet['description']))
					{
						echo htmlspecialchars($spreadsheet['description']);
					}
				else{
					?>
					No description.
					<?php
				}
				?>
				</p>
<?php 
			}
	?>
	
	<?php
	if( $this_type == "budget")
	{
		include(__DIR__.'/budget.php');
	}
	else if($this_type == "receipt")
	{
		include(__DIR__.'/receipt.php');
	}
?>
				</div> 
			</div> 
		</div> 
	</div> 
</div> 

<?php
}//foreach spreadsheet
}//if spreadsheets exist
?>
