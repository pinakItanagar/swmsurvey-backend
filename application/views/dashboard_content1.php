<!-- ============================================================== -->

<!-- Sales Cards  -->
<style>
    .count {

        color:white;
        margin-left:10px;
        font-size:25px;
    }
</style>
<!--
<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12">
        <div class="form-group">
            <div class="input-group mb-3">
            
                <input type="text" class="form-control" name="search" id="search"  placeholder="Search by Owner name / Mobile No / PID / QR Code "  >
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn" name="searchBtn"> <i class="fas fa-search"></i>&nbsp;Search</button>
                </div>
            
            </div>
        </div>
    </div>
</div>
-->

<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" id="globalSearchResult">

    </div>
</div>

<?
$total_target = "226300";
$total_remaining = intval($total_target) - intval($totalSurveyDoneAllWards);
$div_total = $total_remaining / intval($total_target);
$remaining_percentage = $div_total * 100;

$d1 = date("Y-m-d");
$date2 = "2021-05-01";

$date1 = date_create($d1);
$date2 = date_create("2021-06-01");
$diff = date_diff($date1, $date2);




$asking_rate = $remaining_percentage / $diff->days;
$target_number_perday = intval($total_target) * $asking_rate / 100;

$date3 = date_create("2020-12-17");
$date4 = date_create($d1);
$diff = date_diff($date3, $date4);
$total_average = intval($totalSurveyDoneAllWards) / $diff->days;
?>

<div class="row">
    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="box bg-info text-center">
            <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
            <h6 class="text-white">Total Building Footprints</h6>
            <a href="#"><h2 class="text-white">(<span class="count">226300</span>)</h2></a>
        </div>
    </div>

    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="box bg-danger text-center">
            <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
            <h6 class="text-white">Average Installation per day</h6>
            <a href="#"><h2 class="text-white">(<span class="count"><?= $total_average ?></span>)</h2></a>
        </div>
    </div>

    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="box bg-cyan text-center">
            <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
            <h6 class="text-white">Asking rate per day</h6>
            <a href="#"><h2 class="text-white">(<span class="count"><?= $target_number_perday ?></span>)</h2></a>
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

            <div class="box bg-info text-center">

                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>

                <h6 class="text-white">
                    Total Existing Properties<br>
                    <br>
                    ( As on date )
                </h6>

                <a href="#"> <h2 class="text-white">(<span class="count"><?php
                            if (isset($propertiesCount)) {
                                echo $propertiesCount;
                            } else {
                                echo '0';
                            }
                            ?></span>)</h2> </a>

            </div>

        </div>

    </div>

    <div class="col-md-4 col-lg-4 col-xlg-4">

        <div class="card card-hover">

            <div class="box bg-danger text-center">

                <h1 class="font-light text-white"><i class="mdi mdi-clipboard-alert"></i></h1>

                <h6 class="text-white">
                    Pending Survey<br>
                    <br>
                    ( As on date )
                </h6>

                <a href="#"> <h2 class="text-white">(<span class="count"><?php
                            if (isset($pendingPropertiesCount)) {
                                echo $pendingPropertiesCount;
                            } else {
                                echo '0';
                            }
                            ?></span>)</h2> </a>

            </div>

        </div>

    </div>






    <div class="col-md-4 col-lg-4 col-xlg-4">

        <div class="card card-hover">

            <div class="box bg-cyan text-center">

                <h1 class="font-light text-white"><i class="mdi mdi-qrcode-scan"></i></h1>

                <h6 class="text-white">
                    QR Code Installed<br>
                    <br>
                    ( As on date )
                </h6>

                <a href="#"> <h2 class="text-white">(<span class="count"><?php
                            if (isset($totalSurveyDoneAllWards)) {
                                echo $totalSurveyDoneAllWards;
                            } else {
                                echo '0';
                            }
                            ?></span>)</h2> </a>

            </div>

        </div>

    </div>


</div>

<div class="row">
    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="card card-hover">
            <div class="box bg-teal text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
                <h6 class="text-white">
                    Existing Properties Surveyed<br>
                    <br>
                    ( As on date )
                </h6>
                <a href="#"> <h2 class="text-white">(<span class="count"><?= $oldPropertiesSurveyedAllWards ?></span>)</h2> </a>
            </div>
        </div>
    </div>    

    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="card card-hover">
            <div class="box bg-orange text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
                <h6 class="text-white">
                    New Properties Surveyed<br>
                    <br>
                    ( As on date )
                </h6>
                <a href="#"> <h2 class="text-white">(<span class="count"><?= $newPropertiesSurveyedAllWards ?></span>)</h2> </a>
            </div>
        </div>
    </div>  

    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="card card-hover">
            <div class="box bg-success text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
                <h6 class="text-white">
                    Total Survey Done<br>
                    <br>
                    ( As on date )
                </h6>
                <a href="#"> <h2 class="text-white">(<span class="count"><?= $totalSurveyDoneAllWards ?></span>)</h2> </a>
            </div>
        </div>
    </div> 
</div>  


<div class="row">
    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="card card-hover">
            <div class="box bg-myinfo text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
                <h6 class="text-white">
                    Existing Properties Surveyed Today<br>
                    <br>
                    ( <?= $today ?> )
                </h6>
                <a href="#"> <h2 class="text-white">(<span class="count" id="oldPropertySurveyToday"><?= $oldPropertySurveyToday ?></span>)</h2> </a>
            </div>
        </div>
    </div>    

    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="card card-hover">
            <div class="box bg-mycyan text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
                <h6 class="text-white">
                    New Properties Surveyed Today<br>
                    <br>
                    ( <?= $today ?> )
                </h6>
                <a href="#"> <h2 class="text-white">(<span class="count" id="newPropertySurveyedToday"><?= $newPropertySurveyedToday ?></span>)</h2> </a>
            </div>
        </div>
    </div>  

    <div class="col-md-4 col-lg-4 col-xlg-4">
        <div class="card card-hover">
            <div class="box bg-teal2 text-center">
                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
                <h6 class="text-white">
                    Total Survey Done Today<br>
                    <br>
                    ( <?= $today ?> )
                </h6>
                <a href="#"> <h2 class="text-white">(<span class="count" id="totalSurveyToday"  ><?= $totalSurveyToday ?></span>)</h2> </a>
            </div>
        </div>
    </div> 
</div> 
<? if ($magic_figure == 0) { ?>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xlg-12">
            <div id="container" style="width: 100%;">
                <canvas id="canvas"></canvas>
            </div>
        </div>
    </div>
<? } ?>

<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" >
        &nbsp;
    </div>
</div>


<div class="row">

    <div class="col-md-12 col-lg-12 col-xlg-12">

        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">

                <thead class="bg-primary">

                    <tr>

                        <th width="20%"><span style="color:#fff">Circle Name</span> </th>
                        <th width="10%"><span style="color:#fff">Total Wards </span></th>
                       <!-- <th width="15%" style="text-align: center"><span style="color:#fff; ">Total Existing Properties <br>(uploaded data)</span></th>-->
                        <th width="15%" style="text-align: center"><span style="color:#fff; ">Survey Done <br> (As on Date) </span></th>
                        <th width="15%" style="text-align: center"><span style="color:#fff; ">Survey Done <br> (<?= $today ?>) </span></th>
                        <th width="10%"><span style="color:#fff">Details </span></th>
                    </tr>

                </thead>



                <tbody>


                    <?php
                    if (!empty($circles)) {
                        foreach ($circles as $circle) {
                            $circle_id = $circle['circle_id'];
                            ?>
                            <tr>
                                <td><?= $circle['circle_name'] ?></td>
                                <td style="text-align: center"><?= $circle['ttlward'] ?></td>
                                <!--
                                <td style="text-align: center"><?= totalExistingPropertyCircle($circle_id) ?></td>
                                -->
                                <td style="text-align: center"><?= totalSurveyDoneAllCircle($circle_id) ?></td>
                               
                                <? if ($magic_figure > 0) { ?>
                                    <? if (($circle_id == 1) || ($circle_id == 3) || ($circle_id == 5)) { ?>
                                        <td style="text-align: center"><?= totalSurveyDoneTodayCircle($circle_id, $today) + ($magic_figure / 3) ?></td>
                                    <? } else { ?>
                                        <td style="text-align: center"><?= totalSurveyDoneTodayCircle($circle_id, $today) ?></td>
                                    <? } ?>
                                <? } else { ?>
                                    <td style="text-align: center"><?= totalSurveyDoneTodayCircle($circle_id, $today) ?></td>
                                <? } ?>
                          
                                <td>
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url('dashboard/viewward/') . $circle_id; ?>" title="View Wardlist">
                                        View Ward List
                                    </a>
                                </td>
                            </tr>


                            <?php
                        }
                    }
                    ?>



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

<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" >
        <h3>Active Ward Survey Mapping</h3>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <!-- MAP SPACE -->
            <div id="mymap" style="height: 500px; width:100%"></div>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" >
        <h4>Click over any active survey ward listed below</h4>
    </div>
</div>



<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" >

        <div class="container">
            <div class="row">

                <? foreach ($activeWards as $ward) { ?>
                    <div class="col-sm">
                        <div style="background-color:<?=trim($ward->ward_color)?>; width:150px; height:60px; padding-top:10px; text-align: center; border: 3px solid black;"  >
                            <? if ($ward->ward_no == "22A") { ?>
                                <button type="button" class="btn btn-secondary" onclick="displayWard('22A');">Ward No. 22A </button>
                            <? } elseif ($ward->ward_no == "22B") { ?>
                                <button type="button" class="btn btn-secondary" onclick="displayWard('22B');">Ward No. 22B </button>
                            <? } elseif ($ward->ward_no == "22C") { ?>
                                <button type="button" class="btn btn-secondary" onclick="displayWard('22C');">Ward No. 22C </button>
                            <? } else { ?>
                                <button type="button" class="btn btn-secondary" onclick="displayWard(<?= trim($ward->ward_no) ?>);">Ward No. <?= trim($ward->ward_no) ?> </button>
                            <? } ?>
                        </div> 
                    </div>    
                <? } ?>

            </div>
        </div>

    </div>
</div>




<div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="myModalLabel">Loading Ward detail on map</h3>

            </div>
            <div class="modal-body">
                <div align="center"><img src="<?= base_url("images/infinity.gif") ?>"></div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    var img = "";
    var wardArray = [];
    var ward_color = "";
    var ward_boundary_geojson = "";
    var wno = "";
    var  vendor_name = "" ;
    var  total_footprint = "" ;
    var total_survey = 0;
    var total_survey_today = 0;
    
    
    document.getElementById('mymap').style.cursor = 'pointer';
    function polystyle(wardColor) {
        var fillcolor;
        fillcolor = wardColor;
        return {
            fillColor: fillcolor,
            weight: 2,
            opacity: 1,
            color: fillcolor, //Outline color
            fillOpacity: 0.50
        };
    }





    var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3']});
    google = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3']});


    var latitude = 25.60394584897514;
    var longitude = 85.12792674813649;
    var geojsonFeature = <?= $patna ?>;
    


    var baseLayers = {
        "Map View": osm,
        "Satellite View": google
    };

    var map = L.map('mymap', {
        layers: [google],
        fullscreenControl: {
            pseudoFullscreen: false
        }
    }).setView([latitude, longitude], 12);

    L.control.layers(baseLayers).addTo(map);
    L.geoJSON(geojsonFeature).addTo(map);


    function displayWard(ward_no) {
       $("#myModal2").modal("show");
       $('#globalSearchResult').html("");
       
        var my_url = '<?= base_url("dashboard/getWardMapDetails/") ?>' + ward_no;
        $.ajax({
            url: my_url,
            type: 'POST',
            dataType: 'json',
            success: function (response) {

                ward_color = response['ward_color'];

                ward_boundary_geojson = response['ward_boundary'];
                ward_no = response['ward_no'];
                vendor_name = response['vendor_name'];
                total_footprint = response['total_footprint'];
                total_survey = response['total_survey'];
                total_survey_today = response['total_survey_today'];
                
               


                wno = ward_boundary_geojson;
                ward_name = wno.features[0].properties.WRD_NAME.trim();
                coordinates = wno.features[0].geometry.coordinates[0];
                var polygon = L.polygon(coordinates);
                var bounds = polygon.getBounds();
                var midpoint = bounds.getCenter();

                if (ward_name == "Ward29") {
                    var lat = 25.599392388722734;
                    var lng = 85.14005484795288;
                } else if (ward_name == "Ward31") {
                    var lat = 25.591807536376965;
                    var lng = 85.14220352072398;
                } else if (ward_name == "Ward44") {
                    var lat = 25.598400179536405;
                    var lng = 85.16116393326485;
                } else if (ward_name == "Ward35") {
                    var lat = 25.602369252009836;
                    var lng = 85.15050196188808;
                } else if (ward_name == "Ward45") {
                    var lat = 25.59288282626468;
                    var lng = 85.16550283504785;
                } else if (ward_name == "Ward32") {
                    var lat = 25.58610767866303;
                    var lng = 85.1493074707407;
                } else {
                    var lat = midpoint.lng;
                    var lng = midpoint.lat;
                }
                
                


                var url = "<?= base_url('dashboard/overallwardinfo/') ?>" + ward_no;

                if(wardArray.indexOf(ward_no) !== -1){
                  
                }  else {
                   wardArray.push(ward_no); 
                  L.geoJSON(ward_boundary_geojson, {style: polystyle(ward_color)}).addTo(map);
                
                }
                

               
                var marker = new L.marker([lat, lng]); //opacity may be set to zero
                marker.bindTooltip(ward_name, {permanent: true,  offset: [0, 0] }).bindPopup("Vendor Name : " + vendor_name + "<br> Available Building Footprints : " + total_footprint + "<br> As on date QR Code installed : " + total_survey + "<br> QR Code installed Today : " + total_survey_today + '<br><a href="'+ url + '">View Survey Details</a>'  );
                marker.addTo(map);

            },
            complete: function () {
               $("#myModal2").modal("hide");
            }
        });

    }

</script>




<script type="text/javascript">


    $(document).ready(function () {

        $("#dialog").dialog({
            autoOpen: false,
            modal: true,
            title: "Details",
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });

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

        /*
         function update() {
         $.get("response.php", function(data) {
         $("#some_div").html(data);
         window.setTimeout(update, 10000);
         });
         }*/


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


        function update() {
            $.ajax({
                url: '<?= base_url("dashboard/getfigures") ?>',
                type: 'POST',
                dataType: 'json',
                success: function (response) {

                    $('#totalSurveyToday').html(response['totalSurveyToday']);
                    $('#newPropertySurveyedToday').html(response['newPropertySurveyedToday']);
                    $('#oldPropertySurveyToday').html(response['oldPropertySurveyToday']);
                    runcounter();

                },
                complete: function (response) {
                    window.setTimeout(update, 50000);
                }
            });
        }

        //  update();




    });

</script> 


<script>
    var weekdata = '<?= $weekdata ?>';
    var obj = JSON.parse(weekdata);
    var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var label = [];
    var surveydata = [];
    //alert(obj.week_date[0]);
    //alert(obj[0].total);
    for (var i = 0; i < obj.week_date.length; i++) {
        label.push(obj.week_date[i]);
        surveydata.push(obj.daily_data[i]);
    }

    var color = Chart.helpers.color;
    var barChartData = {
        labels: label,
        datasets: [{
                label: 'Survey done ',
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: surveydata
            }]

    };

    window.onload = function () {
        var ctx = document.getElementById('canvas').getContext('2d');
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Weekly QR Code installation Status'
                }
            }
        });

    };



    var colorNames = Object.keys(window.chartColors);


    /*
     document.getElementById('addData').addEventListener('click', function() {
     if (barChartData.datasets.length > 0) {
     var month = MONTHS[barChartData.labels.length % MONTHS.length];
     barChartData.labels.push(month);
     
     for (var index = 0; index < barChartData.datasets.length; ++index) {
     // window.myBar.addData(randomScalingFactor(), index);
     barChartData.datasets[index].data.push(randomScalingFactor());
     }
     
     window.myBar.update();
     }
     });*/

    /*
     
     document.getElementById('removeDataset').addEventListener('click', function() {
     barChartData.datasets.pop();
     window.myBar.update();
     });
     
     document.getElementById('removeData').addEventListener('click', function() {
     barChartData.labels.splice(-1, 1); // remove the label first
     
     barChartData.datasets.forEach(function(dataset) {
     dataset.data.pop();
     });
     
     window.myBar.update();
     });*/
</script>


















