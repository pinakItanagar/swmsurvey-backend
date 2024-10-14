

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




<script type="text/javascript">
    
           var osm = L.tileLayer('http://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']});
           google =  L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{ maxZoom: 20,  subdomains:['mt0','mt1','mt2','mt3'] });
           
           var baseLayers = {
            "Map View": osm,
            "Satellite View": google
          };
          
          
           var mymap = L.map('mapid', {
                        center: [25.585996, 85.183837],
                        zoom: 15,
                        layers: [osm]
                    });

            L.control.layers(baseLayers).addTo(mymap);
           
           
            L.marker([25.585996, 85.183837]).addTo(mymap).openPopup();


            mymap.on('click', function(e) {
               //alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
               $("#latitude").val(e.latlng.lat);
               $("#longitude").val(e.latlng.lng);
            });
        
       

    

</script> 