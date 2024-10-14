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
                            <h3>Patna Map </h3>

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
                
                
              
            



                
               



            </div>
        </div>    
    </div>
</div>  



    
    
<script type="text/javascript">
    
        function polystyle(ward) {
            var fillcolor ;
            if(ward == 23) {
                fillcolor = 'red';
            } else if (ward == 22) {
                fillcolor = '#99d383';
             } else if (ward == 21) {
                fillcolor = '#acafab';
            } else if (ward == 36) {
                fillcolor = '#CCCCFF';
            }
            return {
                fillColor: fillcolor,
                weight: 2,
                opacity: 1,
                color: fillcolor,  //Outline color
                fillOpacity: 0.50
            };
        }

  

       document.getElementById('mymap').style.cursor = 'pointer';
   
   
         
       
        
        
      
        var geojsonFeature = <?=$patna?> ;
   
        var geojsonW23 = <?=$w23?> ;
        var geojsonW22 = <?=$w22?> ;
        var geojsonW21 = <?=$w21?> ;
         var geojsonW36 = <?=$w36?> ;
        
        
       
         var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']});
           google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 20,  subdomains:['mt0','mt1','mt2','mt3'] });

        
        var baseLayers = {
            "Map View": osm,
            "Satellite View": google
        };
        
       
        var map = L.map('mymap', {
                        center: [25.5941, 85.1376],
                        zoom: 14,
                        layers: [google]
                    });
        
        L.control.layers(baseLayers).addTo(map);

          
        
       
        L.geoJSON(geojsonFeature).addTo(map);
        L.geoJSON(geojsonW23 , {style: polystyle(23)}).addTo(map);
        L.geoJSON(geojsonW22 , {style: polystyle(22)}).addTo(map);
        L.geoJSON(geojsonW21 , {style: polystyle(21)}).addTo(map);
        L.geoJSON(geojsonW36 , {style: polystyle(36)}).addTo(map);
     
       
        
       
        
        
         
        
      
         

</script>   
