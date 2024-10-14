
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <? if ($this->session->flashdata('APPMSG') != null) { ?>

                     <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            &nbsp;

                        </div>

                     </div>       



                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                                    

                                 <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">

                                  

                                    <span class="badge badge-pill badge-danger">Info : </span>

                                  

                                    <?=$this->session->flashdata('APPMSG')?>

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                      <span aria-hidden="true">×</span>

                                    </button>

                                 </div>





                        </div>

                    </div>



                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            &nbsp;

                        </div>

                     </div>  

               <? } ?>


            <!-- start white-box -->

            <form id="myform" action="<?= base_url('manageroute/savewaypoint') ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h3>Patna City Map</h3>
                             
                            </div>
                        </div>
                    </div>

                     <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                               <!-- MAP SPACE -->
                                 <div id="mapid"></div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Route Name</label>
                                  <input type="text" class="form-control" name="route_name" id="route_name" value="<?=$route->route_name?>" disabled="disabled" >
                            </div>
                        </div>
                    </div> 


                     <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Way Point Category</label>
                                
                                <select name="way_point_category" id="way_point_category" class="form-control" required>
                                     <option value="TRAFFIC" >Traffic</option>
                                     <option value="GENERIC" selected="selected">Generic Point</option>
                                     <option value="STOPPAGE">Intermediate Stopage</option>
                                     <option value="COLLECTION_POINT">Collection Point</option>
                                </select>
                                
                              
                              
                            </div>
                        </div>
                    </div>


                     <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Landmark Name</label>
                                  <input type="text" class="form-control" name="landmark_name" id="landmark_name" placeholder="Add landmark name"    >
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <h4>Land Mark Point</h4>
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Latitude</label>
                                  <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Enter Latitude" required>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Longitude</label>
                                  <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Enter Longitude here" required>
                            </div>
                        </div>
                    </div> 




                   



                    <div class="border-top">
                        <div class="card-body">
                             <input type="hidden" name="route_id" id="route_id" value="<?=$route->route_id?>" >
                            <button type="submit" class="btn btn-primary" >Submit</button>
                        </div>
                    </div>



            </form>


        </div>
    </div>
</div>  


 
<script type="text/javascript">

    $(document).ready(function () {

        $("#stock_entry_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true

        });

    });

    document.getElementById('mapid').style.cursor = 'pointer';

    var greenIcon = L.icon({
        iconUrl: '<?=base_url('images/map_pin.png')?>',
        

        iconSize:     [22, 20], // size of the icon
      
        iconAnchor:   [10, 0] // point of the icon which will correspond to marker's location
       
   });

    <? if($wayPoint  == true) { ?>
        var locations = '<?=$waypoints?>' ;
        var obj = JSON.parse(locations);
        
    <? } ?>

    <? if($startPoint  == true) { ?>
 

    var mymap = L.map('mapid').setView([<?=$startPointData->latitude?>, <?=$startPointData->longitude?>], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
       }).addTo(mymap);

    L.marker([<?=$startPointData->latitude?>, <?=$startPointData->longitude?>]).addTo(mymap)
    .bindPopup('Start Point of the route');
 
   <? } ?>


    <? if($endPoint  == true) { ?>
 
    L.marker([<?=$endPointData->latitude?>, <?=$endPointData->longitude?>]).addTo(mymap)
    .bindPopup('End Point of the route');
 
   <? } ?>


    mymap.on('click', function(e) {
       //alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
       $("#latitude").val(e.latlng.lat);
       $("#longitude").val(e.latlng.lng);
        var newMarker = new L.marker(e.latlng, {icon: greenIcon}).addTo(mymap);
    });

    <? if($wayPoint  == true) { ?>

        for (var i = 0; i < obj.length; i++) {
          var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ], {icon: greenIcon})
            .bindPopup(obj[i].landmark_name)
            .addTo(mymap);
        }

    <? } ?>

</script>  
       