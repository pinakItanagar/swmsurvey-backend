






<div class="row pull-right">

    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 pull-right">

        <a href="<?= base_url('footprintreport/downloadxls/'.$date) ?>"  class="btn btn-primary">Download as XLS</a>

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

                <h5 class="card-title">Report - <?=$date?> </h5>



                <div class="table-responsive">

                    <table id="zero_config" class="table table-striped table-bordered">

                        <thead>

                            <tr>

                                <th width="10%"># Slno</th>
                                <th width="10%">Ward No </th>
                                <th width="15%">Vendor </th>
                                <th width="15%">Total Available <br> building foot print </th>
                                <th width="15%">Total Installed <br> QR Code <br> As on Date </th>
                                <th width="15%">Total Installed <br> QR Code <br> Today </th>
                                <th width="10%">Pending </th>

                            </tr>

                        </thead>



                        <tbody>

                            <? $slno = 1; ?>

                            <?php foreach ($reports as $row) { ?>


                            <td><?= $slno ?>.</td>
                            <td><?= $row->ward_no ?></td>
                            <td><?= $row->vendor_name ?></td>
                            <td><?= $row->total_footprint ?></td>
                            <td><?= $row->total_qrcode_installed ?></td>
                            <td><?= $row->total_qrcode_installed_today ?></td>
                            <td><?= $row->pending_installation ?></td>
                            </tr>


                            <? $slno++;
                        } ?> 



                        </tbody>

                    </table>     





                </div>





            </div>



        </div>

    </div>

    <!-- Column -->

</div>





