   
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->



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

                            <div class="form-group">
                                <label for="">Vehicles</label>
                                <div id="wardsBox">
                                    <select name="ward" id="ward" class="form-control">
                                        <option value="ALL">All Vehicles</option>
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


                    <div class="col-lg-3">
                        <div class="form-group">
                            <div style="padding-top: 30px">
                                <button type="button" class="btn btn-primary" id="transferData" name="transferData" >Prepare data for analysis</button>
                            </div>
                        </div>
                    </div>



                </div>



                <div class="row">
                    <div class="col-lg-12" id="reportAnalysis">
                      
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

            //  $("#loader").hide();

        });

    </script> 



