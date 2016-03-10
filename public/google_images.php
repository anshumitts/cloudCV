<?php
session_start();
if(!(isset($_session["jobID"])))
{
	$_session["jobID"]=1;
	$command = 'uploads/'.$_session["jobID"];
	$train_folder = 'uploads/'.$_session["jobID"].'/train';
	$test_folder = 'uploads/'.$_session["jobID"].'/test';
	$util_folder = 'uploads/'.$_session["jobID"].'/util';
	mkdir($command,0777,true);
	mkdir($train_folder,0777,true);
	mkdir($test_folder,0777,true);
	mkdir($util_folder,0777,true);
}
?>
<html>
<head>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript">
        $(document).ready(function(event) {
            $('#form1').ajaxForm(function(data) {
            	var datas = String(data).split('-^-');
                $('#Answere').attr('placeholder', datas[0]);
                // $('#view').attr('src', datas[1]);
            });

            $('#form2').ajaxForm(function(data) {
                var datas = String(data).split('-^-');
                $('#Answere').attr('placeholder', datas[0]);
                $( "#result" ).append( "<div class=\'row\'><div class=\'row center-block\'><h3>"+String(datas[1])+"</h3></div>");
                for (var i =0; i<5; i++) 
                {         
					$( "#result" ).append("<div class=\'row\'>");
					for (var j =1; j< 5; j++) 
					{
						$( "#result" ).append("<div class=\'col-md-3\'><img src=\""+datas[0]+"Action_"+String(i*4+j)+".jpg\"></div>");
					}
					$( "#result" ).append("</div>");
                }
				$( "#result" ).append("</div>");
                // $('#view').attr('src', datas[1]);
            });
        });
		function get_output(obj)
		{
			document.getElementById("pre_image").style.display = 'block';
			document.getElementById("tggle_query").style.display = 'none';
			document.getElementById("tggle").style.display = 'block';
			document.getElementById("Image_upload").style.display = 'none';
		}
		function toggle()
		{
			document.getElementById("pre_image").style.display = 'none';
			document.getElementById("tggle").style.display = 'none';
			document.getElementById("tggle_query").style.display = 'block';
			document.getElementById("Image_upload").style.display = 'block';
		}
  </script> 

  <style type="text/css">

#prev_imgs{
	height: 100px;
border: 0px solid-black;
}
div{
	padding: 10px;
}
  img{
  	height: 250px;
  	border: 0px solid-black;
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
   #tggle_query{
  	display: block;
  }
  </style>
</head>
<body id="container">
<div class ="row">
	<div class ="imgs col-md-4"></div>
    <div class="form-group imgs col-md-4">
 	     <div class="col-sm-offset-2 col-sm-6">
 	    	<input id="tggle" class="btn btn-default" onclick="toggle()" type="submit" value="Or upload an Image"/>
 	    	<input id="tggle_query" class="btn btn-default" onclick="get_output();" type="submit" value="Or Query an Image"/>
	    </div>
    </div>
	<div class ="imgs col-md-4"></div>
</div>
<div id = "Play" class = "row">
	<div id="image_test" class = "col-md-6 center-block">
		<img id = "view" class="center-block" src="images\default.png">
	</div>
	<div class = "col-md-6">
		<div id="Image_upload">
			<form class="form-horizontal" id="form1" action="download_img.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
				    <div class="col-sm-6">
					    <input id="image" type="hidden" name="location" value="">
				    </div>
				 </div>
				  <div class="form-group">
				    <label for="Fetch" class="col-sm-4 control-label">Upload From Google Drive</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" id="Fetch"  name="Fetch">
				    </div>
				  </div>
			     <div class="form-group">
			 	    <div class="col-sm-offset-2 col-sm-6">
			 	    	<input id="submit" class="btn btn-default" name ="submit" type="submit" value="Ask"/>
				    </div>
		   		 </div>
			    </form>
		</div>
		<div id="pre_image">
				<form class="form-horizontal" id="form2" action="download_img.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
				    <div class="col-sm-6">
					    <input id="image" type="hidden" name="location" value="">
				    </div>
				 </div>
				  <div class="form-group">
				    <label for="Query" class="col-sm-4 control-label">Query Image</label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" id="Query"  name="Query">
				    </div>
				  </div>
			     <div class="form-group">
			 	    <div class="col-sm-offset-2 col-sm-6">
			 	    	<input id="submit" class="btn btn-default" name ="submit" type="submit" value="Ask"/>
				    </div>
		   		 </div>
			    </form>
		</div>
		<div class = "row">
			<fieldset disabled>
				<label for="Answere" class="col-sm-4 control-label">Answer:</label>
			      <input type="text" class="form-control input-lg" id="Answere"  name="Question" placeholder="">
			</fieldset>
		</div>
	</div>
</div>
<div class="row">
	<div id="result">
	</div>
</div>
</body>
</html>