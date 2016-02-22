<?php require("../admin/db.php");


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - About us!</title>

  <!-- CSS  -->
<?php require("../src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("../src/nav.php"); ?>

      <div class="container" style="margin-top:30px;">

                	<h1 class="center glow hide-on-small-and-down">About Prescription Trails</h1>
                	<h2 class="center glow hide-on-med-and-up">About Prescription Trails</h2>


		<div class="row">
        
            <div class="col s12">
            
              <div class="card hoverable white">
              
              	<div class="card-content">
                                          
                    <h3>Mission</h3>                    
                    <p class="flow-text" style="margin-bottom:10px;">Prescription Trails is a program designed to give all health care professionals tools to increase walking and wheelchair rolling on suggested routes, targeting and promoting healthy lifestyles for families.</p>
                    <p>To make sure that people engage in appropriate levels of physical activity, healthcare providers assess their patients for readiness to start or maintain a walking program and then write tailored prescriptions based on their current physical condition. Walking programs can contribute to the treatment and prevention of a number of chronic conditions such as diabetes, depression and high blood pressure.</p>

                      <div class="video-container" style="margin-top:20px;">
                        <iframe width="853" height="480" src="//www.youtube.com/embed/nPnMmID-BFI?rel=0" frameborder="0" allowfullscreen></iframe>
                      </div>                                    

                    <h4>Grassroots</h4>                    
                    <p>Prescription Trails currently has programs in Albuquerque, Las Cruces and Santa Fe, and other communities in New Mexico, many  of which have  active coalitions that support the local program. Each coalition has developed a collection of tools to help patients fill their prescriptions, including a Prescription Trails walking guide booklet to local "approved" parks and trails, with photos and detailed information about park locations, amenities, and trail ratings.</p>

                    <h4>Our Organization</h4>                    
                    <p>Prescription Trails is managed by New Mexico Health Care Takes On Diabetes, a coalition of local   organizations that works to reduce the negative health effects associated with diabetes among New Mexicans. </p>
                    
                    <h3>Support</h3>                    
                    <p>Initial funding was provided by the Robert Wood Johnson Foundation. Additional funding was provided by community partners, local foundations, and numerous hours were provided in-kind by the partners.</p>

                    <h3>Resources</h3>                    
						<ol>
                        	<li><a href="<?php echo($baseurl); ?>files/RxTrailAssessmentWorksheet.pdf"><i class="fa fa-file-pdf-o"></i> Trail Assessment Sheet</a></li>
                        	<li><a href="<?php echo($baseurl); ?>files/walk-log.pdf"><i class="fa fa-file-pdf-o"></i> Paper Walking Log</a></li>
                        	<li><a href="<?php echo($baseurl); ?>files/CitationsforPrescriptionTrails.php"><i class="fa fa-file-pdf-o"></i> Citations</a></li>
                        </ol>

                	<h3>Contributors</h3>                   
                    <p>The new Prescription Trails website and database project was a huge undertaking. Thanks to all who contributed!</p> 
                    <blockquote>                   
                        <p><strong>Jake Mayfield</strong> - coding, planning, design, and indexing</p>
                        <p><strong>Andrea Nanez</strong> - Indexing and translation</p>
                        <p><strong>Jason Welch</strong> - Indexing</p>
                    </blockquote>
                    <p>The Prescription Trails project would have been impossible without its dedicated director and support staff:</p> 
                    <blockquote>                   
                        <p><strong>Charm Lindblad</strong> - Executive Director</p>
                        <p><strong>Anna Dykeman</strong> - <a href="https://www.linkedin.com/in/anna-dykeman-447621b">Anna Dykeman Creative Services</a>, annadykeman@msn.com</p>
                        <p><strong>Andrew Parker</strong> - <a href="http://www.source3.com/">Source3 Computing</a></p>
                    </blockquote>

                    <h4>Partners</h4>                    
                    <p>Thanks to the organizations that made this project possible!</p>

                              <div class="collection z-depth-1" style="border-color:#ee6e73; border-radius:3px">
                                <a href="#!" class="collection-item">Albuquerque Alliance for Active Living</a>
                                <a href="http://www.americanheart.org/" class="collection-item">American Heart & Stroke Association</a>
                                <a href="http://www.bernco.gov/openspace" class="collection-item">Bernalillo County Parks and Recreation</a>
                                <a href="http://www.bcbsnm.com/" class="collection-item">Blue Cross Blue Shield of New Mexico</a>
                                <a href="http://www.cabq.gov/planning" class="collection-item">City of Albuquerque Planning Department</a>
                                <a href="http://www.cabq.gov/parks/" class="collection-item">City of Albuquerque Parks and Recreation Department</a>
                                <a href="http://www.nmms.org/subpages/NMMS_CPI.htm" class="collection-item">Clinical Prevention Initiative, Healthier Weight Workgroup</a>
                                <a href="http://www.fcch.com/" class="collection-item">First Choice Community Healthcare</a>
                                <a href="http://www.healthykidsnm.org/" class="collection-item">Healthy Kids New Mexico</a>
                                <a href="http://www.silversneakers.com/" class="collection-item">Healthways SilverSneakers Fitness Program</a>
                                <a href="http://parkshealthguide.org/" class="collection-item">Institute At The Golden Gate</a>
                                <a href="http://www.lovelacehealthplan.com/" class="collection-item">Lovelace Health Plan</a>
                                <a href="http://www.molinahealthcare.com/" class="collection-item">Molina Healthcare New Mexico</a>
                                <a href="http://www.nps.gov/ncrc/programs/rtca" class="collection-item">National Park Service, Rivers & Trails Program</a>
                                <a href="http://www.nmtod.com/" class="collection-item">New Mexico Health Care Takes On Diabetes</a>
                                <a href="http://www.diabetesnm.org/" class="collection-item">New Mexico Department of Health Diabetes Prevention and Control Program</a>
                                <a href="http://www.newmexico.org/state-parks/?gclid=CJa3tJa5p8UCFZBefgod2ZUAVA" class="collection-item">New Mexico State Parks</a>
                                <a href="http://www.phs.org/" class="collection-item">Presbyterian Health Plan</a>
                                <a href="http://som.unm.edu" class="collection-item">University of New Mexico School of Medicine</a>
                              </div>

                    <h4>Attribution</h4>                    
                    <p>Several open source frameworks were used in the development of this website. Please see <a href="http://revised.prescriptiontrails.org/legal/attribution/">this page</a> for information on attribution.</p>

                                    
                </div>
              
              </div>
            
            </div>

      </div>
      
      </div>


<?php require("../src/drawer.php"); ?>

<?php require("../src/js_base.php"); ?>


  </body>
</html>
