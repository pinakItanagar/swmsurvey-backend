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

                        <a href="<?=base_url('manageproperty/addproperty/')?>"  class="btn btn-primary">Add New Property</a>

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

                                <h5 class="card-title">Household Lists</h5>



                                <div class="table-responsive">

                                    <table id="zero_config" class="table table-striped table-bordered">

                                        <thead>

                                            <tr>

                                                <th width="10%"># Slno</th>
                                                <th width="35%">Name </th>
                                                <th width="15%">Mobile </th>
                                                <th width="15%">Ward </th>
                                                <th width="10%">PID </th>
                                                <th width="30%" >Action</th> 

                                            </tr>

                                        </thead>



                                        <tbody>

                                               <? $slno = 1; ?>

                                              <?php foreach($allProperties as $row) {  ?>
                                              
                                                


                                                <? if($row->isUpdate  == 1) { ?>
                                                <tr class="bg-success">
                                                <? } elseif($row->isUpdate  == 2) { ?>   
                                                <tr class="bg-primary">    
                                                <? } else {  ?>
                                                <tr>
                                                <? } ?>

                                                    <td><?=$slno?>.</td>
                                                     <td><?=$row->owner_name?></td>
                                                     <td><?=$row->mobile_no?></td>
                                                     <td><?=$row->ward_no?></td>
                                                     <td><?=$row->pid?></td>
                                                     <td>
                                                        <div class="row">
                                                         <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                                <? if($row->isUpdate  == 1) { ?>
                                                                        <a class="btn btn-sm btn-info" href="<?=base_url('manageproperty/viewsurveyedproperty/').$row->pid; ?>" title="Edit">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                <? } elseif($row->isUpdate  == 2) { ?>
                                                                        <a class="btn btn-sm btn-info" href="<?=base_url('manageproperty/viewunsurveyproperty/').$row->pid; ?>" title="Edit">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                <? } else { ?>
                                                                        
                                                                       <a class="btn btn-sm btn-info" href="<?=base_url('manageproperty/viewproperty/').$row->record_id; ?>" title="Edit">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>


                                                                <? } ?>
                                                            </div> 


                                                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                                <a class="btn btn-sm btn-info" href="<?=base_url('manageproperty/editproperty/').$row->record_id; ?>" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            </div>  
                                                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                                <a class="btn btn-sm btn-danger" href="<?=base_url('manageproperty/validuser/').$row->pid; ?>" data-userid="#" title="Reset">
                                                                    <i class="fa fa-undo"></i>
                                                                </a>
                                                            </div> 
                                                        </div>   
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

            

              

               