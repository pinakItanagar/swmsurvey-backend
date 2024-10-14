
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('assignsurveyor')) { ?>

                <div class="alert alert-success"> <?= $this->session->flashdata('assignsurveyor') ?> </div>

            <?php } ?>

            <!-- start white-box -->

            <form id="myform" action="<?= base_url('managesurveyor/assignsurveyor') ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h3>Ward Details</h3>
                             
                            </div>
                        </div>
                    </div>
                    <?php 
                        $lastWord = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); 
                        $selected_surveyor = '';
                        $ward_id = '';
                        $circles_id = '';
                        if (!empty($surveyors)) 
                        {
                            foreach ($surveyors as $surveyor) 
                            {
                                if($surveyor['userId'] == $lastWord) 
                                    {
                                        $selected_surveyor = $surveyor['first_name'].' '.$surveyor['last_name'];
                                        $surveyor_id = $surveyor['userId'];
                                    }
                            }
                        }

                   
                    ?>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Surveyor</label>
                                <input type="text" class="form-control" name="selected_surveyor" id="selected_surveyor" disabled="disabled" value="<?php echo $selected_surveyor ?>" required>
                                <input type="hidden" name="surveyor_name" id="surveyor_name" value="<?php echo $surveyor_id ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Circles</label>
                                  <select name="circle" id="circle" class="form-control" required>
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
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
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


                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary" >Submit</button>
                        </div>
                    </div>



            </form>


        </div>
    </div>
</div>  


 

       