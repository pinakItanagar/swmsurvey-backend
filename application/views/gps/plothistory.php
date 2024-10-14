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
                        <h3>Distance : <?=$total_distance?></h3>
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
    
    
     var rightArrow = new L.Icon({
        iconUrl: '<?=base_url('images/right-arrow.png')?>',
        shadowUrl: '<?=base_url('images/marker-shadow.png')?>',
        iconSize: [16, 16]
    });




     
       
        
       
        
        

        
        
         var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']});
           google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 20,  subdomains:['mt0','mt1','mt2','mt3'] });

        
        var baseLayers = {
            "Map View": osm,
            "Satellite View": google
        };
        
        
          
        var map = L.map('mymap', {
                        layers: [google],
                        fullscreenControl: {
                            pseudoFullscreen: false
                        }
                       }).setView([ 25.622167 , 85.107383], 15);
        
        L.control.layers(baseLayers).addTo(map);
        
        var locations = '<?=$vehicle?>' ;
        var obj = JSON.parse(locations);
     
     
        
   
        for (var i = 0; i < obj.length; i++) {
            
            if(obj[i].state2  == '1') {
                var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ], {icon: greenIcon})
               .bindPopup('Device Date/Time : '+ obj[i].device_date_time + '<br>Distance : ' + obj[i].distance  )
               .addTo(map); 
            } else if(i == (obj.length - 1)) {
                  var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ], {icon: redIcon})
               .bindPopup('Device Date/Time : '+ obj[i].device_date_time + '<br>Distance : ' + obj[i].distance  )
               .addTo(map);    
            
            } else {
                 var newMarker = new L.marker([obj[i].latitude, obj[i].longitude ])
               .bindPopup('Device Date/Time : '+ obj[i].device_date_time + '<br>Distance : ' + obj[i].distance  )
               .addTo(map);
            }
        }
        
        
      
   
  

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