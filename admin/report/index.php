<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$adminPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'admin/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'report/" class="green-text text-darken-3">Reports</a>';

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
            <div class="col m6 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>admin/">Admin Home</a></div>
            <div class="col m6 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="#!" onClick="window.print();">Print</a></div>
        </div>

   <div class="row">    
   		<div class="col s12">
			<div class="card white">
            	<div class="card-content">
                <h4>Available Administrator Reports</h4>        
                  <table class="highlight" style="width:100%" width="100%">
                    <thead>
                      <tr>
                          <th data-field="name">Name</th>
                          <th data-field="desc">Description</th>
                          <th data-field="link">Link</th>
                      </tr>
                    </thead>
                    <tbody>
            
                      <tr>
                        <td><strong>Missing Images</strong></td>
                        <td>This report scans the database for trails with missing primary images.</td>
                        <td width="100"><a href="<?php echo($baseurl); ?>admin/report/missing_img.php">Generate</a></td>
                      </tr>
                      <tr>
                        <td><strong>User Data [Requires SuperUser permissions]</strong></td>
                        <td>This report scans contains all user data. Passwords and other sensitive information are encrypted one way, and are not available.</td>
                        <td><a href="<?php echo($baseurl); ?>admin/report/users.php">Generate</a></td>
                      </tr>
                      <tr>
                        <td><strong>Site Map</strong></td>
                        <td>Site maps are useful for submission to search engines.</td>
                        <td><a href="<?php echo($baseurl); ?>src/genSiteMap.php" target="_blank">Generate</a></td>
                      </tr>
                      <tr>
                        <td><strong>Google Analytics</strong></td>
                        <td>This report scans the database for trails with missing primary images.</td>
                        <td><a href="https://analytics.google.com/analytics/web/"><i class="fa fa-external-link"></i> Launch</a></td>
                      </tr>
                      <tr>
                        <td><strong>Mailgun</strong></td>
                        <td>Mailgun is the transactional email application this website uses to communicate with individual users. Reports are available concerning delivery, etc.</td>
                        <td><a href="https://mailgun.com/app/dashboard"><i class="fa fa-external-link"></i> Launch</a></td>
                      </tr>
                      <tr>
                        <td><strong>MailChimp</strong></td>
                        <td>Information for each user is stored with MailChimp when accounts are created. Use this tool to send email newsletters.</td>
                        <td><a href="https://us12.admin.mailchimp.com/"><i class="fa fa-external-link"></i> Launch</a></td>
                      </tr>
            
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
