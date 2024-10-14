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

                        <a href="<?=base_url('manageroute/addwaypoint/').$route->route_id?>"  class="btn btn-primary">Add New Way Point</a>

                    </div>

                 </div> 

   

                 <div class="row">

                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                        &nbsp;

                    </div>

                 </div> 


                <div class="row">

                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                        <h4><?=$route->route_name?></h4>

                    </div>

                 </div> 


            

                <div class="row">

                    <!-- Column -->

                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                        <div class="card">

                        

                            <div class="card-body">

                                <h5 class="card-title">All Way Point List for <?=$route->route_name?></h5>



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

                                              <?php foreach($allRouteWaypoints as $row) { ?>
                                              
                                        
                                      
                                                <tr>

                                                    <td><?=$slno?>.</td>

                                                     <td><?=$row->landmark_name?></td>

                                               
 
                                                    <td> 

                                                        <div class="row">

                                                             <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2"> 

                                                                  <a href="<?=base_url('manageroute/addstart/'.$route->route_id)?>" alt="Add Way Point" title="Add Way Point"  ><i class="fa fa-plus"></i></a>

                                                             </div>

                                                             <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2"> 

                                                                 <a href="<?=base_url('manageroute/addstart/'.$route->route_id)?>" alt="Update Way Point" title="Update Way Point"  ><i class="fa fa-edit"></i></a>

                                                             </div>   

                                                             <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2"> 

                                                                 <a href="<?=base_url('manageroute/addstart/'.$route->route_id)?>" alt="Remove Way Point" title="Remove Way Point"  ><i class="fa fa-trash"></i></a>
                                                                 
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

            

              

               