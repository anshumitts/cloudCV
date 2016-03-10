<?php
$target_dir = "uploads/";
$name = str_replace(' ', '', basename($_FILES["fileToUpload"]["name"]));
$target_file = $target_dir.$name;
$QureyString = $_POST["Question"];
$current_work = "current_work/".$name;
$uploadOk = 1;
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} 
else 
{    
    try
    {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
        {
            $command = '/home/anshul/miniconda2/bin/python python_files/own_image.py --img \''.$target_file.'\' --ques \''.$QureyString.'\'';
        	$Output = exec($command);
            echo $Output.'-^-'.$target_file;
        }
        else
        {
        	echo "File not uploaded";
        }
    } 
    catch (customException $e) 
    {
	  	//display custom message
		echo $e->errorMessage();
	}
}
?>