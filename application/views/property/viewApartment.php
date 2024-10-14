

<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('save')) { ?>

                <div class="alert alert-success"> <?= $this->session->flashdata('save') ?> </div>

            <?php } ?>

            <!-- start white-box -->

            <form id="myform" action="#" method="POST" class="form-horizontal" enctype="multipart/form-data">

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h3>Property Details</h3>

                            </div>
                        </div>
                    </div>
                    
                   

                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Property ID</label>
                                <input type="text" class="form-control" name="pid" id="pid" disabled="disabled" value="<?= $property->pid ?>">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Property Survey Status</label>
                                <input type="text" class="form-control" name="survey_status" id="survey_status" disabled="disabled" value="Done">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>QR Code</label>
                                <input type="text" class="form-control" name="qr_code" id="qr_code" value="<?= $property->qr_code ?>" disabled="disabled">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Circle Name</label>
                                    <input type="text" class="form-control" name="application_no" disabled="disabled" id="application_no" value="<?= $property->circle_name ?>" >
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Ward No.</label>
                                    <input type="text" class="form-control" name="application_no" disabled="disabled" id="application_no" value="<?= $property->ward_no ?>">
                                </div>

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

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Latitude</label>
                                <input type="text" class="form-control" name="latitude" disabled="disabled" id="latitude" value="<?= $property->latitude ?>">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Longitude</label>
                                <input type="text" class="form-control" name="longitude" disabled="disabled" id="longitude" value="<?= $property->longitude ?>">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Accuracy Level</label>
                                <input type="text" class="form-control" name="gpsaccuracy" disabled="disabled" id="gpsaccuracy" value="<?= $property->gpsaccuracy ?>">
                            </div>
                        </div>
                    </div>


                    <div class="row">


                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Sector</label>
                                <input type="text" class="form-control" name="address" disabled="disabled" id="address" value="<?= $property->sector ?>" >
                            </div>
                        </div>



                        <div class="col-lg-7">
                            <div class="form-group">
                                <label>Area/Landmark</label>
                                <input type="text" class="form-control" name="area_landmark" id="area_landmark" value="<?= $property->area_landmark ?>" disabled="disabled">
                            </div>
                        </div>

                    </div>

                    <div class="row">


                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Address/Street</label>
                                <input type="text" class="form-control" name="address" disabled="disabled" id="address" value="<?= $property->address_street ?>" >
                            </div>
                        </div>



                    </div>


                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Building Type</label>
                                <select name="building_type" id="building_type" class="form-control" required disabled="disabled">
                                    <? foreach ($buildingType as $bt) { ?>
                                        <? if ($property->building_type == $bt->use_code) { ?>
                                            <option value="<?= $bt->use_code ?>" selected="selected"><?= $bt->building_type_name ?></option>    
                                        <? } else { ?>
                                            <option value="<?= $bt->use_code ?>" ><?= $bt->building_type_name ?></option>        
                                        <? } ?>    
                                    <? } ?>
                                </select>
                            </div>
                        </div


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Property Type</label>
                                <select name="property_type" id="property_type" class="form-control" required disabled >

                                    <option value="Flat" selected = "selected" >Apartment</option>
                                    <option value="LandB" >Land + Building</option>


                                </select>
                            </div>
                        </div>









                        <div class="row">

                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                           
                                <label>Property Image</label>
                             
                            </div>
                        
                        
                            <div class="col-lg-2 col-md-2">&nbsp;</div>

                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                                    <label>Property Image with QR Code</label>

                            </div>



                        </div>


                        <div class="row">

                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">


                                <?
                                $output_image_file = "download/pic_" . trim($property->pid) . ".jpg";
                                $property_pic = $property->property_pic;
                                file_put_contents($output_image_file, base64_decode($property_pic));
                                $img = "data:image/jpeg;base64," . $property_pic;
                                ?>

                                <img src="<?= $img ?>"  class="img-fluid"  >


                            </div>

                            <div class="col-lg-2">&nbsp;</div>

                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">


                                <?
                                $output_image_file_qr = "download/pic_qr_" . trim($property->pid) . ".jpg";
                                $property_pic_qr = $property->property_qrcode_pic;
                                file_put_contents($output_image_file_qr, base64_decode($property_pic_qr));
                                ?>
                                <img src="<?= base_url($output_image_file_qr) ?>" class="img-fluid" >

                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-lg-4">&nbsp;</div>
                            
                        </div>


                        <div class="row">


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Surveyor Name</label>
                                    <input type="text" class="form-control" name="surveyor_name" id="surveyor_name" value="<?= $property->first_name ?> <?= $property->last_name ?>" disabled="disabled">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Survey Date/Time</label>
                                    <input type="text" class="form-control" name="surveyor_name" id="surveyor_name" value="<?= $property->date_updated ?>" disabled="disabled">
                                </div>
                            </div>

                        </div>        




                        <div class="border-top">
                            <div class="card-body">
                                <a href="<?= base_url('dashboard/overallwardinfo/' . $property->ward_no) ?>" class="btn btn-primary" ><< Back to List</a>
                            </div>
                        </div>


                        </form>


                    </div>
                </div>
        </div>  




        <script type="text/javascript">
            
            
             var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']});
           google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 20,  subdomains:['mt0','mt1','mt2','mt3'] });
           
           var baseLayers = {
            "Map View": osm,
            "Satellite View": google
          };
          
          
           var mymap = L.map('mapid', {
                        center: [<?= $property->latitude ?>, <?= $property->longitude ?>],
                        zoom: 15,
                        layers: [osm]
                    });

           L.control.layers(baseLayers).addTo(mymap);

         /*
            var mymap = L.map('mapid').setView([<?= $property->latitude ?>, <?= $property->longitude ?>], 13, layers: [osm]);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(mymap); */

            L.marker([<?= $property->latitude ?>, <?= $property->longitude ?>]).addTo(mymap)
                    .bindPopup('PID No : <?= $property->pid ?><br>QRCODE : <?= $property->qr_code ?> <br>ADDRESS : <?= $property->address_street ?>')
                    .openPopup();


            mymap.on('click', function (e) {
                //alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
                $("#latitude").val(e.latlng.lat);
                $("#longitude").val(e.latlng.lng);
            });

        </script> 