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

                        <a href="<?=base_url('manageroute/addroute/')?>"  class="btn btn-primary">Add New Route</a>

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

                                <h5 class="card-title">All Route List</h5>



                                <div class="table-responsive">

                                    <table id="zero_config" class="table table-striped table-bordered">

                                        <thead>

                                            <tr>

                                                <th width="10%"># Slno</th>
                                                <th width="35%">Route Name </th>
                                                <th>Action</th> 

                                            </tr>

                                        </thead>



                                        <tbody>

                                               <? $slno = 1; ?>

                                              <?php foreach($allRoutes as $row) { ?>
                                              
                                        
                                      
                                                <tr>

                                                    <td><?=$slno?>.</td>

                                                     <td><?=$row->route_name?></td>

                                               
 
                                                    <td> 

                                                    <div class="row">

                                                        
                                                        

                                                         <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2"> 

                                                            <? if($row->is_start_point == 0) { ?>

                                                              <a href="<?=base_url('manageroute/addstart/'.$row->route_id)?>" alt="Add Start Point" title="Add Start Point" class="btn btn-danger btn-sm" ><i class="fa fa-plus"></i>&nbsp; Add Start Point</a>

                                                             <? } else { ?>

                                                               <a href="<?=base_url('manageroute/editstart/'.$row->route_id)?>" alt="Update Start Point" title="Update Start Point" class="btn btn-success btn-sm" ><i class="fa fa-edit"></i>&nbsp; Update Start Point</a>

                                                             <? } ?>   

                                                         </div>

                                                         <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3"> 
                                                            &nbsp;
                                                         </div>   

                                                         <div class="col-md-2 col-lg-2 col-sm2 col-xs-2"> 
                                                             <? if($row->is_end_point == 0) { ?>

                                                              <a href="<?=base_url('manageroute/addend/'.$row->route_id)?>" alt="Add Start Point" title="Add End Point" class="btn btn-danger btn-sm" ><i class="fa fa-plus"></i>&nbsp; Add End Point</a>

                                                             <? } else { ?>

                                                               <a href="<?=base_url('manageroute/editend/'.$row->route_id)?>" alt="Update Start Point" title="Update End Point" class="btn btn-success btn-sm" ><i class="fa fa-edit"></i>&nbsp; Update End Point</a>

                                                             <? } ?>   
                                                         </div> 


                                                          <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2"> 
                                                            &nbsp;
                                                         </div> 


                                                          <? if(($row->is_start_point == 0) && ($row->is_end_point == 0)) { ?>


                                                         <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2"> 
                                                             <a href="<?=base_url('manageroute/waypoints/'.$row->route_id)?>" alt="Update Start Point" title="Way Points" class="btn btn-info btn-sm" disabled><i class="fa fa-eye"></i>&nbsp;  Way Points</a>
                                                         </div>


                                                         <? } else {  ?>

                                                            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2"> 
                                                             <a href="<?=base_url('manageroute/waypoints/'.$row->route_id)?>" alt="Update Start Point" title="Way Points" class="btn btn-info btn-sm" ><i class="fa fa-eye"></i>&nbsp;  Way Points</a>
                                                         </div>


                                                         <? } ?> 
                                                     

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

            

              

               