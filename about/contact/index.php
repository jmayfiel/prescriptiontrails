<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
if($userActive) {
	$breadcrumb = '<a href="'.$baseurl.'dashboard/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';	
}

$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/" class="green-text text-darken-3">About</a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/contact/" class="green-text text-darken-3">Contact Us</a>';

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Contact Us</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:30px;">

                	<h1 class="center glow hide-on-small-and-down">Contact Us</h1>
                	<h2 class="center glow hide-on-med-and-up">Contact Us</h2>


		<div class="row">
        
            <div class="col s12">
            
              <div class="card hoverable white">
              
              	<div class="card-content">

                    <p class="flow-text" style="margin-bottom:10px;">Have a question, comment, or concern? Feel free to contact us! Points of contact are listed below:</p>
                                          
					<h5 style="margin-top:30px;">Charmaine Lindblad, Executive Director</h5>
                    <blockquote>Media relations, partnerships, and all other topics not covered below</blockquote>
                    <p><a href="#" onclick="showEmail(event,1);" id="hide1" class="btn pink darken-3 white-text waves-effect waves-light">Show Email Address</a></p>

					<h5 style="margin-top:40px;">Andrew Parker, Maintainer</h5>
                    <blockquote>Updating trail information, adding trails</blockquote>
                    <p><a href="#" onclick="showEmail(event,2);" id="hide2" class="btn pink darken-3 white-text waves-effect waves-light">Show Email Address</a></p>

					<h5 style="margin-top:40px;">Jake Mayfield, Principle Designer</h5>
                    <blockquote>API questions, security issues, requests for deeper integration</blockquote>
                    <p><a href="#" onclick="showEmail(event,3);" id="hide3" class="btn pink darken-3 white-text waves-effect waves-light">Show Email Address</a></p>
                                                        
                </div>
              
              </div>
            
            </div>

      </div>
      
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

<script>
var domain = "prescriptiontrails.org";
function showEmail(e,id) {
	e.preventDefault();
	var name = "";
	if(id == 1) {
		name += "direc";
		name += "tor";
	}
	if(id == 2) {
		name += "su";
		name += "pport";
	}
	if(id == 3) {
		name += "te";
		name += "ch";
	}
	var addr = name + "@" + domain;
	$("#hide"+id).replaceWith(addr);
}
</script>

  </body>
</html>
