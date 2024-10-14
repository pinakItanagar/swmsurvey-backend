 <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="My Cheque Book">

    <meta name="author" content="Pinak Pani Nath">

    <!-- Favicon icon -->

    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('assets/images/favicon.png')?>">

    <title>Patna Smart City - SWM</title>

    <!-- Custom CSS -->

    <link href="<?=base_url('assets/libs/flot/css/float-chart.css')?>" rel="stylesheet">

    <!-- Custom CSS -->

    <? if((isset($page_code)) && ($page_code == "DATA_TABLE")) { ?>

    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/extra-libs/multicheck/multicheck.css')?>">

    <link href="<?=base_url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')?>" rel="stylesheet">

    <? } ?> 



    <link href="<?=base_url('dist/css/stylealt.css')?>" rel="stylesheet">

    <link href="<?=base_url('dist/css/custom.css')?>" rel="stylesheet">

    <link href="<?=base_url('assets/fontawesome/css/all.css')?>" rel="stylesheet">



    <? if (isset($isDateField)) { ?>

    <script src="<?=base_url('js/jquery.min.js')?>"></script>

    <script src = "<?=base_url('js/jquery-ui.js')?>"></script>

    <link rel="stylesheet" href="<?=base_url('css/jquery-ui.css')?>">
    <script src="<?=base_url('dist/chart/Chart.js')?>"></script>
     <script src="<?=base_url('dist/chart/utils.js')?>"></script>

    <? } ?>


    <? if (isset($maps)) { ?>
        
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   
  
           
   <link href="<?=base_url('js/leaflet/leaflet.label.css')?>" rel='stylesheet' />
   <script src = "<?=base_url('js/leaflet/leaflet.label.js')?>"></script>
   
   <link href="<?=base_url('js/leaflet/leaflet.fullscreen.css')?>" rel='stylesheet' />
        
        
   <script src = "<?=base_url('js/leaflet/Leaflet.fullscreen.min.js')?>"></script>
        
     

         <style>
            #mapid { height: 300px; }
         </style>   


    <? } ?>


   
 



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

   <![endif]-->