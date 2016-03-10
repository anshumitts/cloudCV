<?php
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	$QureyString = $_POST["Question"];
	$target_file = $_POST["location"];
    $command = '/home/anshul/miniconda2/bin/python python_files/own_image.py --img \''.$target_file.'\' --ques \''.$QureyString.'\'';
    $Output = exec($command);
    echo $Output.'-^-'.$target_file; 
}
?>