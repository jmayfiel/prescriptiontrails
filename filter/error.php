<?php
header("HTTP/1.0 404 Not Found");
	switch($error) {
		case "city":
			$error_type = "invalid_city";	
			$error_details = "A malformed city search was passed to the filter. This is unlikely to happen unless the URL is altered.";
			break;
		case "by":
			$error_type = "invalid_filter";	
			$error_details = "Filter options include city, zip, grade, name, and coordinates. None were passed to the filter. URL was likely altered or base_url/filter/ was visited directly.";
			break;
		case "coord":
			$error_type = "invalid_coordinates";	
			$error_details = "An invalid coordinate was passed to the filter. Valid coordinates are numeric. URL was likely altered.";
			break;
		default:
			$error_type = "unknown";	
			$error_details = "An unknown error has occurred and our system was not prepared to handle it. That's all we know. :(";
	}
?>
      <div class="row" style="margin-top:10vh;">
        <div class="col s12 m10 offset-m1">
          <div class="card red accent-4">
            <div class="card-content white-text">
              <h1 class="white-text glow" style="font-weight:300; margin-top:10px; margin-bottom:20px;" class="glow">Error!</h1>

<?php if($error == "city") { ?>
	<h4>We weren't able to find the city of "<?php echo(htmlentities($_GET['city'])); ?>" in our system.</h4>
    <p class="flow-text">Please try your search again or try browsing our trails from the homepage.</p>
<?php } elseif($error == "by") { ?>
    <h4>Error 404: Filter not found</h4>
    <p class="flow-text">The page you requested does not exist. Please try your search again or try browsing our trails from the homepage. In the mean time, our team of highly trained technical kittens is working to find the page you were looking for.</p>
<?php } else { ?>
    <h4>Error 404: Page not found</h4>
    <p class="flow-text">The page you requested does not exist. Please try your search again or try browsing our trails from the homepage. In the mean time, our team of highly trained technical kittens is working to find the page you were looking for.</p>
<?php } ?>
            </div>
            <div class="card-action">
              <a href="<?php echo($baseurl); ?>filter/">Search again</a>
              <a href="<?php echo($baseurl); ?>">Return home</a>
            </div>
          </div>
        </div>
      </div>
      
  <div class="row" style="margin-bottom:10vh;">
        <div class="col s12 m10 offset-m1">
          <ul class="collapsible" data-collapsible="accordion">
            <li>
              <div class="collapsible-header"><i class="material-icons">filter_drama</i>Technical Details</div>
              <div class="collapsible-body white"><img src="<?php echo($baseurl); ?>img/techsupport.gif" width="110" style="float:left;margin-top:10px;margin-left:10px;margin-right:10px;" /><p><strong><?php echo($error_type); ?></strong>: <?php echo($error_details); ?></p></div>
            </li>
          </ul>
        </div>
    </div>    	

      	</div>      
      </div>