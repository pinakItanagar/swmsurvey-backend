<!-- ============================================================== -->

<!-- Sales Cards  -->
<style>
    .count {

        color:white;
        margin-left:10px;
        font-size:25px;
    }
</style>


<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" id="globalSearchResult">

    </div>
</div>


<div class="row">
    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="box bg-info text-center">
            <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
            <h6 class="text-white">States</h6>
            <a href="#"><h2 class="text-white">(<span class="count">35</span>)</h2></a>
        </div>
    </div>

    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="box bg-danger text-center">
            <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
            <h6 class="text-white">Districts</h6>
            <a href="#"><h2 class="text-white">(<span class="count">718</span>)</h2></a>
        </div>
    </div>

    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="box bg-cyan text-center">
            <h1 class="font-light text-white"><i class="mdi mdi-hospital-building"></i></h1>
            <h6 class="text-white">Medical Colleges</h6>
            <a href="#"><h2 class="text-white">(<span class="count">550</span>)</h2></a>
        </div>
    </div>


</div>





<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" >
        &nbsp;
    </div>
</div>

<div class="row">

    <!-- Column -->

    <div class="col-md-4 col-lg-4 col-xlg-4">

        <div class="card card-hover">

            <div class="box bg-teal2 text-center">

                <h1 class="font-light text-white"><i class="mdi mdi-plus-network"></i></h1>

                <h6 class="text-white">
                    Hospitals - Oxygen emergency<br>
                    <br>
                    ( As on date )
                </h6>

                <a href="#"> <h2 class="text-white">(<span class="count"><?=$oxygenEmergencyCount?></span>)</h2> </a>

            </div>

        </div>

    </div>

    <div class="col-md-4 col-lg-4 col-xlg-4">

        <div class="card card-hover">

            <div class="box bg-danger text-center">

                <h1 class="font-light text-white"><i class="mdi mdi-needle"></i></h1>

                <h6 class="text-white">
                    Hospitals - Urgent Remdesivir requirement<br>
                    <br>
                    ( As on date )
                </h6>

               <a href="#"> <h2 class="text-white">(<span class="count"><?=$remdesivirEmergencyCount?></span>)</h2> </a>

            </div>

        </div>

    </div>






    <div class="col-md-4 col-lg-4 col-xlg-4">

        <div class="card card-hover">

            <div class="box bg-cyan text-center">

                <h1 class="font-light text-white"><i class="mdi mdi-hotel"></i></h1>

                <h6 class="text-white">
                    Available Beds<br>
                    <br>
                    ( As on date )
                </h6>

               <a href="#"> <h2 class="text-white">(<span class="count"><?=$bedCount?></span>)</h2> </a>

            </div>

        </div>

    </div>


</div>



<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" >
        <h2>List of Medical colleges requires oxygen supply in next 4 Hours.
    </div>
</div>


<div class="row">

    <div class="col-md-12 col-lg-12 col-xlg-12">

        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">

                <thead class="bg-primary">

                    <tr>

                        <th width="10%"><span style="color:#fff">slno</span> </th>
                        <th width="10%"><span style="color:#fff">Medical College Name</span></th>
                        <th width="15%" style="text-align: center"><span style="color:#fff; ">Total Covid Patents</span></th>
                        <th width="15%" style="text-align: center"><span style="color:#fff; ">Oxygen remaining </span></th>
                       
                        <th width="10%"><span style="color:#fff">Details </span></th>
                    </tr>

                </thead>



                <tbody>


                 
                            <tr>
                                <td>1</td>
                                <td style="text-align: left">Vardhman Institute of Medical Sciences, Pawapuri, Nalanda</td>
                                <td style="text-align: center">2000</td>
                                <td style="text-align: center">100 Ltrs</td>
                              
                                <td>
                                    <a class="btn btn-sm btn-info" href="#" title="View Details">
                                        View Details
                                    </a>
                                </td>
                            </tr>


                            <tr>
                                <td>2</td>
                                <td style="text-align: left">Shri Shankaracharya Institute of Medical Sciences, Bhilai</td>
                                <td style="text-align: center">1000</td>
                                <td style="text-align: center">60 Ltrs</td>
                              
                                <td>
                                    <a class="btn btn-sm btn-info" href="#" title="View Details">
                                        View Details
                                    </a>
                                </td>
                            </tr>



                            <tr>
                                <td>3</td>
                                <td style="text-align: left">Shaheed Hasan Khan Mewati Government Medical College, Nalhar,Village Nalhar, Post Office Nuh, Mewat</td>
                                <td style="text-align: center">2400</td>
                                <td style="text-align: center">80 Ltrs</td>
                              
                                <td>
                                    <a class="btn btn-sm btn-info" href="#" title="View Details">
                                        View Details
                                    </a>
                                </td>
                            </tr>


                </tbody>

            </table>     

        </div>

    </div>


</div>


<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" >
        &nbsp;
    </div>
</div>







<script type="text/javascript">


    $(document).ready(function () {

      

        $('.count').each(function () {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text()
            }, {
                duration: 1000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });

      

        function runcounter() {

            $('.count').each(function () {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 1000,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        }


       




    });

</script> 












