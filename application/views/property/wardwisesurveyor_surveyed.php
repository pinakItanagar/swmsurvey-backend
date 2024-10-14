

<div class="row">

    <div class="col-md-12 col-lg-12 col-xlg-12">

        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">

                <thead class="bg-primary">

                    <tr>

                        <th width="20%"><span style="color:#fff">Circle Name</span> </th>
                        <th width="10%"><span style="color:#fff">Ward No. </span></th>
                        <th width="10%"><span style="color:#fff">Details </span></th>
                    </tr>

                </thead>



                <tbody>


                    <?php
                    if (!empty($wards)) {
                        foreach ($wards as $ward) {
                            $ward_no = $ward['ward_no'];
                            
                            ?>
                            <tr>
                                <td><?= $ward['circle'] ?></td>
                                <td style="text-align: center"><?= $ward['ward_no'] ?></td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url('manageproperty/totalsurveyorsurveyed/') . $ward_no; ?>" title="View Wardlist">
                                        Wardwise Surveyor QR Installed
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

    });

</script> 


<script>
        var weekdata = '<?=$weekdata?>';
        var obj = JSON.parse(weekdata);
        var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var label = [];
        var surveydata = [];
        //alert(obj[0].total);
        for (var i = 0; i < obj.length; i++) {
           label.push(obj[i].date); 
           surveydata.push(obj[i].total); 
        }
         
        var color = Chart.helpers.color;
        var barChartData = {
                labels: label,
                datasets: [ {
                        label: 'Survey done ',
                        backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                        borderColor: window.chartColors.blue,
                        borderWidth: 1,
                        data: surveydata
                }]

        };

        window.onload = function() {
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

        document.getElementById('randomizeData').addEventListener('click', function() {
                var zero = Math.random() < 0.2 ? true : false;
                barChartData.datasets.forEach(function(dataset) {
                        dataset.data = dataset.data.map(function() {
                                return zero ? 0.0 : randomScalingFactor();
                        });

                });
                window.myBar.update();
        });

        var colorNames = Object.keys(window.chartColors);
        document.getElementById('addDataset').addEventListener('click', function() {
                var colorName = colorNames[barChartData.datasets.length % colorNames.length];
                var dsColor = window.chartColors[colorName];
                var newDataset = {
                        label: 'Dataset ' + (barChartData.datasets.length + 1),
                        backgroundColor: color(dsColor).alpha(0.5).rgbString(),
                        borderColor: dsColor,
                        borderWidth: 1,
                        data: []
                };

                for (var index = 0; index < barChartData.labels.length; ++index) {
                        newDataset.data.push(randomScalingFactor());
                }

                barChartData.datasets.push(newDataset);
                window.myBar.update();
        });

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
        });
</script>


















