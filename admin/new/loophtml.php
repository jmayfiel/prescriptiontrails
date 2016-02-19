<?php

$loop0 = '<div class="row" id="loopPre" style="margin-top:20px;"><div class="col s6 offset-s3"><div class="card white"><div class="card-content black-text"><span class="card-title black-text"><i class="material-icons">view_quilt</i> Waiting on you!</span><p>The loop editor will appear when you indicate how many loops this trail has! See above.</p></div></div></div></div>';

$loop = '<div class="row"><div class="col s12"><p>Loop N</p></div></div><div class="row"><div class="input-field col s4"><input placeholder="e.g. Outer Loop" id="loopNname" name="loopNname" type="text" class="validate"><label class="loopDynamic" for="loopNname">Give this loop a name!</label></div><div class="input-field col s3"><input placeholder="e.g. 0.5" id="loopNdistance" name="loopNdistance" type="text" class="validate"><label class="loopDynamic" for="loopNdistance">Distance? (miles, number only please!)</label></div><div class="col s2 text-center center-align"><a href="#" class="waves-effect waves-light btn-flat" style="margin-top:12px;" onClick="calcSteps(N,event);"><i class="fa fa-calculator"></i><i class="fa fa-arrow-right"></i></a></div><div class="input-field col s3"><input placeholder="e.g. 1200" id="loopNsteps" name="loopNsteps" type="number" class="validate"><label class="loopDynamic" for="loopNsteps">How many steps is this loop?</label></div></div>';


$attraction0 = '<div class="row" id="attrPre" style="margin-top:20px;"><div class="col s4"><div class="card white"><div class="card-content black-text"><p class="center-text center-align"><a class="waves-effect waves-light blue lighten-1 btn addattr" href="#"><i class="material-icons left">add_circle</i>Add</a>
</p></div></div></div></div>';

$attraction = '<div class="col s4" id="DIVattractionN"><div class="card white"><div class="card-content black-text"><a class="closeButton black-text" href="#" onClick="fxnN"><i class="fa fa-close"></i></a><div class="input-field"><input placeholder="Something exciting!" id="attractionN" name="attractionN" type="text" class="validate"><label for="attractionN" id="attractionLN">Attraction N</label> </div></div></div>';

?>