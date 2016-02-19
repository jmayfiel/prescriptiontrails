
      <div class="row" style="margin-top:10vh">
        <div class="col s12 m10 offset-m1">
          <div class="card red accent-4">
            <div class="card-content white-text">
              <h1 class="white-text glow" style="font-weight:300; margin-top:10px; margin-bottom:20px;" class="glow">Error!</h1>

                <h4>Error 404: Trail not found</h4>
                <p class="flow-text">The page you requested does not exist. Please try your search again or try browsing our trails from the homepage. In the mean time, our team of highly trained technical kittens is working to find the page you were looking for.</p>

            </div>
            <div class="card-action">
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