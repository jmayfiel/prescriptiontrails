<?php 
header("HTTP/1.0 404 Not Found");
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");
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

<div class="container" style="margin-top:15vh; margin-bottom:15vh">

      <div class="row" style="margin-top:10vh">
        <div class="col s12 m10 offset-m1">
          <div class="card red accent-4">
            <div class="card-content white-text">
              <h1 class="white-text glow" style="font-weight:300; margin-top:10px; margin-bottom:20px;" class="glow">Error!</h1>

                <h4>Error 404: Page not found</h4>
                <p class="flow-text">The page you requested does not exist. Please try your search again or try browsing our trails from the homepage. In the mean time, our team of highly trained technical kittens is working to find the page you were looking for.</p>

            </div>
            <div class="card-action">
              <a href="<?php echo($baseurl); ?>">Return home</a>
              <a href="<?php echo($baseurl); ?>filter/">Search for Trails</a>
            </div>
          </div>
        </div>
      </div>
</div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>
</body>
</html>