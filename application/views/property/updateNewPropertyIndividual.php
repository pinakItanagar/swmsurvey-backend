
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('save')) { ?>

                <div class="alert alert-success"> <?= $this->session->flashdata('save') ?> </div>

            <?php } ?>

            <!-- start white-box -->

            <form id="myform" action="<?=base_url('manageproperty/saveIndividualProperty')?>" method="POST" class="form-horizontal" enctype="multipart/form-data">

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
                                <label>Owner Name</label>
                                <input type="text" class="form-control" name="owner_name" id="owner_name"  value="<?=strtoupper($property->owner_name)?>"  >
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Property Number</label>
                                <input type="text" class="form-control" name="pid" id="pid"  value="<?= $property->pid ?>">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Property Survey Status</label>
                                <input type="text" class="form-control" name="survey_status" id="survey_status" disabled="disabled" value="Done">
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

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Latitude</label>
                                <input type="text" class="form-control" name="latitude" disabled="disabled" id="latitude" value="<?= $property->latitude ?>">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Longitude</label>
                                <input type="text" class="form-control" name="longitude" disabled="disabled" id="longitude" value="<?= $property->longitude ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="<?=strtoupper($property->mobile_no) ?>" >
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Guardian Name</label>
                                <input type="text" class="form-control" name="guardian_name" id="guardian_name" value="<?=strtoupper($property->guardian_name) ?>" >
                            </div>
                        </div>
                    </div> 



                    <div class="row">
                      

                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Sector</label>
                                <input type="text" class="form-control" name="sector"  id="sector" value="<?=$property->sector ?>" >
                            </div>
                        </div>



                        <div class="col-lg-7">
                            <div class="form-group">
                                <label>Area/Landmark</label>
                                <input type="text" class="form-control" name="area_landmark" id="area_landmark" value="<?=$property->area_landmark ?>" >
                            </div>
                        </div>

                    </div>

                    <div class="row">


                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Address/Street</label>
                                <input type="text" class="form-control" name="address"  id="address" value="<?=$property->address_street?>" >
                            </div>
                        </div>



                    </div>

                  

                    <div class="row">

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Building Type</label>
                                <select name="building_type" id="building_type" class="form-control" required >
                                    <? foreach ($buildingType as $bt) { ?>
                                        <? if ($property->building_type == $bt->use_code) { ?>
                                            <option value="<?= $bt->use_code ?>" selected="selected"><?= $bt->building_type_name ?></option>    
                                        <? } else { ?>
                                            <option value="<?= $bt->use_code ?>" ><?= $bt->building_type_name ?></option>        
                                        <? } ?>    
                                    <? } ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>No. of Property</label>
                                <input type="text" class="form-control" name="no_of_properties" id="no_of_properties" value="<?= $property->no_of_properties ?>" >
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Occupancy Status</label>
                                <select name="occupancy_status" id="occupancy_status" class="form-control" required >

                                    <? if ($property->occupancy_status == 'Self') { ?>
                                        <option value="Self" selected = "selected" >Self</option>
                                        <option value="Tenants" >Tenants</option>
                                    <? } else { ?>
                                        <option value="Self"  >Self</option>
                                        <option value="Tenants" selected = "selected" >Tenants</option>
                                    <? } ?>   

                                </select>
                            </div>
                        </div>

                    </div>



                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Property Type</label>
                                <select name="property_type" id="property_type" class="form-control" required  >

                                    <? if ($property->property_type == 'Flat') { ?>
                                        <option value="Flat" selected = "selected" >Flat</option>
                                        <option value="LandB" >Land + Building</option>
                                    <? } else { ?>
                                        <option value="Flat"  >Flat</option>
                                        <option value="LandB" selected = "selected">Land + Building</option>
                                    <? } ?>   

                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>QR Code</label>
                                <input type="text" class="form-control" name="qr_code" id="qr_code" value="<?=$property->qr_code ?>" disabled="disabled">
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Surveyor Name</label>
                                <input type="text" class="form-control" name="surveyor_name" id="surveyor_name" value="<?=$property->first_name?> <?=$property->last_name?>" disabled="disabled">
                            </div>
                        </div>

                    </div>
                    
                    
                    <div class="row">
                        
                        <div class="col-lg-6">
                           
                                <label>Property Image</label>
                             
                        </div>
                        
                        <div class="col-lg-6">
                          
                                <label>Property Image with QR Code</label>
                          
                        </div>
                        
                       

                    </div>
                    
                    
                    <div class="row">
                        
                        <div class="col-lg-5 col-md-5">
                           
                            
                                <?
                                   $output_image_file = "download/pic_".trim($property->pid).".jpg";
                                   $property_pic = $property->property_pic;
                                   //base64_to_jpeg($property_pic, $output_image_file);
                                   file_put_contents($output_image_file, base64_decode($property_pic));  
                                ?>
                                
                            <img src="<?=base_url($output_image_file)?>"   class="img-fluid" >
                                 
                           
                        </div>
                        
                        <div class="col-lg-2 col-md-2">&nbsp;</div>
                        
                        <div class="col-lg-5 col-md-5">
                          
                              
                                  <?
                                   $output_image_file_qr = "download/pic_qr_".trim($property->pid).".jpg";
                                   $property_pic_qr = $property->property_qrcode_pic;
                                   file_put_contents($output_image_file_qr, base64_decode($property_pic_qr));  
                                 ?>
                            <img src="<?=base_url($output_image_file_qr)?>" class="img-fluid"  >
                           
                        </div>
                     
                    </div>
                    
                    
                     <div class="row">
                        
                        <div class="col-lg-6 col-md-6">
                           
                            
                            <div class="form-group">
                                <label>Upload Property Image</label>
                                <input type="file" class="form-control" name="property_image" id="property_image"  >
                            </div>
                                 
                           
                        </div>
                        
                        <div class="col-lg-6 col-md-6">
                          
                           <div class="form-group">
                                <label>Upload Property Image With QR Code</label>
                                <input type="file" class="form-control" name="property_image_qr" id="property_image_qr" >
                            </div>
                           
                        </div>
                     
                    </div>
                    

                    <div class="border-top">
                        <div class="card-body">
                              <input type="hidden" name="p_record_id" id="p_record_id" value="<?=$property->p_record_id?>" >
                              <input type="hidden" name="ward_no" id="ward_no" value="<?=$property->ward_no?>" >
                            <a href="<?= base_url('dashboard/newproperty/'.$property->ward_no) ?>" class="btn btn-primary" ><< Back to List</a>
                            &nbsp;
                             <button type="submit" class="btn btn-success" >Submit</button>
                        </div>
                    </div>


            </form>


        </div>
    </div>
</div>  




<script type="text/javascript">

   
    var mymap = L.map('mapid').setView([<?=$property->latitude?>, <?=$property->longitude?>], 13);
    
   
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="#">Patna Municipal Corporation</a>'
       }).addTo(mymap);
       
      

    L.marker([<?=$property->latitude?>, <?=$property->longitude?>]).addTo(mymap)
    .bindPopup('Apartment Name : <?=strtoupper($property->flatName)?><br>PID No : <?=$property->pid?><br>Address : <?=$property->address_street?>')
    .openPopup();


    mymap.on('click', function(e) {
       //alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
       $("#latitude").val(e.latlng.lat);
       $("#longitude").val(e.latlng.lng);
    });
    
  

</script> 