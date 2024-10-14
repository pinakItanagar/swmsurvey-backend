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
                   <div class="col-md-2 col-lg-2 col-xlg-4">
                       <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="searchDate" id="searchDate"  value="<?=date('Y-m-d')?>"  >
                            </div>
                        </div>
                       
                   </div>
                    <div class="col-md-10 col-lg-10 col-xlg-8">
                        <div class="form-group">
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" name="placeName" id="placeName"  placeholder="Street/Area Name, City, State"  >
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="searchPlace" name="searchPlace" onclick="address_search();" > <i class="fas fa-search"></i>&nbsp;Search</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>   
                
                <div class="row">
                    <div class="col-lg-12" id="placeSearchResult">
                        
                        
                        
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-lg-2" >
                        
                         <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="searchLat" id="searchLat"  placeholder="Latitude" readonly="true"  >
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-lg-2" >
                        
                         <div class="form-group">
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" name="searchLng" id="searchLng"  placeholder="Longitude" readonly="true" >
                                

                            </div>
                        </div>
                        
                    </div>
                    
                    
                    <div class="col-lg-3" >
                        
                         <div class="form-group">
                            <div class="input-group mb-3">

                                <input type="text" class="form-control" name="searchRadius" id="searchRadius"  value="400" >
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="rx" name="rx" disabled="disabled" >Search Radius</button>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                    
                    
                    <div class="col-lg-3" >
                        
                         <div class="form-group">
                            <div class="input-group mb-3">

                            
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="findVehicle" name="findVehicle" onclick="findVehicleFromPlace();" > <i class="fas fa-search"></i>&nbsp;Find Vehicle</button>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <!-- MAP SPACE -->
                            <div id="mymap" style="height: 400px; width:100%"></div>
                        </div>
                    </div>
                </div>


                


              

 
            </div>
        </div>    
    </div>
</div>  



    
    
<script type="text/javascript">
    
      var allmarker = new Array();
      var total_marker = 0;
  
      var greenIcon = new L.Icon({
        iconUrl: '<?=base_url('images/green.png')?>',
        shadowUrl: '<?=base_url('images/marker-shadow.png')?>',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    
    var redIcon = new L.Icon({
        iconUrl: '<?=base_url('images/red.png')?>',
        shadowUrl: '<?=base_url('images/marker-shadow.png')?>',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });
    
    
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
    removeAllMarker();
   // var newMarker = "";
    
    
    function showvehicle(arr) {
        var str = "";
        var res = "";
        var vlat = "";
        var vlng = "";
        if(arr.length > 0) {
            
             for(i = 0; i < arr.length; i++)  {
                 str = arr[i];
                 res = str.split("#");
                 vlat = res[2];
                 vlng = res[3];
                 newMarker = new L.marker([vlat, vlng ])
                             .bindPopup('Vehicle No : '+ res[1] + '<br>Speed : ' + res[4] + '<br>Ward No : ' + res[7] + '<br>GPS Date/Time : ' + res[8]  + '/' + res[9] )
                             .addTo(map); 
             }
            
        }
        
    }
    function findVehicleFromPlace() {
        var radius = document.getElementById('searchRadius').value ;
        var circle = L.circle([document.getElementById('searchLat').value, document.getElementById('searchLng').value], {radius: radius}).addTo(map);
        circle.setStyle({color: 'white'});
        
        
        var xmlhttp = new XMLHttpRequest();
        var url = "<?=base_url('vehiclesearch/findVehicletest/')?>" + document.getElementById('searchLat').value + "/" + document.getElementById('searchLng').value + "/" + radius;
        xmlhttp.onreadystatechange = function()
        {
          if (this.readyState == 4 && this.status == 200) {
               //alert(this.responseText);
             var myArr = JSON.parse(this.responseText);
             showvehicle(myArr);
          }
        };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
        
    }
    
    function chooseAddr(lat1, lng1) {
        
        map.setView([lat1, lng1],13);
        var newMarker = new L.marker([lat1, lng1 ], {icon: greenIcon}).addTo(map); 
       
         allmarker.push(newMarker);
         map.addLayer(allmarker[0]); 
        //var circle = L.circle([lat1, lng1], {radius: 400}).addTo(map);
        //circle.setStyle({color: 'white'});
        document.getElementById('searchLat').value = lat1;
        document.getElementById('searchLng').value = lng1;
    }
    
    
    function myFunction(arr) {
        var out = "<br /><div>";
        var i;

        if(arr.length > 0) {
            out += "<ul>";
            for(i = 0; i < arr.length; i++)  {
             out += "<li><a style='cursor: pointer;' title='Show Location and Coordinates' onclick='chooseAddr(" + arr[i].lat + ", " + arr[i].lon + ");return false;'>" + arr[i].display_name + "</a></li>";
            }
            out += "</ul>";
            out += "</div><br />";
            document.getElementById('placeSearchResult').innerHTML = out;
        }
        else {
         out += "</div><br />";    
         document.getElementById('placeSearchResult').innerHTML = "Sorry, no results...";
       }
       
      

    }
    
    
    function address_search() {
        var out = "<div align='center'><img src='<?=base_url("images/infinity.gif")?>'></div>";
        document.getElementById('placeSearchResult').innerHTML = out;
        var inp = document.getElementById("placeName").value;
        var xmlhttp = new XMLHttpRequest();
        var url = "https://nominatim.openstreetmap.org/search?format=json&limit=8&q=" + inp;
        xmlhttp.onreadystatechange = function()
        {
          if (this.readyState == 4 && this.status == 200) {
              //alert(this.responseText);
              var myArr = JSON.parse(this.responseText);
              myFunction(myArr);
          }
        };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
   }
   
   
   function removeAllMarker() {
       for(i=0;i<allmarker.length;i++) {
         map.removeLayer(allmarker[i]);
      }  
   }
   
   function addMarker() {
       map.addLayer(allmarker[0]).addTo(map); 
   }


   

</script>






