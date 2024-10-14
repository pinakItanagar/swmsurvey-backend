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
                            <h3>Yard Map </h3>

                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <!-- MAP SPACE -->
                            <div id="mymap" style="height: 600px; width:100%"></div>
                        </div>
                    </div>
                </div>
                
                
                  <div class="row">
                    <div class="col-lg-12" id="misspointSearchResult">
                      
                    </div>
                </div>
                
                
            



                
               



            </div>
        </div>    
    </div>
</div>  



    
    
<script type="text/javascript">

  

   document.getElementById('mymap').style.cursor = 'pointer';
   
   
  var red_dot = new L.Icon({
        iconUrl: '<?=base_url('images/red_dot.png')?>',
        iconSize: [16, 16]
    });
   
   
   var yellow_dot = new L.Icon({
        iconUrl: '<?=base_url('images/yellow_dot.png')?>',
        iconSize: [16, 16]
    });
    
    
    var blue_dot = new L.Icon({
        iconUrl: '<?=base_url('images/blue_dot.png')?>',
        iconSize: [16, 16]
    });
   
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
     
         var vehicle_data_point = '<?=$all_points?>' ;
         var obj = JSON.parse(vehicle_data_point);
         
         
         var route_data_point = '<?=$all_routes?>' ;
         var obj2 = JSON.parse(route_data_point);
         
         var adjusted_data_point = '<?=$adjusted_points?>' ;
         var obj3 = JSON.parse(adjusted_data_point);
       
         var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']});
           google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 20,  subdomains:['mt0','mt1','mt2','mt3'] });

        
        var baseLayers = {
            "Map View": osm,
            "Satellite View": google
        };
        
       
        var map = L.map('mymap', {
                        center: [<?=$start_lat?>, <?=$start_lng?>],
                        zoom: 20,
                        layers: [google]
                    });
        
        L.control.layers(baseLayers).addTo(map);
        
        // obj[0].value._rev
      // alert(obj[0].value._rev);
        
        // Plot Route 
       
        for (var i = 0; i < obj2.length; i++) {
            var newMarker = new L.marker([obj2[i].value.latitude, obj2[i].value.longitude ],  {icon: blue_dot}).addTo(map); 
        } 
        
       
     
         for (var i = 0; i < obj3.length; i++) {
            var newMarker = new L.marker([obj3[i].lat, obj3[i].lng ],  {icon: red_dot}).bindPopup('Device Time : '+ obj3[i].device_date_time).addTo(map); 
        }
       
    
        for (var i = 0; i < obj.length; i++) {
            
          
               
               
           
                    if(i == 0) {
                         var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ],  {icon: greenIcon}).bindPopup('Device Time : '+ obj[i].device_date_time).addTo(map); 
                    } else if(i == obj.length - 1) { 
                      var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ],  {icon: redIcon}).bindPopup('Device Time : '+ obj[i].device_date_time).addTo(map);   
                    } else {
                       if(obj[i].isvalid == "1") { 
                       var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ],  {icon: yellow_dot}).bindPopup('Device Time : '+ obj[i].device_date_time + ' lat : ' + obj[i].latitude + ' lng : ' + obj[i].longitude ).addTo(map); 
                      }
                    }
                  
           
              
        }
        
        
        
        
        
     
        
        
     
        
       
            
        
       
     
      
     
       
        /*
       
        
        
         map.on('click', function(e) {
           
              var i = parseInt(globalmarker.length);
             
              var removeURL =   "javascript:void(0); removePoint(" + e.latlng.lat + "," + e.latlng.lng + "," + i  + ");" ;
              var newMarker = new L.marker(e.latlng, {icon: redIcon}).bindPopup('Lat : ' +  e.latlng.lat + ' / Lng : ' + e.latlng.lng  + '<br><a href="'+ removeURL + '">Remove Point</a>'  ).addTo(map);
              missedpoints.push([e.latlng.lat,e.latlng.lng, 1]);
              checkpoint(e.latlng.lat, e.latlng.lng);
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
        
        
        */
      
         

</script>   
