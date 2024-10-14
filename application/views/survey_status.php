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



                <?= $this->session->flashdata('APPMSG') ?>

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
                                <th width="25%">Apartment/Owner Name</th>
                                <th width="15%">Property Type </th>
                                <th width="15%">PID </th>
                                <th width="10%">QR Code </th>

                                <!--<th width="20%">Survey Date </th>-->
                                <th width="15%">Action</th>  

                            </tr>

                        </thead>



                        <tbody>

                            <? $slno = 1; ?>

                            <?php foreach ($allProperties as $row) { ?>
                            
                            
                                    <?
                                        if ($row->isnew == '1') {
                                            if ($row->isflat == '1') {
                                                $name = strtoupper($row->flatName);
                                                $mob = "Not Applicable";
                                            } else {
                                                $name = strtoupper($row->owner_name);
                                                $mob = $row->mobile_no;
                                            }
                                        }


                                               $dt_array = explode(" ", $row->date_updated);
                                                if($dt_array[0] > '2021-03-10' ) {
                                                  $img_storage = 0 ;
                                                } else {
                                                  $img_storage = 1 ;  
                                                }
                                    ?>

                                    <tr>
                                        

                                    <td><?= $slno ?>.</td>
                                    <td><?= $name ?><br>Contact : <?=$mob?></td>
                                     <td>
                                        <? if ($row->isflat == '1') { ?>
                                        Apartment/Flat
                                        <? } else { ?>
                                        Individual
                                        <? } ?>
                                    </td> 
                                    
                                 
                                    
                                 
                                      
                                    <td><?= $row->pid ?></td>
                                    <td><?= $row->qr_code ?></td>
                                    <!--<td><?= $row->date_updated ?></td>-->
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                <? if (isset($row->p_record_id)) { ?>
                                                    <a class="btn btn-sm btn-success" href="<?= base_url('dashboard/viewnewproperty/') . $row->pid.'/'.$img_storage; ?>" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                <? } else { ?>

                                                    <a class="btn btn-sm btn-info" href="#" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>


                                                <? } ?>
                                            </div> 
                                            
                                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                
                                                <? if ($row->isflat == '1') { ?>
                                              
                                                    <a class="btn btn-sm btn-info" href="<?= base_url('manageproperty/updateNewPropertyFlat/') . $row->pid; ?>" title="View">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                
                                                <? } elseif($row->isflat == '0') { ?>
                                                     <a class="btn btn-sm btn-info" href="<?= base_url('manageproperty/updateNewPropertyIndividual/') . $row->pid; ?>" title="View">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                
                                                <? } ?>
                                             
                                            </div> 
                                            
                                            <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                                                
                                                <? if ($row->isflat == '1') { ?>
                                              
                                                    <a class="btn btn-sm btn-info" href="<?= base_url('manageproperty/deleteApartment/') . $row->pid; ?>" title="View">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                
                                                <? } elseif($row->isflat == '0') { ?>
                                                     <a class="btn btn-sm btn-info" href="<?= base_url('manageproperty/deleteIndividual/') . $row->pid; ?>" title="View">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                
                                                <? } ?>
                                             
                                            </div> 
                                        </div>   
                                    </td>
                                </tr>


                                <? $slno++;
                            }
                            ?> 



                        </tbody>

                    </table>     


                </div>

            </div>

        </div>

    </div>

    <!-- Column -->

</div>





