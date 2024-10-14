
<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('save')) { ?>

                <div class="alert alert-success"> <?= $this->session->flashdata('save') ?> </div>

            <?php } ?>

            <!-- start white-box -->

            <form id="myform" action="<?= base_url('manageroute/save') ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h3>Patna City Map</h3>
                             
                            </div>
                        </div>
                    </div>

                    


                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Route Name</label>
                                  <input type="text" class="form-control" name="route_name" id="route_name" placeholder="Enter route name here" required>
                            </div>
                        </div>
                    </div> 





                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary" >Submit</button>
                        </div>
                    </div>



            </form>


        </div>
    </div>
</div>  


 

       