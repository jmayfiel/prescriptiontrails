<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php");

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
if($userActive) {
	$breadcrumb = '<a href="'.$baseurl.'dashboard/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';	
}

$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/" class="green-text text-darken-3">About</a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'about/providers/" class="green-text text-darken-3">Provider Information</a>';

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails - For Providers</title>
  <meta name="description" content="Information about the New Mexico Prescription Trails program for healthcare providers!"/>
  <meta itemprop="image" content="https://prescriptiontrails.org/img/logo-big-old.jpg"> 
  <meta property="og:image" content="https://prescriptiontrails.org/img/logo-big-old.jpg"/>
  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
  

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

      <div class="container" style="margin-top:30px;">

                	<h1 class="center glow hide-on-small-and-down">Provider Information</h1>
                	<h2 class="center glow hide-on-med-and-up">Provider Information</h2>


		<div class="row">
        
            <div class="col s12">
            
              <div class="card hoverable white">
              
              	<div class="card-content">

                    <p class="flow-text" style="margin-bottom:10px;">Being physically active is one of the most important steps that people of all ages can take to improve their health. The Prescription Trails project combines the support of health care providers with information on local parks and trails to provide patients with the tools to begin and maintain a walking program tailored to their existing level of fitness.</p>
                    <p>The Prescription Trails program is designed to increase walking and wheelchair rolling on suggested routes in Albuquerque and the South Valley. The project encourages health care providers to offer a walking prescription for patients who need to increase physical activity, with the ultimate goal of patients adopting regular walking as a life long activity.</p>
	
    				<h4>Downloads</h4>
						<ol>
                        	<li><a href="<?php echo($baseurl); ?>files/FactSheetGeneralPublic.pdf"><i class="fa fa-file-pdf-o"></i> Fact Sheet for Patients</a></li>
                            <li> <a href="<?php echo($baseurl); ?>files/2008PAGuidelinesHHSFAQs.pdf"><i class="fa fa-file-pdf-o"></i> Health and Human Services FAQs</a> - 2008 Physical Activity Guidelines for Americans.</li>
                            <li> <a href="<?php echo($baseurl); ?>files/PARecsforOlderAdultsACSMAHA2007.pdf"><i class="fa fa-file-pdf-o"></i> ACSMA/AHA Recommendations</a> - Summary: The recommendation for older adults is similar to the updated ACSM/AHA recommendation for adults, but has several important differences including: the recommended intensity of aerobic activity takes into account the older adult's aerobic fitness; activities that maintain or increase flexibility are recommended; and balance exercises are recommended for older adults at risk of falls. In addition, older adults should have an activity plan for achieving recommended physical activity that integrates preventive and therapeutic recommendations. The promotion of physical activity in older adults should emphasize moderate-intensity aerobic activity, muscle-strengthening activity, reducing sedentary behavior, and risk management.</li>
                            <li> <a href="<?php echo($baseurl); ?>files/BenefitsofPhysicalActivityProvidedbyParks&RecreationNRPA.pdf"><i class="fa fa-file-pdf-o"></i> National Recreation and Park Association (Research Series 2010)</a> - The Benefits of Physical Activity Provided by Park and Recreation Services: The Scientific Evidence.</li>
                        </ol>

					<h4>This website</h4>
                    <p>Prescriptiontrails.org is more than an online directory of trails. When patients create a MyPrescriptionTrails account, they can easily keep track of their physical activity, find favorite trails, and get continuous feedback about their activity.</p>                                          

					<h4>Benefits of walking</h4>
                    <p>Studies clearly demonstrate that walking can lower the risk for developing diseases such as coronary heart disease, stroke, some cancers (such as colon and breast) and depression. In addition, regular walking can lower the risk factors for disease such as high blood pressure, high blood cholesterol and obesity.</p>                                          
                    <p style="margin-top:10px;">Although the Prescription Trails project focuses primarily on walking, patients are also encouraged to engage in other forms of exercise that can provide additional benefits such as increased muscle and bone strength, flexibility and endurance. Walking and wheelchair rolling provides benefits to almost everyone, including generally healthy people, people at risk of developing chronic diseases and in people with current chronic conditions or disabilities.</p>                                          

					<h4>Walking for people with disabilities</h4>
                    <p>Walking and wheelchair rolling can provide important health benefits for people with disabilities. Sufficient evidence now exists to recommend that adults with disabilities should get regular physical activity (such as walking) although it is sometimes necessary to adapt their physical activity program to match their abilities in consultation with their healthcare provider.</p>                                          

					<h4>Walking for people with chronic conditions</h4>
                    <p>Walking can provide important health benefits to people with chronic conditions and can improve overall quality of life. Walking can provide therapeutic benefits for many chronic conditions and can be part of recommended treatment for these conditions. In addition, people with chronic conditions who engage in physical activity, such as walking, reduce their risk for developing other chronic conditions.</p>                                          

					<h4>Safe and Active</h4>
                    <p>In general, healthy men and women who plan prudent increases in their weekly amounts of physical activity do not need to consult a health-care provider before becoming active. Walking is a low intensity exercise that is safe for almost everyone.</p>                                          
                    <p style="margin-top:10px;">A unique feature of the Prescription Trails project is the written prescription for walking that a patient receives from his/her healthcare provider. To ensure that patients engage in appropriate levels of exercise, providers assess patient readiness to start or maintain a walking program and write prescriptions based on this assessment.</p>                                          
                    <p style="margin-top:10px;">Inactive people who gradually progress over time to relatively moderate-intensity activity have no known risk of sudden cardiac events, and very low risk of bone, muscle, or joint injuries.</p>                                          

					<h4>How much walking is recommended?</h4>
                    <p>Although some health benefits seem to begin with as little as 60 minutes a week, for substantial health benefits most adults should do at least 150 minutes a week of moderate-intensity physical activity such as brisk walking. Additional health benefits occur with increased exercise intensity, duration and frequency.</p>                                          
                    <p style="margin-top:10px;">Your patients can also reap the same health benefits by exercising in smaller ten-minute increments several times a day.</p>                                          
                                    
                </div>
              
              </div>
            
            </div>

      </div>
      
      </div>


<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>


  </body>
</html>
