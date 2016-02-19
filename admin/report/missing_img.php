<?php require("../db.php"); 
$page_type = "admin";

$reportObj = new trails;
$report = $reportObj->getReport("largeImgURL", "img/placeholder-lg.png"); 

$count = $report['totalMatched'];
$trails = $report['trails'];

$title = "Missing Hero Image Report - ".$count." Total";

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'admin/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'report/" class="green-text text-darken-3">Reports</a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'report/missing_img.php" class="green-text text-darken-3">Missing Images</a>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

<div class="container">
    <div class="row">
    
        
  <div class="col s12">

        <div class="row no-print">
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>admin/">Admin Home</a></div>
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>admin/report/">All Reports</a></div>
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="#!" onClick="window.print();">Print</a></div>
        </div>

   <div class="row">    
   		<div class="col s12">
			<div class="card white">
            	<div class="card-content">
                <h4>Report: Trails with missing hero images</h4>        
                  <table class="highlight" style="width:100%" width="100%">
                    <thead>
                      <tr>
                          <th data-field="name">Name</th>
                          <th data-field="location">Location</th>
                          <th data-field="actions">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
            <?php
            
                foreach($trails as $id => $trail) {
                    if($trail['loopcount'] == 1) {
                        $distance 	= $trail['loops'][1]['distance'];
                        $steps 		= $trail['loops'][1]['steps'];
                    } else {
                            $looptext	= $trail['loopcount']." loops";
                            $distance = 0;
                            $steps = 0;
                            foreach($trail['loops'] as $id => $details) {
                                $distance 	= $trail['loops'][$id]['distance'] + $distance;
                                $steps 		= $trail['loops'][$id]['steps'] + $steps;
                            }
                    }
                            $published = ($trail['published'] == 'true');
            ?>
            
                      <tr>
                        <td><?php echo($trail['name']); ?></td>
                        <td><?php echo($trail['city']); ?>, <?php echo($trail['zip']); ?></td>
                        <td><a href="<?php echo($baseurl."admin/new/?id=".$trail['id']); ?>&action=edit">Edit</a> | <a href="<?php if($pretty_urls) { echo($trail['url']); } else { echo($baseurl."trail/?id=".$trail['id']); } ?>">View</a></td>
                      </tr>
            
            <?php } ?>                
                    </tbody>
                  </table>
				</div>
             </div>
             
          </div>          
	</div>


           </div>
 
    </div>

</div>
      
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>

<script>
$('.publishSwitch').change(function() {
        var formData = {
            'id'              : $(this).data('id'),
            'value'             : $(this).prop('checked')
        };
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : '<?php echo($baseurl); ?>src/updatePublish.php', // the url where we want to POST
            data        : formData, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
                        encode          : true
        })
            .done(function(data) {

				if(data.status == "done") {
					Materialize.toast('Update pushed successfully', 5000);
				} else {
					Materialize.toast('Error: '+data.message, 5000);
				}
            })
		  .fail(function(xhr, textStatus, errorThrown) {
				Materialize.toast('Error: '+xhr.responseText, 10000);
			});
});
		$("#adminFilterCity").change(function() {
			var city = $(this).val();
			document.location = "<?php echo($baseurl); ?>admin/?by=city&city=" + city;
		});
</script>

  </body>
</html>
