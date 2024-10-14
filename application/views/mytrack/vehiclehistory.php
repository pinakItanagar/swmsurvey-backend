<style>
    path.leaflet-interactive.animate {
    stroke-dasharray: 1920;
    stroke-dashoffset: 1920;
    animation: dash 20s linear 3s forwards;
}

@keyframes dash {
    to {
        stroke-dashoffset: 0;
    }
}
    
</style>    

<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">

        <div class="card">
            <!-- end breadcrumb -->

            <?php if ($this->session->flashdata('save')) { ?>

                <div class="alert alert-success"> <?= $this->session->flashdata('save') ?> </div>

            <?php } ?>

            <!-- start white-box -->

            <form id="myform" action="#" method="POST" class="form-horizontal" enctype="multipart/form-data">

                <div class="card-body">

                   

                    

                  
                   
                   <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <!-- MAP SPACE -->
                            <div id="mapid" style="height: 500px; width:100%"></div>
                        </div>
                     </div>
                </div>


            </form>


        </div>
    </div>
</div>  


<script src="<?=base_url("js/L.Polyline.SnakeAnim.js")?>"></script>

<script type="text/javascript">
    
          var livedata = <?=$livedata?> ;
          
          var lat = "";
          var lng = "";
          
          
           var circleIcon = new L.Icon({
            iconUrl: '<?=base_url('images/circle.png')?>',
            iconSize: [15, 15]
        });
        
        
         latlngs = [];
         len = livedata.length
          for (i = 0; i < livedata.length; i++) { 
		latlngs.push(new L.LatLng(livedata[i].Lat, livedata[i].Lng));
	  }
          var path = L.polyline(latlngs);
        
          
          
        
    
           var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']});
           google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 20,  subdomains:['mt0','mt1','mt2','mt3'] });
           
           var baseLayers = {
            "Map View": osm,
            "Satellite View": google
          };
          
          
           var mid_point = livedata.length/2 ;
          
          
           var mymap = L.map('mapid', {
                        center: [livedata[mid_point].Lat, livedata[mid_point].Lng],
                        zoom: 15,
                        layers: [osm]
                    });

            L.control.layers(baseLayers).addTo(mymap);
            
          
           
            mymap.fitBounds(L.latLngBounds(latlngs));

		mymap.addLayer(L.marker(latlngs[0]));
		mymap.addLayer(L.marker(latlngs[len - 1]));

		mymap.addLayer(path);
                
                
                function snake() {
			path.snakeIn();
		}
          
          /*
            var j = 0; 
           for (i = 0; i < livedata.length; i++) { 
               
               lat = livedata[i].Lat;
               lng = livedata[i].Lng;
               L.marker([lat, lng], {icon: circleIcon}).addTo(mymap);
              
           }
           */
         
          /*
          var mymarker = "";
           
           function gogogo (i) {           
                setTimeout(function () {    
                 
                      lat = livedata[i].Lat;
                      lng = livedata[i].Lng;
                      mymarker = L.marker([lat, lng], {icon: circleIcon});
                      mymap.addLayer(mymarker);
                      console.log(lat + " " + lng);
                      mymap.setView([lat, lng], 15, { animation: true });
                   
                
                }, 10); 
             }
           
            for (i = 0; i < livedata.length; i++) { 
                gogogo(i);
                clearTimeout() ;
            }*/
           
          //  L.marker([25.585996, 85.183837]).addTo(mymap).openPopup();


        
        
       

    

</script> 