  <nav class="no-print">
    <div class="nav-wrapper white">
    	<div class="container green-text text-darken-3">
          <a href="<?php echo($baseurl); ?>" class="brand-logo hide-on-small-and-down"><img src="<?php echo($baseurl); ?>img/logo-small-old.jpg" alt="Prescription Trails Logo" class="logo" /></a>
          <a href="<?php echo($baseurl); ?>" class="brand-logo hide-on-med-and-up"><img src="<?php echo($baseurl); ?>img/rxicon.jpg" alt="Prescription Trails Logo" class="logo" /></a>
          <a href="#" data-activates="mobile-nav" class="button-collapse green-text text-darken-3"><i class="material-icons">menu</i></a>
	<?php if(!$userActive) { ?>	
          <a href="#userUnAuth" class="modal-trigger button-collapse green-text text-darken-3 right hide-on-med-and-up"><i class="material-icons green-text text-darken-3" style="display:none!important">account_circle</i></a>
	<?php } else { 
		$class = "";
		if($_SESSION['is_provider']) {
			$user_url = $baseurl."provider/";		
		}
		elseif($_SESSION['is_admin']) {
			$user_url = $baseurl."admin/";
		}
		elseif($_SESSION['is_super']) {
			$user_url = $baseurl."super/";
		} else {
			$user_url = "#userAuth";
			$user_class = "modal-trigger";
		}
	?>
          <a href="<?php echo($user_url); ?>" class="<?php echo($user_class); ?> button-collapse green-text text-darken-3 right hide-on-med-and-up"><i class="material-icons green-text text-darken-3" style="display:none!important">account_circle</i></a>
	<?php } ?>
      <ul class="right hide-on-med-and-down">
        <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>filter/"><?php echo($lexicon[8][$lang_set]); //Search ?></a></li>
        <li><a class="green-text text-darken-3" href="<?php echo($baseurl); ?>map/"><?php echo($lexicon[10][$lang_set]); //Map ?></a></li>
        <li><a href="#drawer" class="modal-trigger green-text text-darken-3"><?php echo($lexicon[11][$lang_set]); //Menu ?></a></li>
        <li><a class="dropdown-button green-text text-darken-3" href="#!" data-activates="langDrop"><?php echo($lexicon[12][$lang_set]); //Language ?></a></li>
	<?php if(!$userActive) { ?>	
            <li><a href="#userUnAuth" class="modal-trigger tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?>"><i class="material-icons green-text text-darken-3" style="display:none!important">account_circle</i></a></li>
	<?php } else { ?>
            <li><a href="<?php echo($user_url); ?>" class="<?php echo($user_class); ?> tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?>"><i class="material-icons green-text text-darken-3" style="display:none!important">account_circle</i></a></li>
    <?php } ?>
      </ul>
      <ul class="right hide-on-small-and-down hide-on-large-only">
	<?php if(!$userActive) { ?>	
            <li><a href="#userUnAuth" class="modal-trigger tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?>"><i class="material-icons green-text text-darken-3" style="display:none!important">account_circle</i></a></li>
	<?php } else { ?>
            <li><a href="<?php echo($user_url); ?>" class="<?php echo($user_class); ?> tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?>"><i class="material-icons green-text text-darken-3" style="display:none!important">account_circle</i></a></li>
    <?php } ?>
      </ul>
<ul id="langDrop" class="dropdown-content">
  <li><a href="<?php echo($baseurl); ?>lang/?set=es&rdr=<?php echo(htmlspecialchars($_SERVER['REQUEST_URI'])); ?>">Español</a></li>
  <li><a href="<?php echo($baseurl); ?>lang/?set=en&rdr=<?php echo(htmlspecialchars($_SERVER['REQUEST_URI'])); ?>">English</a></li>
</ul>
    
<!--
          <ul class="right hide-on-med-and-down">
            <li><a class="tooltipped" href="<?php echo($baseurl); ?>filter/" data-position="bottom" data-delay="50" data-tooltip="Search for trails"><i class="material-icons green-text text-darken-3" style="display:none!important">search</i></a></li>
            <li><a href="<?php echo($baseurl); ?>map/" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="View map of all trails"><i class="fa fa-2x fa-map green-text text-darken-3" style="display:none!important"></i></a></li>
            <li><a href="#" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Change Language" onClick="Materialize.toast('Still working on this part!', 8000);"><i class="fa fa-2x fa-globe green-text text-darken-3" style="display:none!important"></i></a></li>
            <li><a href="#drawer" class="modal-trigger tooltipped" data-position="bottom" data-delay="50" data-tooltip="Open menu"><i class="material-icons green-text text-darken-3" style="display:none!important">more_vert</i></a></li>
	<?php if(!$userActive) { ?>	
            <li><a href="#userUnAuth" class="modal-trigger tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?>"><i class="material-icons green-text text-darken-3" style="display:none!important">account_circle</i></a></li>
	<?php } else { ?>
            <li><a href="<?php echo($user_url); ?>" class="<?php echo($class); ?> tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?>"><i class="material-icons green-text text-darken-3" style="display:none!important">account_circle</i></a></li>
    <?php } ?>
          </ul>
-->
          <ul class="side-nav" id="mobile-nav">
            <li><a href="<?php echo($baseurl); ?>">Home</a></li>
            <li><a href="<?php echo($baseurl); ?>filter/"><?php echo($lexicon[3][$lang_set]); //Find Trails ?></a></li>
            <li><a href="<?php echo($baseurl); ?>map/"><?php echo($lexicon[13][$lang_set]); //Map of all Trails ?></a></li>
	<?php if(!$userActive) { ?>	
            <li><a href="<?php echo($baseurl); ?>user/new/account/"><?php echo($lexicon[4][$lang_set]); //Create an account ?></a></li>
	<?php } else { ?>
            <li><a href="<?php echo($user_url); ?>" class="<?php echo($user_class); ?>"><?php echo($lexicon[34][$lang_set]); //MyPrescriptionTrails ?></a></li>
	<?php } ?>
            <li><a href="<?php echo($baseurl); ?>about/contact/"><?php echo($lexicon[47][$lang_set]); //Contact Us ?></a></li>
              <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                  <li>
                    <a class="collapsible-header"><?php echo($lexicon[12][$lang_set]); //Language ?><i class="mdi-navigation-arrow-drop-down"></i></a>
                    <div class="collapsible-body">
                      <ul>
                          <li><a href="<?php echo($baseurl); ?>lang/?set=es&rdr=<?php echo(htmlspecialchars($_SERVER['REQUEST_URI'])); ?>">Español</a></li>
                          <li><a href="<?php echo($baseurl); ?>lang/?set=en&rdr=<?php echo(htmlspecialchars($_SERVER['REQUEST_URI'])); ?>">English</a></li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </li>
          </ul>

       </div>
    </div>
  </nav>
<?php if($page_type == "filter") { ?><div class="row z-depth-2" style="background-color:#C7C7C7; height:31px;"></div><?php } ?>