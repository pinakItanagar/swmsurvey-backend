






<div class="row pull-right">

    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="float:right;">
     
        <a href="<?= base_url('armsensor/downloadxls/'.$date) ?>"  class="btn btn-primary">Download as XLS</a>

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

             



                <div class="table-responsive">

                    <table id="zero_config" class="table table-striped table-bordered">

                        <thead>

                            <tr>

                                <th width="10%"># Slno</th>
                                <th width="15%">Start Time </th>
                                <th width="15%">End Time </th>
                                <th width="5%">X</th>
                                <th width="5%">Y</th>
                                <th width="5%">Z</th>
                                <th width="20%">Arm Movement Detected </th>

                            </tr>

                        </thead>



                        <tbody>

                            <? $slno = 1; ?>

                            <?php for($i=0; $i<count($reports); $i++) { ?>


                            <td><?= $slno ?>.</td>
                             <td><?= $reports[$i]['end_time'] ?></td>
                            <td><?= $reports[$i]['start_time']?></td>
                           
                            <td><?= $reports[$i]['x'] ?></td>
                            <td><?= $reports[$i]['y'] ?></td>
                            <td><?= $reports[$i]['z'] ?></td>
                            <td><?= $reports[$i]['arm_movement'] ?></td>
                            </tr>


                            <? $slno++; $i++; } ?> 



                        </tbody>

                    </table>     





                </div>





            </div>



        </div>

    </div>

    <!-- Column -->

</div>





