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
      
      .ui-datepicker{z-index: 1000 !important};
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <div class="card-body">

               <div class="row">
                   <div class="col-md-2 col-lg-2 col-xlg-3">
                       <div class="form-group">
                            <div class="input-group mb-2">
                                <select name="viewType" id="viewType" class="form-control" required>
                                    <option value="DATE">Date Wise</option>
                                    <option value="ALL">All Dates</option>
                                </select>
                            </div>
                        </div>
                       
                   </div>
                   
                    <div class="col-md-2 col-lg-2 col-xlg-2">
                       <div class="form-group">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="report_date" id="report_date"  value="<?=date('Y-m-d')?>"  >
                            </div>
                        </div>
                       
                   </div>
                   
                     <div class="col-md-2 col-lg-2 col-xlg-2">
                       <div class="form-group">
                            <div class="input-group mb-3">
                                <select name="circle" id="circle" class="form-control" required>
                                     <option value="">Select Circle</option>
                                     <?php  foreach ($circles as $circle) {  ?>
                                        <option value="<?php echo($circle['circle_id'])?>"><?php echo($circle['circle_name'])?></option>
                                     <?php } ?>
                                </select>
                            </div>
                        </div>
                       
                   </div>
                   
                   <div class="col-md-2 col-lg-2 col-xlg-2">
                       <div class="form-group">
                            <div class="input-group mb-3">
                                <div id="wardsBox">
                                    <select name="ward" id="ward" class="form-control">
			                   <option value="">Select a Wards</option>
			            </select> 
                                </div>
                            </div>
                        </div>
                       
                   </div>
                  
                    <div class="col-md-3 col-lg-3 col-xlg-3">
                        <div class="form-group">
                            <div class="input-group mb-3">

                               
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="getReport" name="getReport" > <i class="fas fa-search"></i>&nbsp;View Cases</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>   
                
                <div class="row">
                    <div class="col-lg-12" style="100px;" >
                        
                        
                        
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
    //removeAllMarker();
   // var newMarker = "";
   
   function showpoint(arr) {
       
       
      
       
       
        var totalhouse = "";
        var denial_type = "";
        var address = "";
        var vlat = "";
        var vlng = "";
        if(arr.length > 0) {
            
             for(i = 0; i < arr.length; i++)  {
               
                
                 vlat = arr[i].latitude;
                 vlng = arr[i].longitude;
                 denial_type = arr[i].denial_type;
                 address = arr[i].locationName + arr[i].areaName;
                 totalhouse = arr[i].totalHouse ;
                 newMarker = new L.marker([vlat, vlng ], {draggable:true})
                              .bindPopup('Denial Type : '+ denial_type + '<br>Address : ' + address + '<br>Total House : ' + totalhouse  )
                              .addTo(map); 
                  //allmarker.push(newMarker);   
                 // map.addLayer(allmarker[i]);
                  
                 /*
                 newMarker = new L.marker([vlat, vlng ])
                             .bindPopup('Vehicle No : '+ res[1] + '<br>Speed : ' + res[4] + '<br>Ward No : ' + res[7] + '<br>GPS Date/Time : ' + res[8]  + '/' + res[9] )
                             .addTo(map); 
                */
             }
            
        }
        
    }
    
    /*
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
        
    }*/
    
    /*
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
        
    }*/
    
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
    
    /*
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
    */
    
    /*
    function getAllCases() {
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
   */
   
   function removeAllMarker() {
       
       for(x=0;x<allmarker.length;x++) {
         map.removeLayer(allmarker[x]);
         alert(x);
      }  
   }
   
   /*
   function addMarker(i) {
       map.addLayer(allmarker[i]); 
   }*/


   

</script>


<script type="text/javascript">

    
    $(document).ready(function () {
         var current_date = '<?=date("Y-m-d")?>' ;
        $("#viewType").change(function(){
              var view_type = $(this).val();
             
              if(view_type ==  "ALL") {
                   $("#report_date").val('');
                   $("#report_date").prop('disabled', true);
              } else {
                   $("#report_date").val(current_date);
                   $("#report_date").prop('disabled', false);
              }
              

       });
       
       
        $("#report_date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true

        });
        
        
        $("#getReport").click(function(){
           
            var viewType = $("#viewType").val();
            var ward = $("#ward").val();
            var report_date = $("#report_date").val();
            
            if(viewType === 'DATE') {
          
                $.ajax({
                    url : '<?=base_url('denialcase/showData/')?>' ,
                    type : 'POST',
                    data : {  report_date : report_date, ward_no : ward },
                    dataType : 'HTML',
                    success : function(response) {
                            // alert(response);
                            //$('#jcbReportResult').html(response);
                             var myArr = JSON.parse(response);
                             showpoint(myArr);

                    }
                });
            
            } else {
               
                $.ajax({
                    url : '<?=base_url('denialcase/showData/')?>' ,
                    type : 'POST',
                    data : {  ward_no : ward},
                    dataType : 'HTML',
                    success : function(response) {
                            
                            //alert(response);
                        
                            showpoint(myArr);
                            //$('#jcbReportResult').html(response);

                    }
                });
            
            }
            
            
        });
    

    });

</script> 






