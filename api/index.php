<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - API</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:30px;">

                	<h1 class="center glow hide-on-small-and-down">Prescription Trails API</h1>
                	<h2 class="center glow hide-on-med-and-up">Prescription Trails API</h2>


		<div class="row">
        
            <div class="col s12">
            
              <div class="card hoverable white">
              
              	<div class="card-content">
                                          
                    <h3>The Basics</h3>                    
                    <p class="flow-text" style="margin-bottom:10px;">Prescription Trails makes our database of trails around the state available to other developers via a JSON API.</p>
                    <p>These data are licensed under the <a class="green-text text-darken-3" rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.</p>

                    <h3>Trail Object</h3>                    
                    <p>Trail data can be retrieve by sending a <code>GET</code> request to <code><?php echo($baseurl); ?>api/trail/</code> with the trail's id as a variable. For example, <code>GET <?php echo($baseurl); ?>api/trail/?id=2</code> returns the following information in JSON:</p>
                    <pre>

	<?php $GetTrail = new trail; $GetTrail->setID(2); echo(json_encode($GetTrail->getInfo("Array"), JSON_PRETTY_PRINT)); ?>

                    </pre>

                    <h3>Filter</h3>                    
                    <p>Our database can be searched by sending a <code>GET</code> request to <code><?php echo($baseurl); ?>api/filter/</code> with filter commands as variables. Each request will return the number of trails returned as <code>countReturned</code> and the total number of trails matched by the query as <code>totalMatched</code>. Note, you must set <code>offset</code> and <code>count</code>. For example, <code>GET <?php echo($baseurl); ?>api/filter/?by=city&city=Albuquerque&offset=0&count=6 </code> returns the following information in JSON:</p>
                    <pre>

	<?php $filterObj = new trails; $filterResult = $filterObj->filterByLocation("city","Albuquerque",0,6,"Array"); echo(json_encode($filterResult, JSON_PRETTY_PRINT)); ?>

                    </pre>
                    
                    <h3>Translations</h3>                    
                    <p>Notice that the JSON response for trail requests includes available translations under the key <code>translations</code>. In the request illustrated above, Spanish (es) is listed as an available translation. In order to retrieve this translation, we will send a <code>GET</code> request: <code>GET <?php echo($baseurl); ?>api/translation/?id=2&lang=es</code></p>
                    <pre>

	<?php echo(json_encode($GetTrail->getTranslation("es","Array"), JSON_PRETTY_PRINT)); ?>

                    </pre>

                	<h3>Website Source Code</h3>                   
                    <p>The source code for this website is available for use under the <a class="green-text text-darken-3" rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>. It is available at this <a href="https://github.com/jmayfiel/prescriptiontrails">GitHub repository</a>.</p>

                	<h3>Questions?</h3>                   
                    <p>Feel free to <a href="<?php echo($baseurl); ?>about/contact/">contact us</a> with any questions.</p> 
                                    
                </div>
              
              </div>
            
            </div>

      </div>
      
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>


  </body>
</html>
