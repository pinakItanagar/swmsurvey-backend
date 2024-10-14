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
           
            var redIcon = new L.Icon({
                iconUrl: '<?=base_url('images/red.png')?>',
                shadowUrl: '<?=base_url('images/marker-shadow.png')?>',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
        
        
         latlngs = [];
         len = livedata.length
          for (i = 0; i < livedata.length; i++) { 
		latlngs.push(new L.LatLng(livedata[i].Lat, livedata[i].Lng));
	  }
          var path = L.polyline(latlngs);
        
          
          
        
    
           var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{ maxZoom: 30, subdomains:['mt0','mt1','mt2','mt3']});
           google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 30,  subdomains:['mt0','mt1','mt2','mt3'] });
           
           var baseLayers = {
            "Map View": osm,
            "Satellite View": google
          };
          
          
         
          
          
           var mymap = L.map('mapid', {
                        center: [ <?=$lat?>, <?=$lng?>],
                        zoom: 15,
                        layers: [osm]
                    });
                    
            var response = "";        

            L.control.layers(baseLayers).addTo(mymap);
             $.ajax({
                url : 'http://164.52.207.234/psc/livetrack/getGPSData/',
                type : 'GET',
                dataType : 'json',
                success : function(response){
                   //alert(response.length);
                  
                    //var plotspeed = 0;
                    for (i = 0; i < response.length; i++) { 
                        
                          lat = response[i].Lat;
                          lng = response[i].Lng;
                          if(i == 0) {
                              L.marker([lat, lng]).bindPopup('Ignition : ' + response[i].Ignition + '<br>SyncOn : ' + response[i].SyncOn + '<br>Speed : ' + response[i].Speed ).addTo(mymap);
                          } else if(i == parseInt(response.length) - 1) {
                              L.marker([lat, lng], {icon: redIcon}).bindPopup('Ignition : ' + response[i].Ignition + '<br>SyncOn : ' + response[i].SyncOn + '<br>Speed : ' + response[i].Speed ).addTo(mymap);
                          } else {
                            L.marker([lat, lng], {icon: circleIcon}).bindPopup('Ignition : ' + response[i].Ignition + '<br>SyncOn : ' + response[i].SyncOn + '<br>Speed : ' + response[i].Speed).addTo(mymap);
                          }  
                      
                          task(i);
                    } 
                   
                    //L.marker([lat, lng]).bindPopup('Ignition : ' + response[0].Ignition + '<br>SyncOn : ' + response[0].SyncOn + '<br>Speed : ' + response[0].Speed ).addTo(mymap);
                }
            });
            
          
            function dataplot(lat, lng , ignition, sync, speed, counter) {
               
                     
                          if(counter == 0) {
                              L.marker([lat, lng]).bindPopup('Ignition : ' + ignition + '<br>SyncOn : ' + sync + '<br>Speed : ' + speed ).addTo(mymap);
                          } else if(i == parseInt(response.length) - 1) {
                              L.marker([lat, lng], {icon: redIcon}).bindPopup('Ignition : ' + ignition + '<br>SyncOn : ' + sync + '<br>Speed : ' + speed ).addTo(mymap);
                          } else {
                            L.marker([lat, lng], {icon: circleIcon}).bindPopup('Ignition : ' + ignition + '<br>SyncOn : ' + sync + '<br>Speed : ' + speed).addTo(mymap);
                          } 
                
            }
            
            
            function task(i) { 
                setTimeout(function() { 
                    console.log(i); 
                }, 10 * i); 
            } 
            
            /*
            
                 $.ajax({
                    url : 'http://164.52.207.234/psc/livetrack/getGPSData/',
                    type : 'GET',
                    dataType : 'json',
                    success : function(response){

                         for (i = 0; i < response.length; i++) { 
                          //alert(response[i].Lat);
                          lat = response[i].Lat;
                          lng = response[i].Lng;
                          if(i == 0) {
                              L.marker([lat, lng]).bindPopup('Ignition : ' + response[i].Ignition + '<br>SyncOn : ' + response[i].SyncOn + '<br>Speed : ' + response[i].Speed ).addTo(mymap);
                          } else if(i == parseInt(response.length) - 1) {
                              L.marker([lat, lng], {icon: redIcon}).bindPopup('Ignition : ' + response[i].Ignition + '<br>SyncOn : ' + response[i].SyncOn + '<br>Speed : ' + response[i].Speed ).addTo(mymap);
                          } else {
                            L.marker([lat, lng], {icon: circleIcon}).bindPopup('Ignition : ' + response[i].Ignition + '<br>SyncOn : ' + response[i].SyncOn + '<br>Speed : ' + response[i].Speed).addTo(mymap);
                          }  

                    }
                });  
            
             */
        

        
        
       

    

</script> 