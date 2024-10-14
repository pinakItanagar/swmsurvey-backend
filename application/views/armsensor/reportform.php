
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
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Circles</label>
                            <select name="circle" id="circle" class="form-control" required>
                                <option value="ALL">All Circle</option>
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

                            <div class="form-group">
                                <label for="">Vehicle No</label>
                                <div id="wardsBox">
                                    <select name="vehicle_no" id="vehicle_no" class="form-control">
                                        <option value="RBMN008086">BR0001</option>
                                    </select>    
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Report Date</label>
                            <input type="text" class="form-control" name="report_date" id="report_date" placeholder="Enter Report Date (yyyy-mm-dd)" value="<?= date("Y-m-d") ?>" required>
                        </div>
                    </div>


                  



                </div>
                
                
                <div class="row">
                    
                       <div class="col-lg-3">
                           &nbsp;
                       </div>
                    
                       <div class="col-lg-3">
                           &nbsp;
                       </div>
                    
                       <div class="col-lg-3">
                           &nbsp;
                       </div>
                    
                      <div class="col-lg-3">
                        <div class="form-group pull-right" >
                            <div style="float:right">
                                <button type="button" class="btn btn-primary" id="getJCBReport" name="getJCBReport"  >Submit</button>
                            </div>
                        </div>
                    </div>
                    
                </div>



                <div class="row">
                    <div class="col-lg-12" id="jcbReportResult">


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



