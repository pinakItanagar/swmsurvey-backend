
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('APPMSG')) { ?>

                <div class="alert alert-danger"> <?= $this->session->flashdata('APPMSG') ?> </div>

            <?php } ?>
            <!-- start white-box -->

           
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h3>Ward Details</h3>
                             
                            </div>
                        </div>
                    </div>
                    


                    <form id="myform" action="<?= base_url('manageproperty/downloadAuditReport') ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-2">
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
                        
                        
                        <div class="col-lg-2">
                            <div class="form-group">
                              
                              <div class="form-group">
			                    <label for="">Wards</label>
			                    <div id="wardsBox">
			                        <select name="ward" id="ward" class="form-control">
			                            <option value="">Select a Wards</option>
			                        </select>    
			                    </div>
			                    
			               	  </div>
                                  
                            </div>
                        </div>
                        
                        
                         <div class="col-lg-2">
                            <div class="form-group">
                                <label>Date From</label>
                                  <input type="text" class="form-control" name="date_from" id="date_from" placeholder="Enter Report From (yyyy-mm-dd)" value="<?=date("Y-m-d")?>" required>
                            </div>
                        </div>

                         <div class="col-lg-2">
                            <div class="form-group">
                                <label>Date To</label>
                                  <input type="text" class="form-control" name="date_to" id="date_to" placeholder="Enter Report To (yyyy-mm-dd)" value="<?=date("Y-m-d")?>" required>
                            </div>
                        </div>                        
                        
                         <div class="col-lg-4">
                            <div class="form-group">
                              <div style="padding-top: 30px">
                              <button type="button" class="btn btn-primary" id="property_audit" name="property_audit" >Submit</button>
                              
                              <input type="submit" class="btn btn-secondary" id="download_audit" name="download_audit" value="Download Audit Report">
                             
                              </div>
                            </div>
                        </div>

                     
                     
                        
                        
                    </div>
                  </form>
                 
                  
                    <div class="row">
                        <div class="col-lg-12" id="searchResult">
                            
                            
                        </div>
                        
                    </div>

           


        </div>
    </div>
</div>  

<script type="text/javascript">

    $(document).ready(function () {

        $("#date_from").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true

        });
        $("#date_to").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true

        });
    });

</script> 
 

       