<style>
    .count {
      
      color:white;
      margin-left:10px;
      font-size:25px;
   }
   
   .legend {
        padding: 6px 8px;
        font: 14px Arial, Helvetica, sans-serif;
        background: white;
       
        /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
        /*border-radius: 5px;*/
        line-height: 24px;
        color: #555;
      }
      .legend h4 {
        text-align: center;
        font-size: 16px;
        margin: 2px 12px 8px;
        color: #777;
      }

      .legend span {
        position: relative;
        bottom: 3px;
      }

      .legend i {
        width: 18px;
        height: 18px;
        float: left;
        margin: 0 8px 0 0;
        opacity: 0.7;
      }

      .legend i.icon {
        background-size: 18px;
        background-color: rgba(255, 255, 255, 1);
      }
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <h3>SWM QR code installation survey report <?= ucwords(strtolower($circle->circle_name)) ?> Circle - Ward No <?= $ward_no ?> </h3>

                        </div>
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
                    <div class="col-lg-12">
                        <h6> Survey Status for <?= ucwords(strtolower($circle->circle_name)) ?> Circle - ward No <?= $ward_no ?> </h6>
                    </div>    
                </div>    


                <div class="row">
                    <div class="col-md-4 col-lg-4 col-xlg-4">
                        <div class="card card-hover">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
                                <h6 class="text-white">
                                    Existing Properties Surveyed<br>
                                    <br>
                                    ( As on date )
                                </h6>
                                <a href="#"> <h2 class="text-white">(<span class="count"><?= $total_existing_survey_done ?></span>)</h2> </a>
                            </div>
                        </div>
                    </div>    

                    <div class="col-md-4 col-lg-4 col-xlg-4">
                        <div class="card card-hover">
                            <div class="box bg-cyan text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
                                <h6 class="text-white">
                                    New Properties Surveyed<br>
                                    <br>
                                    ( As on date )
                                </h6>
                                <a href="#"> <h2 class="text-white">(<span class="count"><?= $total_new_survey_done ?></span>)</h2> </a>
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
                                <a href="#"> <h2 class="text-white">(<span class="count"><?= $total_survey_done ?></span>)</h2> </a>
                            </div>
                        </div>
                    </div> 
                </div>  


                <div class="row">
                    <div class="col-lg-12">
                        <h6> Today's Survey Status for <?= ucwords(strtolower($circle->circle_name)) ?> Circle - ward No. <?= $ward_no ?>  </h6>
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
                                    (<?= $today_date ?>)
                                </h6>
                                <a href="#"> <h2 class="text-white">(<span class="count"><?= $today_existing_survey_done ?></span>)</h2> </a>
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
                                    (<?= $today_date ?>)
                                </h6>
                                <a href="#"> <h2 class="text-white">(<span class="count"><?= $today_total_new_survey_done ?></span>)</h2> </a>
                            </div>
                        </div>
                    </div>  

                    <div class="col-md-4 col-lg-4 col-xlg-4">
                        <div class="card card-hover">
                            <div class="box bg-purple text-center">
                                <h1 class="font-light text-white"><i class="mdi mdi-home-modern"></i></h1>
                                <h6 class="text-white">
                                    Total Survey Done<br>
                                    <br>
                                    (<?= $today_date ?>)
                                </h6>
                                <a href="#"> <h2 class="text-white">(<span class="count"><?= $today_total_survey_done ?></span>)</h2> </a>
                            </div>
                        </div>
                    </div> 
                </div>  
            </div>
        </div>    
    </div>
</div>  


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <div class="card-body">

               

           

                <div class="row">
                    <div class="col-lg-12">
                        <h6>Today's Individual Surveyors report for <?= ucwords(strtolower($circle->circle_name)) ?> Circle - ward No <?= $ward_no ?> </h6>
                    </div>    
                </div>    
                
                
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">

                            <table id="zero_config" class="table table-striped table-bordered">

                                <thead>

                                    <tr>

                                        <th width="10%"># Slno</th>
                                        <th width="35%">Surveyor Name</th>
                                        <th width="15%">Total Done</th>

                                    </tr>

                                </thead>



                                <tbody>

                                    <? $slno = 1; ?>

                                    <?php foreach ($individual_survey as $row) { ?>
   

                                        <tr>


                                            <td><?= $slno ?>.</td>
                                            <td><?=$row->first_name?>&nbsp;<?=$row->last_name?></td>
                                            <td><?= $row->total_done?></td>
                                          
                                            
                                        </tr>


                                        <?
                                        $slno++;
                                    }
                                    ?> 



                                </tbody>
				
                            </table>     


                        </div>
                    </div>    
                </div>


           
            </div>
        </div>    
    </div>
</div>  
    
    
<script type="text/javascript">

  

   document.getElementById('mymap').style.cursor = 'pointer';
   
    var redIcon = new L.Icon({
        iconUrl: '<?=base_url('images/red.png')?>',
        shadowUrl: '<?=base_url('images/marker-shadow.png')?>',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });
   
    var greenIcon = new L.Icon({
        iconUrl: '<?=base_url('images/green.png')?>',
        shadowUrl: '<?=base_url('images/marker-shadow.png')?>',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

/*
   var greenIcon = L.icon({
        iconUrl: '<?=base_url('images/map_pin.png')?>',
        iconSize:     [22, 20]
   });
    */

        <? if($property_today != "") { ?>
          var locations_today = '<?=$property_today?>' ;
        <? } ?>
        var locations = '<?=$property_last?>' ;
        
        var obj = JSON.parse(locations);
        <? if($isWardBoundary == '1' ) { ?>
         var geojsonFeature = <?=$ward_boundary?>;
        <? } ?>
        
       
        
        
       // var osm = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"),
        //    google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 20,  subdomains:['mt0','mt1','mt2','mt3'] });
        
        
         var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']});
           google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 20,  subdomains:['mt0','mt1','mt2','mt3'] });

        
        var baseLayers = {
            "Map View": osm,
            "Satellite View": google
        };
        
     
       if(parseInt(locations.length) > 2) {
       
       /*
        var map = L.map('mymap', {
                        center: [obj[0].latitude, obj[0].longitude],
                        zoom: 15,
                        layers: [google]
                    });*/
        
        var map = L.map('mymap', {
                        layers: [google],
                        fullscreenControl: {
                            pseudoFullscreen: false
                        }
                       }).setView([obj[0].latitude, obj[0].longitude], 15);
        
        L.control.layers(baseLayers).addTo(map);
        } else {
            var objtemp = JSON.parse(locations_today);
            
             var map = L.map('mymap', {
                            layers: [google],
                            fullscreenControl: {
                                pseudoFullscreen: false
                            }
                        }).setView([objtemp[0].latitude, objtemp[0].longitude], 15);
              
              /*
              var map = L.map('mymap', {
                        center: [objtemp[0].latitude, objtemp[0].longitude],
                        zoom: 15,
                        layers: [google]
                    });*/
        
        L.control.layers(baseLayers).addTo(map);
           
        } 

      /*
       var mymap = L.map('mapid').setView([obj[0].latitude, obj[0].longitude], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors', maxZoom: 20
       }).addTo(mymap);
      */
        
       // var attribute = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors' ;
        
       // var mapbaseLayer1 = 'http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}' ;
       var mapbaseLayer2 = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png' ;
        
        
     
       // var mymap = L.map('mapid').setView([obj[0].latitude, obj[0].longitude], 15);
        //  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors', maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']
       //  }).addTo(mymap);
         
       /*  
         var mymap = L.map('mapid').setView([obj[0].latitude, obj[0].longitude], 15);
        L.tileLayer(mapbaseLayer2, {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors', maxZoom: 20
       }).addTo(mymap);
       */
        var gps_accuracy  = 0;
        var url = "";
        for (var i = 0; i < obj.length; i++) {
            
          gps_accuracy = parseFloat(obj[i].gpsaccuracy).toFixed(2) ; 
            
          if(obj[i].isflat == '1') {  
            url = "<?=base_url('manageproperty/viewapartment/')?>" + obj[i].pid;
            var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ], {icon: redIcon})
            .bindPopup('PID : '+ obj[i].pid + '<br>Property Type : Apartment<br>Address : ' + obj[i].address_street + '<br>GPS Accuracy : ' + gps_accuracy + ' Mtrs. <br>Survey Date/Time : ' + obj[i].date_updated + '<br><a href="'+ url + '">View Aparment Details</a>' )
            .addTo(map);  
          } else {
             url = "<?=base_url('manageproperty/viewindividualproperty/')?>" + obj[i].pid;
              var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ])
            .bindPopup('PID : '+ obj[i].pid + '<br>Property Type : Land + Building<br>Owner Name : ' + obj[i].owner_name + '<br>Address : ' + obj[i].address_street + '<br>GPS Accuracy : ' + gps_accuracy + ' Mtrs. <br>Survey Date/Time : ' + obj[i].date_updated  + '<br><a href="'+ url + '">View Property Details</a>')
            .addTo(map);  
          }
        }
        
        
        <? if($property_today != "") { ?>
            
            var obj = JSON.parse(locations_today);
          
            for (var i = 0; i < obj.length; i++) {

              gps_accuracy = parseFloat(obj[i].gpsaccuracy).toFixed(2) ; 

              if(obj[i].isflat == '1') {  
                url = "<?=base_url('manageproperty/viewapartment/')?>" + obj[i].pid;  
                var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ], {icon: greenIcon})
                .bindPopup('PID : '+ obj[i].pid + '<br>Property Type : Apartment<br>Address : ' + obj[i].address_street + '<br>GPS Accuracy : ' + gps_accuracy + ' Mtrs. <br>Survey Date/Time : ' + obj[i].date_updated + '<br><a href="'+ url + '">View Aparment Details</a>' )
                .addTo(map);  
              } else {
                  url = "<?=base_url('manageproperty/viewindividualproperty/')?>" + obj[i].pid;
                  var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ], {icon: greenIcon})
                .bindPopup('PID : '+ obj[i].pid + '<br>Property Type : Land + Building<br>Owner Name : ' + obj[i].owner_name + '<br>Address : ' + obj[i].address_street + '<br>GPS Accuracy : ' + gps_accuracy + ' Mtrs. <br>Survey Date/Time : ' + obj[i].date_updated + '<br><a href="'+ url + '">View Property Details</a>' )
                .addTo(map);  
              }
            }
            
        <? } ?>   
            
        
        <? if($isWardBoundary == '1' ) { ?>
           L.geoJSON(geojsonFeature).addTo(map);
         <? } ?>
    
       /* 
        for (var i = 0; i < objBoundary.length; i++) {
            
            
            
            var circle = new  L.circle([objBoundary[i].lng, objBoundary[i].lat], {
                color: "red",
                fillColor: "#f03",
                fillOpacity: 0.5,
                radius: 1
            }).addTo(map);
            
          
        } 
        
        */
       
        var legend = L.control({position: 'bottomright'});

	legend.onAdd = function(map) {
            var div = L.DomUtil.create("div", "legend");
            div.innerHTML += "<h4>Survey Legends</h4>";
           // div.innerHTML += '<i style="background: #477AC2"></i><span>Previous Survey Points</span><br>';
            div.innerHTML += '<i style="background: #2AAD27"></i><span>Today\'s Survey Points</span><br>';
            div.innerHTML += '<i style="background: #CB2B3E"></i><span>Apartment\s survey points</span><br>';
            div.innerHTML += '<i style="background: #2A81CB"></i><span>Land + Building survey points</span><br>';
            //div.innerHTML += '<img src="<?=base_url('images/blue.png')?>" width="7%">&nbsp;<span >Previous Survey Points</span><br>';
            //div.innerHTML += '<img src="<?=base_url('images/green.png')?>" width="7%">&nbsp;<span >Today\'s Survey Points</span><br>';

            return div;
          };

	legend.addTo(map);

  

</script>      






<script type="text/javascript">

    
    $(document).ready(function () {

        $('.count').each(function () {
            $(this).prop('Counter',0).animate({
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