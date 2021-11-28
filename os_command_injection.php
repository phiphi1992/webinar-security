<?php
if(!empty($_POST)){
	$target = $_POST[ 'hostname' ] ?? 'google.com';
	
	$output=null;
	$retval=null;
	$command = "ping -c 2 $target";
	// die($command);
	exec( $command, $output, $retval);
}
?>

<form method="POST">
	<div style="display: block;margin: auto;width: 565px;margin-top: 100px;font-weight: bold;font-size: 30px;">
		<label>Ping host: </label>
		<input type="text" name="hostname" placeholder="google.com" style="font-size: 25px;padding: 5px 5px 8px;" value="<?=$target?? ''?>" />
		<button type="submit" style="font-size: 20px;padding: 10px;margin-top: 0px;">Submit</button>
	</div>
</form>

<?php
	echo '<pre style="width: 565px;margin: auto;">';
	print_r($output);
	echo '</pre>';
?>