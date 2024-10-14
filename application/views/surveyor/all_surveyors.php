  <!-- ============================================================== -->

                <!-- Sales Cards  -->

                <!-- ============================================================== -->





                 <? if ($this->session->flashdata('APPMSG') != null) { ?>

                     <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            &nbsp;

                        </div>

                     </div>       



                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                                    

                                 <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">

                                  

                                    <span class="badge badge-pill badge-danger">Info : </span>

                                  

                                    <?=$this->session->flashdata('APPMSG')?>

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                                      <span aria-hidden="true">×</span>

                                    </button>

                                 </div>





                        </div>

                    </div>



                    <div class="row">

                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                            &nbsp;

                        </div>

                     </div>  

               <? } ?>



                 <div class="row pull-right">

                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pull-right">

                        <a href="<?=base_url('managesurveyor/addsurveyor/')?>"  class="btn btn-primary">Add New Surveyor</a>

                    </div>

                 </div> 

   

                 <div class="row">

                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                        &nbsp;

                    </div>

                 </div> 

            

                <div class="row">

                    <!-- Column -->

                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                        <div class="card">

                        

                            <div class="card-body">

                                <h5 class="card-title">All Surveyor List</h5>



                                <div class="table-responsive">

                                    <table id="zero_config" class="table table-striped table-bordered">

                                        <thead>

                                            <tr>

                                                <th width="10%"># Slno</th>
                                                <th width="35%">Surveyor Name </th>
                                                <th width="35%">Mobile Number </th>
                                                <th width="35%">Address </th>
                                                <th>Action</th> 

                                            </tr>

                                        </thead>



                                        <tbody>

                                               <? $slno = 1; ?>

                                              <?php foreach($allSurveyors as $row) { 

                                                //$assign_url = 'managesurveyor/wardwisesurveyor/'.$row->userId;

                                              ?>
                                              
                                                
                                      
                                                <tr>

                                                    <td><?=$slno?>.</td>

                                                     <td><?=$row->first_name.' '.$row->last_name?></td>
                                                     <td><?=$row->mobile?></td>
                                                     <td><?=$row->address?></td>
                                                     <td>
                                                         <a href="#" class="btn btn-primary">Edit</a>
                                                         <a href="#" class="btn btn-secondary">Delete</a>
                                                     </td>
                                                </tr>

                                         
                                               <? $slno++; } ?> 


                                      
                                        </tbody>

                                    </table>     



                                

                                </div>





                            </div>



                        </div>

                    </div>

                    <!-- Column -->

                </div>

            

              

               