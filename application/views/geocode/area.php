<!-- ============================================================== -->

<!-- Sales Cards  -->
<style>
    .count {

        color:white;
        margin-left:10px;
        font-size:25px;
    }
</style>


<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" id="globalSearchResult">

    </div>
</div>





<div class="row">
    <div class="col-md-12 col-lg-12 col-xlg-12" >
        &nbsp;
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









<script type="text/javascript">
    var img = "";
    var wardArray = [];
    var ward_color = "";
    var ward_boundary_geojson = "";
    var wno = "";
    var  vendor_name = "" ;
    var  total_footprint = "" ;
    var total_survey = 0;
    var total_survey_today = 0;
    
    
    document.getElementById('mymap').style.cursor = 'pointer';





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


    

</script>



















