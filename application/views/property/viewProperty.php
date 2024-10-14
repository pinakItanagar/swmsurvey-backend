<?php

$record_id = '';
$ward_no = '';

$propertyType = '';
$occupancyStatus = '';
$pid = '';

$owner_name = '';
$guardian_name = '';
$mobile_no = '';
$no_of_properties = '';
$address = '';
$longitude = '';
$latitude = '';


if(!empty($property))
{
    foreach ($property as $uf)
    {
        $record_id = $uf->record_id;
        $ward_no = $uf->ward_no;
        $building_type = $uf->building_type;
        $propertyType = $uf->property_type;
        $occupancyStatus = $uf->occupancy_status;
        $pid = $uf->pid;
       
        $owner_name = $uf->owner_name;
        $guardian_name = $uf->guardian_name;
        $mobile_no = $uf->mobile_no;
        $no_of_properties = $uf->no_of_properties;
        $address = $uf->address;
        $longitude = $uf->longitude;
        $latitude = $uf->latitude;
    }
}


?>
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

                       <div class="col-lg-6">
                            <div class="form-group">
                                <label>Owner Name</label>
                                  <input type="text" class="form-control" name="owner_name" id="owner_name"  value="<?php echo $owner_name ?>" disabled="disabled" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Property Number</label>
                                  <input type="text" class="form-control" name="pid" id="pid" disabled="disabled" value="<?php echo $pid ?>">
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">

                      <div class="col-lg-6">
                            <div class="form-group">
                              <div class="form-group">
                                <label>Circle Name</label>
                                 <input type="text" class="form-control" name="application_no" disabled="disabled" id="application_no" >
                               </div>
                                  
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                              <div class="form-group">
                                <label>Ward No.</label>
                                 <input type="text" class="form-control" name="application_no" disabled="disabled" id="application_no" value="<?php echo $ward_no ?>">
                               </div>
                                  
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Longitude</label>
                                  <input type="text" class="form-control" name="longitude" disabled="disabled" id="longitude" value="<?php echo $longitude ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Latitude</label>
                                  <input type="text" class="form-control" name="latitude" disabled="disabled" id="latitude" value="<?php echo $latitude ?>">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Address</label>
                                  <input type="text" class="form-control" name="address" disabled="disabled" id="address" value="<?php echo $address ?>" >
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                  <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no ?>" disabled="disabled">
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Guardian Name</label>
                                  <input type="text" class="form-control" name="guardian_name" id="guardian_name" value="<?php echo $guardian_name ?>" disabled="disabled">
                            </div>
                        </div>
                    </div> 

                    <div class="row">
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Building Type</label>
                                <select name="building_type" id="building_type" class="form-control" required disabled="disabled">
                                    <?  foreach($buildingType as $bt) {  ?>
                                     <? if($building_type == $bt->use_code ) { ?>
                                        <option value="<?=$bt->use_code?>" selected="selected"><?=$bt->building_type_name?></option>    
                                     <? } else { ?>
                                        <option value="<?=$bt->use_code?>" ><?=$bt->building_type_name?></option>        
                                     <? } ?>    
                                    <? } ?>
                                 </select>
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>No. of Property</label>
                                  <input type="text" class="form-control" name="no_of_properties" id="no_of_properties" value="<?php echo $no_of_properties ?>" disabled="disabled">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Occupancy Status</label>
                                <select name="occupancy_status" id="occupancy_status" class="form-control" required>
                                    <option value="">Select Occupancy Status</option>
                                    <option value="1" <?php if($occupancyStatus == 'Self') {echo "selected=selected";} ?>>Self</option>
                                    <option value="2" <?php if($occupancyStatus == 'Occupied') {echo "selected=selected";} ?>>Occupied</option>
                                    <option value="3" <?php if($occupancyStatus == 'Tenant') {echo "selected=selected";} ?>>Tenant</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    
                   

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Property Type</label>
                                <select name="property_type" id="property_type" class="form-control" required>
                                    <option value="">Select Property Type</option>
                                    <option value="1" <?php if($propertyType == 'Flat') {echo "selected=selected";} ?>>Flat</option>
                                    <option value="2" <?php if($propertyType == 'Land') {echo "selected=selected";} ?>>Land</option>
                                    <option value="3" <?php if($propertyType == 'Vacant Land') {echo "selected=selected";} ?>>Vacant Land</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Address</label>
                                  <input type="text" class="form-control" name="address" id="address" value="<?php echo $address ?>">
                            </div>
                        </div>
                    </div>

                    



                    <div class="border-top">
                        <div class="card-body">
                            <input type="hidden" name="propertyId" value="<?php echo $record_id ?>">
                            <button type="submit" class="btn btn-primary" >Update</button>
                        </div>
                    </div>
                   

            </form>


        </div>
    </div>
</div>  


 

       