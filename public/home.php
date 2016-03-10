<?php
$flag = 0;
error_reporting(0);
if(isset($_POST["submit"])) 
{
	$_POST["submit"]='';
	$func = $_POST["ExeString"];
	$folder = $_POST["view_image"];
	$command = 'python python_files/opencv_edit.py \''.$func.'\' \''.$folder.'\'';
    $outputs = exec($command);
    $output = split("::", $outputs);
    $functions = split("-", $func);
    array_pop($output);
    $flag = 1;
}
else
{
	$dir = "output_files";
	$jobID = "";
	$files0 = scandir($dir,1);
	array_pop($files0);
	array_pop($files0);
	foreach ($files0 as $txt)
	{
		unlink($dir.'/'.$jobID.$txt);
	}
}
?>
<html>
<head>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript">
	var source = new EventSource("terminal.php");
    var operations = 0;
    var tip = 1;
        $(document).ready(function(event) {
			source.onmessage = function(event) {
				if (event.data != ""&&event.data != "Done") {
				tip = 1;
			    document.getElementById("terminal").innerHTML += event.data +"\r";
				}
				if (event.data == "Done" && tip ) {
					tip =0;
				document.getElementById("terminal").innerHTML += "root@root:~$ ";	
				}
				};
            $('#form1').ajaxForm(function(data) {
            	var datas = String(data).split('-^-');
            	$('#Answere').attr('value', datas[0]);
                $('#view').attr('src', datas[1]);
                document.getElementById("view_image").setAttribute("value", datas[1]);
            });
            $('#form2').ajaxForm(function(data) {
                var datas = String(data).split('-^-');
                $('#Answere').attr('value', datas[0]);
                $('#view').attr('src', datas[1]);
                document.getElementById("view_image").setAttribute("value", datas[1]);
            });
        });
		function get_output(obj)
		{
			document.getElementById("pre_image").style.display = 'block';
			document.getElementById("view").setAttribute("src", $(obj).attr('data-val'));
			document.getElementById("image").setAttribute("value", $(obj).attr('data-val'));
			document.getElementById("tggle").style.display = 'block';
			document.getElementById("Image_upload").style.display = 'none';
			$('#Answere').attr('value', "");
			document.getElementById("Execute_img").innerHTML='';
			document.getElementById("view_image").setAttribute("value", $(obj).attr('data-val'));
		}
		function toggle()
		{
			document.getElementById("pre_image").style.display = 'none';
			document.getElementById("tggle").style.display = 'none';
			document.getElementById("Image_upload").style.display = 'block';
			document.getElementById("view").setAttribute("src", "default.png");
			document.getElementById("Execute_img").innerHTML='';
		}

		function bluring(str,value)
		{
			document.getElementById("operation_"+str).setAttribute("data-val", "2("+value+"(");

		}
		function canny_edge(str,v1,v2)
		{
			document.getElementById("operation_"+str).setAttribute("data-val", "3("+v1+"("+v2+"(");
		}

		function Work()
		{
			var value = $('#ExeString').attr('value');
			var selectBox = document.getElementById("selectBox");
    		var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    		if (selectedValue == "1") 
    		{
    			document.getElementById("params").innerHTML=document.getElementById("params").innerHTML + '<div class=\"col-md-12 alert-danger\" id=\"operation_'+operations+'\" data-val=\"1(\"><p class=\"input-group-addon alert-success\ ">Convert To Grey Scale</p></div>';
    			operations = operations + 1;
    		}else if (selectedValue == "2") {
				document.getElementById("params").innerHTML=document.getElementById("params").innerHTML + ' <div class=\"col-md-12 alert-danger\" id=\"operation_'+operations+'\" data-val=\"2(5(\"><label for=\"'+operations+'\" class=\"input-group-addon alert-success\">Apply Gaussian Blur</label><input type=\"number\" class=\"form-control\" min = \"1\"value=\"5\" name=\"'+operations+'\" onchange = \"bluring('+operations+',this.value);\" ></div>';
				operations = operations + 1;
    		}else if (selectedValue == "3") {
				document.getElementById("params").innerHTML=document.getElementById("params").innerHTML + ' <div class=\"col-md-12 alert-danger\" id=\"operation_'+operations+'\" data-val=\"3(10(200(\"><label for=\"'+operations+'\" class=\"input-group-addon alert-success\">Apply Canny Edge</label><input type=\"number\" class=\"form-control\" min = \"1\"value=\"10\" name=\"A_'+operations+'\" onchange = \"canny_edge('+operations+',this.value'+',B_'+operations+'.value);\" placeholder=\"lower value\" ><input type=\"number\" class=\"form-control\" min = \"1\"value=\"200\" name=B_'+operations+' onchange = \"canny_edge('+operations+',A_'+operations+'.value,this.value);\" placeholder=\"higher value\"></div>';
				operations = operations + 1;
			}else{
				console.log("none");
			}
    		// $('#ExeString').attr('value',value+ selectedValue+'-');
		}
		function Compile_str()
		{
			data="";
			for (var i = 0; i <operations; i++) {
				data = data + $("#operation_"+i).attr("data-val")+"-"; 
			}
			$('#ExeString').attr('value',data)
		}
  </script> 

  <style type="text/css">

#prev_imgs{
}
div{
	padding: 5px;
}

  #pre_image{
  	display: none;
  }
  #tggle{
  	display: none;
  }
  #Image_upload{
  	display: block;
  }
  #grey{
  	display: none;
  }
  #canny{
  	display: none;
  }
  .navbar-custom {
    color: #C7C7C7;
    width: 100%;
    background-color: #191818;
}  
</style>
</head>
<body id="container">

<div class = "row">
<div class ="imgs col-md-4"></div>
<div class="form-group imgs col-md-4">
	    <h3 class="center-block">Toy Task 1 and Toy Task 2</h3>	
</div>
<div class ="imgs col-md-4"></div>
</div>

<div class = "row">
<div class ="imgs col-md-4"></div>
<div class="form-group imgs col-md-4">
	    <h3 class="center-block">Choose from Online</h3>	
</div>
<div class ="imgs col-md-4"></div>
</div>
<div id= "Previous Images" class = "row table-bordered">
	<div class = "row ">
		<div class ="col-md-12">
			<?php
			$dir = "images";
			$files1 = scandir($dir,1);
			array_pop($files1);
			array_pop($files1);
			$divs='';
			$x=-1;
			foreach ($files1 as $uploads) 
			{
				$x+=1;	
				if ($x%6==0) 
				{
					$divs.="<div class = 'row'>";
				}
					$divs.="<div class ='imgs col-md-2' id='imgs'  data-val='images/". $uploads."' onclick='get_output(this);'><img id='prev_imgs' class ='col-md-12 center-block img-thumbnail' src='images/". $uploads."'></div>";
				if ($x%6==5)
				{
					$divs.="</div>";	
				}
			}
			echo $divs;
			?>
			<?php
			$dir = "uploads";
			$files1 = scandir($dir,1);
			array_pop($files1);
			array_pop($files1);
			$divs='';
			foreach ($files1 as $uploads) 
			{
				$x+=1;
				if ($x%6==0) 
				{
					$divs.="<div class = 'row'>";
				}
					$divs.="<div class ='imgs col-md-2' id='imgs'  data-val='uploads/". $uploads."' onclick='get_output(this);'><img id='prev_imgs' class ='col-md-12 center-block img-thumbnail' src='uploads/". $uploads."'></div>";
				if ($x%6==5)
				{
					$divs.="</div>";	
				}		
			}
			if ($x%6!=5) 
			{
				$divs.="</div>";
			}
			echo $divs;
			?>
		</div>
	</div>
</div>
<div class ="row">
	<div class ="imgs col-md-4"></div>
    <div class="form-group imgs col-md-4">
 	    <div class="col-sm-offset-2 col-sm-6">
 	    	<input id="tggle" class="btn btn-success" onclick="toggle();" type="submit" value="Or upload an Image"/>
	    </div>
    </div>
	<div class ="imgs col-md-4"></div>
</div>
<div id = "Play" class = "row">
	<div id="image_test" class = "col-md-3 center-block table-bordered">
		<div class="row center-block">
			<h4>Crrent Image :</h4>
		</div>
		<div class="row center-block">
			
			<img id = "view" class="col-md-12 center-block" src="<?php if($flag) 
			{
				if ($flag) {
				echo $output[0];
				}
			} 
			else{
				echo 'default.png';
				}?>">
		</div>
	</div>
	<div class = "col-md-5">
		<div id="Image_upload" class="row">
			<form class="form-inline center-block" id="form1" action="img_test.php" method="post" enctype="multipart/form-data">
			<div class="form-group">
			    <label for="file" class="col-sm-4 control-label">Upload File</label>
			    <div class="col-sm-8">
			      <input type="file" class="form-control" id="file" name="fileToUpload" />
			    </div>
			    <label for="question" class="col-sm-4 control-label">Ask Question</label>
			    <div class="col-sm-8">
			      <input type="text" class="form-control" id="question"  name="Question">
			    </div>
			  </div>
		    <div class="form-group">
		 	    <div class="col-sm-offset-2 col-sm-6">
		 	    	<input id="submit" class="btn btn-info" type="submit" value="Upload File And Ask"/>
			    </div>
		    </div>
			</form>
		</div>
		<div id="pre_image" class="row">
				<form class="form-horizontal" id="form2" action="AskQ.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
				    <div class="col-sm-6">
					    <input id="image" type="hidden" name="location" value="">
				    </div>
				 </div>
				  <div class="form-group">
				    <label for="question" class="col-sm-4 control-label">Ask Question</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" id="question"  name="Question">
				    </div>
				  </div>
			     <div class="form-group">
			 	    <div class="col-sm-offset-2 col-sm-6">
			 	    	<input id="submit" class="btn btn-info" name ="submit" type="submit" value="Ask"/>
				    </div>
		   		 </div>
			    </form>
		</div>
		<div id="result" class = "row">
			<fieldset disabled class="col-md-12">
				<label for="Answere" class="col-md-8 control-label">Answer Neural VQA:</label>
			      <input type="text" class="form-control input-lg col-md-8" id="Answere"  name="Question" placeholder="" value="<?php include 'output_files/output_class.txt';  ?>">
			</fieldset>
		</div>
	</div>
	<div class = "col-md-4">
	<fieldset disabled class="col-md-12">
				<label for="Term_output" class="col-md-8 panel-heading">Terminal :</label>
			        <textarea class="navbar-custom" rows="15" id="terminal" name="Term_output">root@root:~$ Initialised JobID - 1 &#13</textarea>
	</fieldset>
	</div>
</div>
<div class="row">
	<div class="col-md-4 center-block" >
        <div class="form-group">
		    <label for="selectBox" class="col-sm-4 control-label">Choose Action</label>
			    <select id="selectBox" onclick ="Work();" class="form-control dropdown">
					<option value="1">
						1) Grey
					</option>
					<option value="2";>
						2) Blur
					</option>
					<option value="3";>
						3) Canny
					</option>
				</select>
		</div>
	    <div class="input-group">
		    <button class="btn btn-primary btn-lg" onclick="Compile_str();" form="form3"  name ="submit"> Complile Funcitons and Execute</button>
    	</div>
	</div>
    <div class="col-md-8 center-block" >
    	<form class="form-horizontal " id="form3" method="post" enctype="multipart/form-data">
			<div class="form-group" id = "params">
			    <div class="input-group">
			   		<input type="hidden" class="form-control" id="ExeString"  name="ExeString" value="">
				</div>
				<div class="input-group">
			   		<input type="hidden" class="form-control" id="view_image"  name="view_image" value="<?php 
			   		if ($flag) {
			   			echo $folder;
			   		}
			   		else{
			   			echo 'default.png';
			   		}
			   		?>">
				</div>
			</div>
		</form>
   	</div>
</div>

<div class ="col-md-12 center-block table-bordered" id="Execute_img">
	<?php
	if ($flag) 
	{
		$imgs = '';
		array_shift($output);
		$k=0;
		foreach ($output as $src) 
		{
			# code...
			$imgs.="<img src='".$src."' title='".$functions[$k][0]."' class ='col-md-4 center-block img-thumbnail'>";# code...
			$k=$k+1;
		}
		echo $imgs;
		$flag='';
	}
	?>
</div>
</body>
</html>
