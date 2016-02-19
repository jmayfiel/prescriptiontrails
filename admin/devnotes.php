<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Dev Notes</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:20px;">

		<div class="row">
        
            <div class="col s12">
            
              <div class="card hoverable white">
              
              	<div class="card-content">
                
                	<h3>Dev Notes: Auth codes</h3>
                    
                    <p>The following codes are returned by the authentication class when calling login.</p>
                    
                    <h5>Code 10</h5>
                    <p>The user has been authenticated. The record is active and the associated email address has been validated.</p>

                    <h5>Code 1</h5>
                    <p>The user has been authenticated. The record is active but the associated email address has <strong>not</strong> been validated.</p>

                    <h5>Code 4</h5>
                    <p>The user provided incorrect login information.</p>

                    <h5>Code 2</h5>
                    <p>The user has been authenticated but has been marked as inactive.</p>
                
                </div>
              
              </div>
            
            </div>

      </div>
      
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>


  </body>
</html>
