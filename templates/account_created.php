<!DOCTYPE html>

<html>
<head>
</head>
<body>

<?php 
if($isdone)
{
?>
	<h1> Accoung created</h1>
	<ul>
	<li>Contributor link  :<a href="<?php echo $link_contrib?>"><?php echo $link_contrib?> </a></li>
	<li>Administrator link:<a href="<?php echo $link_admin?>"><?php echo $link_admin?> </a> </li>
	</ul>
<?php
}
?>

</body>
</html>