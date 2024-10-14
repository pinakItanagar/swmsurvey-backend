
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('save')) { ?>

                <div class="alert alert-success"> <?= $this->session->flashdata('save') ?> </div>

            <?php } ?>

            <!-- start white-box -->

            <form id="myform" action="<?= base_url('manageroute/saveend') ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">

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
                                <h4>End Point</h4>
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

    <? if($startPoint  == true) { ?>
 

    var mymap = L.map('mapid').setView([<?=$startPointData->latitude?>, <?=$startPointData->longitude?>], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
       }).addTo(mymap);

    L.marker([<?=$startPointData->latitude?>, <?=$startPointData->longitude?>]).addTo(mymap)
    .bindPopup('Start Point of the route')
    .openPopup();
 
   <? } else {  ?>

      var mymap = L.map('mapid').setView([25.6007, 85.2220], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
       }).addTo(mymap);

    L.marker([25.6007, 85.2220]).addTo(mymap)
    .bindPopup('Patna city map')
    .openPopup();

   <? } ?>


    mymap.on('click', function(e) {
       //alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
       $("#latitude").val(e.latlng.lat);
       $("#longitude").val(e.latlng.lng);
        var newMarker = new L.marker(e.latlng).addTo(mymap);
    });

</script>  
       