<div id="cover">
    <div class="preloader-wrapper big active" id="locLoad">
      <div class="spinner-layer spinner-blue">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-red">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-yellow">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-green">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
    </div>
</div>
  <div id="drawer" class="modal bottom-sheet no-print">
    <div class="modal-content">
    	<div class="container">
                  
          <div class="row">

            <a href="<?php echo($baseurl); ?>about/" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-child"></i></h2>
                <p><?php echo($lexicon[15][$lang_set]); //Our Partners ?></p>
            </a>

            <a href="<?php echo($baseurl); ?>about/contact/" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-edit"></i></h2>
                <p>Contact Us</p>
            </a>

            <a href="<?php echo($baseurl); ?>about/sun/" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-sun-o"></i></h2>
                <p><?php echo($lexicon[17][$lang_set]); //Sun Safety ?></p>
            </a>

            <a href="<?php echo($baseurl); ?>about/pets/" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-paw"></i></h2>
                <p>Walking Your Pet</p>
            </a>
                        
          </div>

          <div class="row">

<?php if($userActive) { ?>
            <a href="<?php echo($baseurl); ?>dashboard/" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-dashboard"></i></h2>
                <p>Dashboard</p>
            </a>
<?php } else { ?>
            <a href="<?php echo($baseurl); ?>user/login/" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-user"></i></h2>
                <p><?php echo($lexicon[14][$lang_set]); //Log In ?></p>
            </a>
<?php } ?>

<?php if($userActive) { ?>
            <a href="<?php echo($baseurl); ?>user/logout.php" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-lock"></i></h2>
                <p>Log Out</p>
            </a>
<?php } else { ?>
            <a href="<?php echo($baseurl); ?>user/forgot/" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-question-circle"></i></h2>
                <p>Password Reset</p>
            </a>
<?php } ?>

            <a href="<?php echo($baseurl); ?>about/providers/" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-user-md"></i></h2>
                <p>Provider Information</p>
            </a>
            
            <a href="<?php echo($baseurl); ?>api/" class="waves-effect waves-green col s6 m3 center-align drawerlink hoverable">
            	<h2><i class="fa fa-code"></i></h2>
                <p>Developers</p>
            </a>
            
          </div>
          
        </div>
        
        
      
    </div>
  </div>

        <footer class="page-footer white z-depth-3 no-print" style="margin-top:40px;">
<?php if($special == "breadcrumb") { ?>        
        <div class="hide-on-small-and-down" style="width:100%; height:35px;background-color: #EFEFEF;margin-top: -20px;margin-bottom: 15px;">
        	<div class="container left-align" style="padding-top:8px;">
            	<?php echo($breadcrumb); ?>
            </div>
        </div>
<?php } ?>
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="black-text">About Prescription Trails</h5>
                <p class="black-text">Prescription Trails identifies walking and wheelchair rolling routes that are both safe and accessible to patients and families to promote healthy lifestyles (and pets, too!).</p>
				<p class="black-text"><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">The Prescription Trails Website and trail data</span> by <a class="green-text text-darken-3" xmlns:cc="http://creativecommons.org/ns#" href="<?php echo($baseurl); ?>" property="cc:attributionName" rel="cc:attributionURL">New Mexico Health Care Takes On Diabetes</a> are licensed under a <a class="green-text text-darken-3" rel="license" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.<br />More details and exceptions <a class="green-text text-darken-3" xmlns:cc="http://creativecommons.org/ns#" href="<?php echo($baseurl); ?>about/" rel="cc:morePermissions">here</a>.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="black-text">Links</h5>
                <ul>
                  <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>about/">About Us</a></li>
                  <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>about/contact/"><?php echo($lexicon[47][$lang_set]); //Contact Us ?></a></li>
                <?php if($userActive) { ?>	
                  <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>user/logout.php">Log Out</a></li>
                <?php } else { ?>
                  <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>user/new/account/">Create Account</a></li>
                <?php } ?>
                  <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>user/login/"><?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?></a></li>
                  <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>filter/"><?php echo($lexicon[3][$lang_set]); //Find Trails ?></a></li>
                  <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>about/tos/">Terms and Conditions</a></li>
                  <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>about/privacy/">Privacy Policy</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            <a rel="license" href="http://creativecommons.org/licenses/by/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by/4.0/80x15.png" /></a>
            <span class="right grey-text text-lighten-1"><?php if($page_type == "filter" || $page_type == "trail") { ?><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>api/<?php echo($page_type); ?>/?<?php echo($_SERVER['QUERY_STRING']); if($page_type == "filter") { ?>&offset=0&count=6<?php } ?>">This page in JSON</a> | <?php } ?><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>api/">API</a></span>
            </div>
          </div>
        </footer>

<?php if($userActive) { ?>

  <!-- Auth -->
  <div id="userAuth" class="modal no-print">
    <div class="modal-content">
      <h4>Hi, <?php echo($_SESSION['fname']); ?>!</h4>
		<p>You're logged in! What would you like to do?</p>
        <div class="row">
        	<div class="col s12">
                <a class="btn-large blue waves-effect waves-light" style="width:100%" href="<?php echo($baseurl); ?>dashboard/">Dashboard</a>
            </div>
        </div>
        <div class="row">
        	<div class="col s12">
                <a class="btn-large blue waves-effect waves-light" style="width:100%" href="<?php echo($baseurl); ?>dashboard/new/">New Activity</a>
            </div>
        </div>
        <div class="row">
        	<div class="col s12">
                <a class="btn-large blue waves-effect waves-light" style="width:100%" href="<?php echo($baseurl); ?>dashboard/favorites/">Favorite Trails</a>
            </div>
        </div>
        <div class="row">
        	<div class="col s12">
                <a class="btn-large blue waves-effect waves-light" style="width:100%" href="<?php echo($baseurl); ?>user/logout.php">Logout</a>
            </div>
        </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>  
  </div>

<?php } else { ?>
  
  <!-- UnAuth -->
  <div id="userUnAuth" class="modal no-print">
    <div class="modal-content">
      <h4>Login or Register</h4>
		<p><span class="hide-on-small-and-down">You are not currently logged in. </span>Please log in or register to continue.</p>
        <div class="row">
        	<div class="col s12">
                <a class="btn-large blue waves-effect waves-light" style="width:100%" href="<?php echo($baseurl); ?>user/login/?rdr=<?php echo(htmlspecialchars($_SERVER['REQUEST_URI'])); ?>"><?php echo($lexicon[14][$lang_set]); //Log In ?></a>
            </div>
        </div>
        <div class="row">
        	<div class="col s12">
                <a class="btn-large blue waves-effect waves-light" style="width:100%" href="<?php echo($baseurl); ?>user/new/account/"><?php echo($lexicon[23][$lang_set]); //Register ?></a>
            </div>
        </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>  
  </div>
  
<?php } ?>