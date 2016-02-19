<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
require("/nfs/users/clind/public_html/prescriptiontrails.org/trail/Html2Text.php"); 
$allTrailObj = new trails;
$allTrails = $allTrailObj->getAllPrint(); 

$count = $allTrails['totalMatched'];
$trails = $allTrails['trails'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Prescription Trails</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
<style>
/* -------------------------------------------------------------- 
  
 Hartija Css Print  Framework
   * Version:   1.0 
	 
-------------------------------------------------------------- */

body { 
width:100% !important;
margin:0 !important;
padding:0 !important;
line-height: 1.45; 
font-family: Garamond,"Times New Roman", serif; 
color: #000; 
background: none; 
font-size: 14pt; }

/* Headings */
h1,h2,h3,h4,h5,h6 { page-break-after:avoid; }
h1{font-size:19pt;}
h2{font-size:17pt;}
h3{font-size:15pt;}
h4,h5,h6{font-size:14pt;}


p, h2, h3 { orphans: 3; widows: 3; }

code { font: 12pt Courier, monospace; } 
blockquote { margin: 1.2em; padding: 1em;  font-size: 12pt; }
hr { background-color: #ccc; }

/* Images */
img { float: left; margin: 1em 1.5em 1.5em 0; max-width: 100% !important; }
a img { border: none; }

/* Links */
a:link, a:visited { background: transparent; font-weight: 700; text-decoration: underline;color:#333; }
a:link[href^="http://"]:after, a[href^="http://"]:visited:after { content: " (" attr(href) ") "; font-size: 90%; }

abbr[title]:after { content: " (" attr(title) ")"; }

/* Don't show linked images  */
a[href^="http://"] {color:#000; }
a[href$=".jpg"]:after, a[href$=".jpeg"]:after, a[href$=".gif"]:after, a[href$=".png"]:after { content: " (" attr(href) ") "; display:none; }

/* Don't show links that are fragment identifiers, or use the `javascript:` pseudo protocol .. taken from html5boilerplate */
a[href^="#"]:after, a[href^="javascript:"]:after {content: "";}

/* Table */
table { margin: 1px; text-align:left; }
th { border-bottom: 1px solid #333;  font-weight: bold; }
td { border-bottom: 1px solid #333; }
th,td { padding: 4px 10px 4px 0; }
tfoot { font-style: italic; }
caption { background: #fff; margin-bottom:2em; text-align:left; }
thead {display: table-header-group;}
img,tr {page-break-inside: avoid;} 

/* Hide various parts from the site
#header, #footer, #navigation, #rightSideBar, #leftSideBar 
{display:none;}
*/
</style>
</head>

<body>
<div class="container">

<?php
$i = 1;
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
	$html = new \Html2Text\Html2Text(rawurldecode($trail['desc']));
	
	$desc = $html->getText();
				
?>

<div class="row">
	<span><?php echo($trail['city']); ?>, <?php echo($trail['zip']); ?></span>
	<span style="float:right">Trail <?php echo($i); ?> of <?php echo($count); ?></span>
</div>

<div class="row">

    	<img style="float:right; width:250px; margin:10px;" src="<?php echo($trail['largeImgURL']); ?>" />

    	<h1><?php echo($trail['name']); ?></h1>
    	<p class="flow-text" itemprop="description"><?php echo(rawurldecode($trail['desc'])); ?></p>
		<p class="flow-text"><?php echo($trail['name']); ?> is a grade <?php if($trail['difficulty'] == 4) { echo("3++"); } else { echo($trail['difficulty']); } ?> trail with <?php echo($looptext); ?> for a total of <?php echo($distance); ?> miles (<?php echo($steps); ?> steps).</p>

<?php
		if($trail['loopcount'] == 1) {

		} else {
	
			foreach($trail['loops'] as $id => $details) {
				
				if($looptranslation) {
					$translation['loops'][$id] = (array) $translation['loops'][$id];
					$name = $translation['loops'][$id]['name'];	
				} else {
					$name = $details['name'];
				}
			
			?>
            					<h5><?php echo($name); ?></h5>
                                <p>This loop is <?php echo($details['distance']); ?> miles for a total of <?php echo($details['steps']); ?> steps.</p>
            <?php
				
			}
	
		}
?>                    			            
        
</div>

<div class="row" style="page-break-after: always;">
	<img id="satImg" src="<?php echo($trail['satImgURL']); ?>" style="float:right; width:200px;">
                            <h3 style="font-weight:200"><?php echo($lexicon[19][$lang_set]); //Attractions ?></h3>
                                <ul class="flow-text">
<?php
	
			foreach($trail['attractions'] as $id => $attraction) {
				if($attraction != "") {
			?>
                                    <li style="margin-top:4px;"><i class="fa fa-chevron-right red-text text-darken-2"></i> <?php echo(rawurldecode($attraction)); ?></li>
            <?php
				}
			}
	
?>                    			            

</div>

<?php $i++; } ?>

</div>
</body>
</html>