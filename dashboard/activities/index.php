<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php");

$reportObj = new activity;
$report = $reportObj->getUserReport($_SESSION['user_id']); 

$sumArray = array();

foreach ($report as $k=>$subArray) {
  foreach ($subArray as $id=>$value) {
    $sumArray[$id]+=$value;
  }
}


$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'dashboard/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'dashboard/activities/" class="green-text text-darken-3">Walking Log</a>';

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
            <div class="col m6 s12" style="margin-top:16px"><a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>dashboard/">Dashboard</a></div>
            <div class="col m6 s12" style="margin-top:16px"><a class="waves-effect waves-dark btn herobtn white black-text" href="#!" onClick="window.print();">Print</a></div>
        </div>

   <div class="row">    
   		<div class="col s12">
			<div class="card white">
            	<div class="card-content">
                <h4>Walking log: <?php echo($_SESSION['fname']); ?> <?php echo($_SESSION['lname']); ?> as of <?php echo(date("F")); ?> <?php echo(date("j")); ?>, <?php echo(date("Y")); ?></h4>
                <?php if(count($report) < 1) { ?>
                	<p class="flow-text">It looks like you haven't logged any trails yet! Trying <a href="<?php echo($baseurl); ?>filter/">searching for a trail</a> to walk. :)</p>
                <?php } else { ?>  
                	<p class="flow-text">You've walked a total of <?php echo(number_format($sumArray['steps'])); ?> steps or <?php echo($sumArray['distance']); ?> miles.</p>      
                  <table class="highlight" style="width:100%" width="100%">
                    <thead>
                      <tr>
                          <th data-field="date">Date</th>
                          <th data-field="trail">Trail</th>
                          <th data-field="distance">Distance</th>
                          <th data-field="steps">Steps</th>
                          <th data-field="time">Time</th>
                      </tr>
                    </thead>
                    <tbody>
            <?php
                foreach($report as $id => $log) {
                    if($log['type'] == "trail") {
                        $trail_text = '<a href="'.$baseurl.'trail/?id='.$log['trail_id'].'">'.urldecode($log['trail_name']).'</a>';
                    } else {
						$trail_text = 'Custom';
                    }
            ?>
            
                      <tr>
                        <td><?php echo($log['date']); ?></td>
                        <td><?php echo($trail_text); ?></td>
                        <td><?php echo($log['distance']); ?></td>
                        <td><?php echo($log['steps']); ?></td>
                        <td><?php echo($log['time']); ?> min</td>
                      </tr>
            
            <?php } ?>                
                    </tbody>
                  </table>
          <?php } ?>
				</div>
             </div>
             
          </div>          
	</div>


           </div>
 
    </div>

</div>
      
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>


  </body>
</html>
