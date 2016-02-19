<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
if($userActive) {
	$breadcrumb = '<a href="'.$baseurl.'dashboard/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';	
}

$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/" class="green-text text-darken-3">About</a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/sun/" class="green-text text-darken-3">Sun Safety</a>';

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - Sun Safety</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:30px;">

                	<h1 class="center glow hide-on-small-and-down">Step into Sun Safety!</h1>
                	<h2 class="center glow hide-on-med-and-up">Step into Sun Safety!</h2>


		<div class="row">
        
            <div class="col s12">
            
              <div class="card hoverable white">
              
              	<div class="card-content">

                    <p class="flow-text" style="margin-bottom:10px;">Exercising outdoors is something New Mexicans can do all year long. Physical activity is an important way to improve and maintain your overall health. However, the New Mexico sun emits high levels of ultraviolet (UV) radiation during most days of the year, which can put people at risk for skin cancer and other skin and eye damage. Before you head outdoors to hit the trails, take a few minutes to ensure you are also keeping your skin and eyes healthy and safe from the strong New Mexico sun.</p>
                                          
                    <h4>Sun Protection Tips for Outdoor Physical Activity:</h4>                    
                        <ol>
                          <li>If possible, schedule physical activity during hours when the sun is less intense.  The sun is strongest between 10 a.m. and 4 p.m. Trying using a shade umbrella while walking to protect yourself.</li>
                          <li>Protective clothing is important.  Wear long sleeves and pants with a tight weave when exposed to sunlight.  If you can see sunlight through a fabric, UV rays can get through, too. Wear dark or bright colors, since they absorb more UV than do lighter colors.</li>
                          <li>Wear a broad-brimmed hat that protects your neck and ears and sunglasses that block 99% to 100% of UVA and UVB radiation.</li>
                          <li>Use a broad spectrum sunscreen with an SPF of 15 or higher, even on cloudy days.  Put sunscreen on 15 - 30 minutes before going outside to give it time to soak into your skin.  Use a lip balm with sunscreen to protect your lips.</li>
                          <li>Do not allow yourself to get sunburned.   Overexposure to the sun is the most preventable risk factor for skin cancer.</li>
                        </ol>
                        <p>One great way to check the sun’s intensity is the UV Index.  The UV Index predicts the strength of solar UV radiation on any given day using a scale from 1 (low) to 11+ (extremely high).  To learn about the daily UV Index, visit the <a href="http://www2.epa.gov/sunwise/uv-index" target="_blank">Environmental Protection Agency’s</a> web site.</p>
                        <p>The following resources give more information about skin cancer and how to protect your skin from the sun:</p>
                        <ul>
                          <li><a href="http://www.cancernm.org/rays/documents/EPAFactSheet5-18-2012withnewlogo.pdf" target="_blank">Facts About Skin Cancer in New Mexico</a></li>
                          <li><a href="http://www.cancernm.org/rays/pdf/Be_Sun-safe-Adults.pdf" target="_blank">Be Sun Safe, New Mexico!</a></li>
                          <li><a href="http://www.cancernm.org/rays/pdf/Keeping_Kids_Sun-Safe.pdf" target="_blank">Keeping Kids Safe in the New Mexico Sun</a></li>
                        </ul>
                                    
                </div>
              
              </div>
            
            </div>

      </div>
      
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>


  </body>
</html>
