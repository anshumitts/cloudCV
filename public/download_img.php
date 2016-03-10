<?php
session_start();
$_session["jobID"] = 1;
if((isset($_session["jobID"])))
{
	$train_folder = 'uploads/'.$_session["jobID"].'/train';
	$test_folder = 'uploads/'.$_session["jobID"].'/test';
	$util_folder = 'uploads/'.$_session["jobID"].'/util';

	if(isset($_POST["submit"])) 
	{
	    $query = $_POST["Query"];
		ob_start();
		$command = '/usr/bin/python2.7 download_images.py '.$query.' \''.$train_folder.'\'';
		passthru($command);
		$output = ob_get_clean(); 
		// unlink($target_file);
		echo $output.'-^-'.$query;
	}
	else {
	echo "FuckOFFinside";
	# code...
}

}
else {
	echo "FuckOFF".$_session["jobID"];
	# code...
}
?>