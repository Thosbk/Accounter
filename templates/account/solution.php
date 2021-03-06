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
Template to display the solutions
 */
?>

<!-- SOLUTION -->
<div id="solutions" class="row">
	<div class="col-xs-12 col-lg-10 col-lg-offset-1">
		<div class="panel panel-primary">
			<div class="panel-heading cursor_pointer" 
				data-toggle="collapse" data-target="#panel-body_solution">
				<h2>Solution</h2>
				<button class="btn btn-default floatright" title="Collapse/Expand"
					data-toggle="collapse" data-target="#panel-body_solution">
					<span class="glyphicon glyphicon-minus"></span>
				</button>
			</div>
			<div id="panel-body_solution" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="row list_solution ">
			<?php if($n_transfer_opt == 0)
			{?>
						<p>No transfer needed: everything is fine!</p>
<?php }
	else{?>
					<?php
					//This counter is here to show transfer regrouped by payer
					$cpt_sol = 0;
					for ($icol = 0; $icol < $n_sol_col; $icol ++)
					{
					?>
						<div class="col-md-6 
							<?php if($n_sol_col == 1){echo 'col-md-offset-3';}?>
							<?php if($icol==0 && $n_sol_col > 1){echo 'solidcolumn';}?>
							">
							<div class="row list_solution  <?php if($icol==1){echo 'visible-md visible-lg ';}?>">
								<div class="col-xs-offset-1 col-xs-5 col-md-offset-2 col-md-4 text-center">
									...must pay...
								</div>
								<div class="col-xs-5 col-md-4 text-center">
									...to...
								</div>
							</div>
<?php
						for ($i = $icol; $i < $n_transfer_opt; $i += $n_sol_col) 
						{
							$transfer = $tranfers[$cpt_sol];
							$cpt_sol++;
	?>
							<div class="row list_solution">
								<div class="col-xs-4 col-md-4 col-lg-4">
									<div class="display_member padding_member fullwidth" style="background-color:<?php echo '#'.$transfer['payer_color']?>"><?php echo htmlspecialchars($transfer['payer_name'])?></div>
								</div>
								<div class="col-xs-4 col-md-4 col-lg-4">
									<div class="padding_member fullwidth">
										<?php echo $transfer['amount']?>&euro;
									</div>
								</div>
								<div class="col-xs-4 col-md-4 col-lg-4">
									<div class="display_member padding_member fullwidth" style="background-color:<?php echo '#'.$transfer['receiver_color']?>"><?php echo htmlspecialchars($transfer['receiver_name'])?></div>
								</div>
							</div>
<?php
						}
?>
						</div>
<?php
					}
?>
					</div>
<?php
				}
?>							
				</div>
			</div>
		</div>
	</div>
</div>
