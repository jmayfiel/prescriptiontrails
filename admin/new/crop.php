<?php require("../db.php"); 
 if(empty($_GET['url']) || empty($_GET['name'])) { die("Missing input."); } ?>
<!DOCTYPE html>
<html>
  <head>
    <title>cropit</title>
<style>
.image-editor { margin-left:150px;}
.cropit-image-preview {
  background-color: #f8f8f8;
  background-size: cover;
  border: 1px solid #ccc;
  border-radius: 3px;
  margin-top: 7px;
  width: 250px;
  height: 250px;
  cursor: move;
}

.cropit-image-background {
  opacity: .2;
  cursor: auto;
}

.image-size-label { margin-top: 0.6rem; }

input {
  /* Use relative position to prevent from being covered by image background */
  position: relative;
  z-index: 10;
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="jquery.cropit.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.1/js/materialize.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  </head>
  <body>

<div class="container" id="loading" style="margin-top:30vh; display:none;">
    <div class="row">
    	<div class="col s5">&nbsp;</div>
        <div class="col s2">
          <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-yellow-only">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div><div class="gap-patch">
                <div class="circle"></div>
              </div><div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>
          </div>
        </div>
    	<div class="col s5">&nbsp;</div>
	</div>
</div>

<div class="container" id="done" style="margin-top:20vh; display:none;">
      <div class="row">
        <div class="col s6 offset-s3">
          <div class="card white">
            <div class="card-content black-text">
              <span class="card-title black-text"><i class="material-icons">thumb_up</i> Done!</span>
              <p>Your display image has been uploaded and a thumb has been cropped! Let's move on!</p>
            </div>
          </div>
        </div>
      </div>
 </div>           

  <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
    <a class="btn-floating btn-large red export">
      <i class="large material-icons">done</i>
    </a>
  </div>
          
  
  <div class="container" id="imgDiv" style="margin-top:20px;">
    <div class="image-editor">
      <div class="cropit-image-preview-container">
        <div class="cropit-image-preview"></div>
      </div>
      <div class="image-size-label"> Resize image </div>
        <div class="row">
        	<div class="col s6">
                <p class="range-field">
                  <input type="range" class="cropit-image-zoom-input">
              	</p>
            </div>
        </div>
    </div>
  </div>
  <form id="dataForm">
  <input type="hidden" name="image-data" class="hidden-image-data" />
  </form>
    <script>
      $(function() {
        $imageEditor = $('.image-editor').cropit({
          exportZoom: 1.25,
          imageBackground: true,
          imageBackgroundBorderSize: 100,
          imageState: {
            src: '<?php echo(urldecode($_GET['url'])); ?>'
          }
        });
        $('.export').click(function() {
		  $("#imgDiv").hide("slide", { direction: "left" }, 400);
		  $(".fixed-action-btn").fadeOut(400);
		  $("#loading").delay(401).show("slide", { direction: "right" }, 400);
          var imageData = $imageEditor.cropit('export', {
				  type: 'image/jpg',
				  quality: 0.8
				});
		  $('.hidden-image-data').val(imageData);
			var formValue = $("#dataForm").serialize();
			$.post("thumbUp.php",
				{ name:"<?php echo(urldecode($_GET['name'])); ?>",img:formValue },
					function(data)
				{
					var response = jQuery.parseJSON(data);
					  $("#loading").delay(1000).hide("slide", { direction: "left" }, 400);
					  $("#done").delay(1401).show("slide", { direction: "right" }, 400);
					  window.parent.updateImg(response.url);
				}).fail(function(jqXHR, textStatus, errorThrown) 
				{
					alert(textStatus);
				});
	        });
      });
    </script>
  </body>
</html>