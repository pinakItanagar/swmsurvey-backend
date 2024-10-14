
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('save')) { ?>

                <div class="alert alert-success"> <?= $this->session->flashdata('save') ?> </div>

            <?php } ?>

            <!-- start white-box -->

            <form id="myform" action="<?= base_url('manageproperty/saveproperty') ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h3>Household Details</h3>
                             
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Property Number</label>
                                  <input type="text" class="form-control" name="pid" id="pid" placeholder="Enter Property No." required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Application Number</label>
                                  <input type="text" class="form-control" name="application_no" id="application_no" placeholder="Enter Application No." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Circles</label>
                                  <select name="circle" id="property_circle" class="form-control" required>
                                     <option value="">Select Circle</option>
                                     <?php
                                     if (!empty($circles)) {
                                        foreach ($circles as $circle) {
                                     ?>
                                        <option value="<?php echo($circle['circle_id'])?>"><?php echo($circle['circle_name'])?></option>
                                     <?php       
                                        }
                                     }
                                     ?>
                                  </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                              
                              <div class="form-group">
                                <label for="">Wards</label>
                                <div id="wardsBox">
                                    <select name="ward" id="ward"" class="form-control">
                                        <option value="">Select a Wards</option>
                                    </select>    
                                </div>
                                
                              </div>
                                  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Owner Name</label>
                                  <input type="text" class="form-control" name="owner_name" id="owner_name" placeholder="Enter name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Guardian Name</label>
                                  <input type="text" class="form-control" name="guardian_name" id="guardian_name" placeholder="Enter Guardian name" required>
                            </div>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                  <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter Mobile No." required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Building Type</label>
                                <select name="building_type" id="building_type" class="form-control" required>
                                    <option value="">Select Building Type</option>
                                    <option value="1">Residential</option>
                                    <option value="2">Commercial</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>No. of Property</label>
                                  <input type="text" class="form-control" name="no_of_properties" id="no_of_properties" placeholder="Enter No. of Property" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Occupancy Status</label>
                                <select name="occupancy_status" id="occupancy_status" class="form-control" required>
                                    <option value="">Select Occupancy Status</option>
                                    <option value="1">Self</option>
                                    <option value="2">Occupied</option>
                                    <option value="3">Tenant</option>
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
                                    <option value="1">Flat</option>
                                    <option value="2">Land</option>
                                    <option value="2">Vacant Land</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Address</label>
                                  <input type="text" class="form-control" name="address" id="address" placeholder="Enter address" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Longitude</label>
                                  <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Enter longitude" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Latitude</label>
                                  <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Enter latitude" required>
                            </div>
                        </div>
                    </div>



                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary" >Submit</button>
                        </div>
                    </div>



            </form>


        </div>
    </div>
</div>  


 

       