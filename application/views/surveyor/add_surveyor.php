
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('save')) { ?>

                <div class="alert alert-success"> <?= $this->session->flashdata('save') ?> </div>

            <?php } ?>

            <!-- start white-box -->

            <form id="myform" action="<?= base_url('managesurveyor/save') ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h3>Surveyor Details</h3>
                             
                            </div>
                        </div>
                    </div>

                    


                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>First Name</label>
                                  <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last name" required>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                  <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile Number" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Password</label>
                                  <input type="Password" class="form-control" name="surveyor_password" id="surveyor_password" placeholder="Enter Password" required>
                            </div>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Address</label>
                                  <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Vendor</label>
                                <select name="vendor_id" id="vendor_id" class="form-control" required >
                                    <? foreach ($vendors as $vendor) { ?>
                                    <option value="<?=$vendor->vendor_id?>"><?=$vendor->vendor_name?></option>
                                    <? } ?>
                                </select>    
                                  
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


 

       