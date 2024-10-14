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
      
           #mymap {
            height: 100%;
            width: 100%;
        };
        
        .modal-dialog {
 
          height:100%;
          width:100%;
 
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
                    <div class="col-lg-12" id="misspointSearchResult">
                      
                    </div>
                </div>
                
                
                <div class="row">
                    
                    <div class="col-lg-6">
                        <a href="#" class="btn btn-lg btn-primary" onClick = "document.getElementById('mymap').style.height = '100%';">Show Default Modal</a>
                    </div>
                    
                    <div class="col-lg-6">
                        <input type="hidden" name="ward_no" id="ward_no" value="<?=$ward_no?>" >
                       <div class="float-lg-right float-md-right"><button type="button" class="btn btn-primary" id="savePoints">Save missed points</button></div>
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
    
         
         var missedpoints = new Array();
         var temp_missedpoints = new Array();

         var globalmarker = new Array();
     
        var locations = '<?=$property_last?>' ;
        var obj = JSON.parse(locations);
        
        <? if($isWardBoundary == '1' ) { ?>
         var geojsonFeature = <?=$ward_boundary?>;
         var geojsonBuildingFeature = <?=$building?>;
        <? } ?>
        
        <? if($missed_point_exist == '1' ) { ?>
             var missed_locations = '<?=$all_missed_points?>' ;
        <? } ?>    
            
            
            function polystyle() {
                return {
                    fillColor: 'red',
                    weight: 2,
                    opacity: 1,
                    color: 'black',  //Outline color
                    fillOpacity: 0.10
                };
            }
        
       
         var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']});
           google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 20,  subdomains:['mt0','mt1','mt2','mt3'] });

        
        var baseLayers = {
            "Map View": osm,
            "Satellite View": google
        };
        
       
        var map = L.map('mymap', {
                        center: [obj[0].latitude, obj[0].longitude],
                        zoom: 15,
                        layers: [google]
                    });
        
        L.control.layers(baseLayers).addTo(map);

       
        var gps_accuracy  = 0;
        var url = "";
        for (var i = 0; i < obj.length; i++) {
            
          gps_accuracy = parseFloat(obj[i].gpsaccuracy).toFixed(2) ; 
            
          if(obj[i].isflat == '1') {  
            url = "<?=base_url('manageproperty/viewapartment/')?>" + obj[i].pid;
            var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ],  {icon: greenIcon})
            .bindPopup('PID : '+ obj[i].pid + '<br>Property Type : Apartment<br>Address : ' + obj[i].address_street + '<br>GPS Accuracy : ' + gps_accuracy + ' Mtrs. <br>Survey Date/Time : ' + obj[i].date_updated + '<br><a href="'+ url + '">View Aparment Details</a>' )
            .addTo(map);  
          } else {
             url = "<?=base_url('manageproperty/viewindividualproperty/')?>" + obj[i].pid;
              var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ], {icon: greenIcon})
            .bindPopup('PID : '+ obj[i].pid + '<br>Property Type : Land + Building<br>Owner Name : ' + obj[i].owner_name + '<br>Address : ' + obj[i].address_street + '<br>GPS Accuracy : ' + gps_accuracy + ' Mtrs. <br>Survey Date/Time : ' + obj[i].date_updated  + '<br><a href="'+ url + '">View Property Details</a>')
            .addTo(map);  
          }
        }
        
        
        
     
        
       
            
        
        <? if($isWardBoundary == '1' ) { ?>
           L.geoJSON(geojsonFeature).addTo(map);
            L.geoJSON(geojsonBuildingFeature , {style: polystyle}).addTo(map);
         <? } ?>
    
     
        var legend = L.control({position: 'bottomright'});

	legend.onAdd = function(map) {
            var div = L.DomUtil.create("div", "legend");
            div.innerHTML += "<h4>Survey Legends</h4>";
          
            div.innerHTML += '<i style="background: #2AAD27"></i><span>All survey points done</span><br>';
            div.innerHTML += '<i style="background: #2A81CB"></i><span>Missed point already added</span>';
           
            return div;
          };

	legend.addTo(map);
        
        
           <? if($missed_point_exist == '1' ) { ?>
    
             var obj_misses_location = JSON.parse(missed_locations);
             
             for (var x = 0; x < obj_misses_location.length; x++) {
                 
             
                    var removeURL =   "javascript:void(0); removePoint(" + obj_misses_location[x].missed_lat + "," + obj_misses_location[x].missed_lng + "," + x  + ");" ;
                    var newMarker = new L.marker([obj_misses_location[x].missed_lat , obj_misses_location[x].missed_lng]).bindPopup('Lat : ' +  obj_misses_location[x].missed_lat + ' / Lng : ' + obj_misses_location[x].missed_lng  + '<br><a href="'+ removeURL + '">Remove Point</a>'  ).addTo(map);
                    missedpoints.push([obj_misses_location[x].missed_lat,obj_misses_location[x].missed_lng, 1]);
                    globalmarker.push(newMarker);
                    map.addLayer(globalmarker[x]);
                 
             }
            
        <? } ?>   
        
        
         map.on('click', function(e) {
            //alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
            //$("#latitude").val(e.latlng.lat);
            //$("#longitude").val(e.latlng.lng);
              var i = parseInt(globalmarker.length);
             
              var removeURL =   "javascript:void(0); removePoint(" + e.latlng.lat + "," + e.latlng.lng + "," + i  + ");" ;
              var newMarker = new L.marker(e.latlng, {icon: redIcon}).bindPopup('Lat : ' +  e.latlng.lat + ' / Lng : ' + e.latlng.lng  + '<br><a href="'+ removeURL + '">Remove Point</a>'  ).addTo(map);
              missedpoints.push([e.latlng.lat,e.latlng.lng, 1]);
              globalmarker.push(newMarker);
              map.addLayer(globalmarker[i]);
         });
         
         
         
     
       
        
        function removePoint(lat, lng, i) {
            for (var x = 0; x < missedpoints.length; x++) {
                if(i == x) {
                    missedpoints[x][2] = 0;
                }
            }
            map.removeLayer(globalmarker[i]);
        }
        
        
      
         

</script>   
