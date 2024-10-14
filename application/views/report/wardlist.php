
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
                            <h3>Active Ward List</h3>

                        </div>
                    </div>
                </div>




                <div class="row">
                    <div class="col-lg-12 col-md-12 ">

                        <div class="table-responsive">

                            <table id="zero_config" class="table table-striped table-bordered">

                                <thead>

                                    <tr>

                                        <th width="10%"># Slno</th>
                                        <th width="10%">Ward No </th>
                                        <th width="10%">Total Footprints </th>
                                        <th width="15%">GIS Data </th>
                                       
                                    </tr>

                                </thead>



                                <tbody>

                                    <? $slno = 1; ?>

                                    <?php foreach ($wards as $row) { ?>


                                    <td><?= $slno ?>.</td>
                                    <td><?=$row->ward_no?></td>
                                    <td><?=$row->total_footprints?></td>
                                    <td><a class="btn btn-primary" href="<?=base_url("generalreport/downloadxls/".$row->ward_no)?>" role="button">Download XLS</a></td>
                                   
                                    </tr>


                                    <? $slno++;     } ?>


                                </tbody>

                            </table>     





                        </div>

                    </div>

                </div>







            </div>
        </div>
    </div>  

