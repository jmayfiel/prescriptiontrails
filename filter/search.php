	  <div class="row" style="margin-top:5vh;">
        <div class="col s12 m10 offset-m1 center-align">
        	<h1 class="glow"><i class="fa fa-search"></i> <?php echo($lexicon[3][$lang_set]); //Find Trails ?></h1>
		</div>
      </div>
      <div class="row" style="margin-bottom:10vh;">
        <div class="col s12 m10 offset-m1">
			<div class="row">
                <div class="col s12">
                  <div class="card white black-text" style="overflow:visible; height:170px;">
                    <div class="card-content black-text" style="overflow:visible">
                      <span class="card-title black-text"><?php echo($lexicon[21][$lang_set]); //Search by City ?></span>
                        <div class="input-field col s12">
                        <select id="filterCity" class="icons">
                        <option value="" disabled selected><?php echo($lexicon[44][$lang_set]); //City or county ?></option>
        <?php foreach($cities as $id => $name) { ?>
                          <option value="<?php echo($name); ?>" data-icon="<?php echo($baseurl); ?>img/city/<?php echo($name); ?>.jpg" class="circle left"><?php echo($name); ?></option>
        <?php } ?>
                        </select>
                        <label><?php echo($lexicon[44][$lang_set]); //City or county ?></label>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
      		<div class="row">
            <div class="col s12 m6">
              <div class="card white black-text" style="overflow:visible; height:190px;">
                <div class="card-content black-text" style="overflow:visible">
                  <span class="card-title black-text"><?php echo($lexicon[22][$lang_set]); //Search by Zip Code ?></span>
                    <form action="<?php echo($baseurl); ?>filter/" method="get">
                          <div class="input-field col s12" style="margin-top:-5px;">
                              <input id="zip" type="number" min="10000" max="99999" name="zip" class="validate">
                              <label for="zip">Zip Code</label>
                          </div>
                          <div class="col s12 center-align">
                            <button type="submit" class="pink darken-3 waves-effect waves-light btn">Go</button>
                          </div>
                        <input type="hidden" value="zip" name="by" />
                    </form>
                </div>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card white" style="overflow:visible; height:190px;">
                <div class="card-content black-text" style="overflow:visible">
                  <span class="card-title black-text"><?php echo($lexicon[42][$lang_set]); //Search Near Me ?></span>
                    <p><?php echo($lexicon[43][$lang_set]); //Click the button below to search for trails near your current location. ?></p>
                    <p class="center-align" style="margin-top:-5px;"><a href="#!" onClick="getLocation(event, true);" class="pink darken-3 waves-effect waves-light btn tooltipped" style="margin-top:20px; margin-right:-15px;" data-position="bottom" data-delay="50" data-tooltip="Use currrent location"><i class="fa fa-location-arrow"></i></a></p>
                </div>
              </div>
            </div>
          </div>
      		<div class="row">
            <div class="col s12 m6">
              <div class="card white black-text" style="overflow:visible; height:190px;">
                <div class="card-content black-text" style="overflow:visible">
                  <span class="card-title black-text">Search by Name</span>
                    <form action="<?php echo($baseurl); ?>filter/" method="get">
                          <div class="input-field col s12" style="margin-top:-5px;">
                              <input id="name" type="text" name="name" class="validate">
                              <label for="name">Enter search</label>
                          </div>
                          <div class="col s12 center-align">
                            <button type="submit" class="pink darken-3 waves-effect waves-light btn">Go</button>
                          </div>
                        <input type="hidden" value="name" name="by" />
                    </form>
                </div>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card white" style="overflow:visible; height:190px;">
                <div class="card-content black-text" style="overflow:visible">
                  <span class="card-title black-text">Interactive Map</span>
                    <p>This tool allows you to view all of our trails on a convenient interactive map.</p>
                    <p class="center-align" style="margin-top:-5px;"><a href="<?php echo($baseurl); ?>map/" class="pink darken-3 waves-effect waves-light btn" style="margin-top:20px; margin-right:-15px;">Open Map</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>        
      </div>