
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('assignsurveyor')) { ?>

                <div class="alert alert-success"> <?= $this->session->flashdata('assignsurveyor') ?> </div>

            <?php } ?>

            <!-- start white-box -->

           
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h3>Report Form</h3>
                             
                            </div>
                        </div>
                    </div>
                    


                    
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Circles</label>
                                  <select name="circle" id="circle" class="form-control" required>
                                     <option value="ALL">All Circle</option>
                                     <!--
                                     <?php       foreach ($circles as $circle) {      ?>
                                        <option value="<?php echo($circle['circle_id'])?>"><?php echo($circle['circle_name'])?></option>
                                     <?php  }  ?>
                                     -->
                                  </select>
                            </div>
                        </div>
                        
                        
                        <div class="col-lg-3">
                            <div class="form-group">
                              
                              <div class="form-group">
			                    <label for="">Wards</label>
			                    <div id="wardsBox">
			                        <select name="ward" id="ward" class="form-control">
			                            <option value="ALL">All Wards</option>
			                        </select>    
			                    </div>
			                    
			               	  </div>
                                  
                            </div>
                        </div>
                        
                        
                         <div class="col-lg-3">
                            <div class="form-group">
                                <label>Report Date</label>
                                  <input type="text" class="form-control" name="report_date" id="report_date" placeholder="Enter Report Date (yyyy-mm-dd)" value="<?=date("Y-m-d")?>" required>
                            </div>
                        </div>
                        
                        
                         <div class="col-lg-3">
                            <div class="form-group">
                              <div style="padding-top: 30px">
                              <button type="button" class="btn btn-primary" id="getReport" name="getReport" >Submit</button>
                              </div>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                   
                    
                  
                    <div class="row">
                        <div class="col-lg-12" id="reportResult">
                            
                            
                        </div>
                        
                    </div>


           


        </div>
    </div>
</div>  

<script type="text/javascript">

    $(document).ready(function () {

        $("#report_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true

        });

       

    });

</script> 

 

       