
 


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDLQm_ttVZOC_AGj0_e5tq7HxjHz_w5BlE"></script>
<script src="<?=DIR?>design/assets/map/locationpicker.jquery.js"></script>






<div class="form-group ">
<input type="text" value="" class="form-control span6" id="us2-address" required/>
</div>
<div class="span12" style="float: left;width: 900px;">
<div class="form-group">
<div id="us2" style="width: 100%; max-width: 100%; height: 300px;"></div>
<div class="clearfix">&nbsp;</div>
</div>
</div>
    
<input type="hidden" name="lat" class="form-control" style="width: 150px" id="let" />
<input type="hidden" name="lag" class="form-control" style="width: 150px" id="lag" /> 
                                                              







<script>
$('#us2').locationpicker({
location: {
latitude: "30.040091568493178",
longitude: "31.226806640625"
},
zoom: 10,
radius: 300,
inputBinding: {
latitudeInput: $('#let'),
longitudeInput: $('#lag'),
radiusInput: $('#us2-radius'),
locationNameInput: $('#us2-address')
},
enableAutocomplete: true
});
</script>