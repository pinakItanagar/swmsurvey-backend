 <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="My Cheque Book">

    <meta name="author" content="Pinak Pani Nath">

    <!-- Favicon icon -->

    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('assets/images/favicon.png')?>">

    <title>MIS : Itanagar Smart City Development Corporation Ltd </title>

    <!-- Custom CSS -->

    <link href="<?=base_url('assets/libs/flot/css/float-chart.css')?>" rel="stylesheet">

    <!-- Custom CSS -->

    <? if((isset($page_code)) && ($page_code == "DATA_TABLE")) { ?>

    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/extra-libs/multicheck/multicheck.css')?>">

    <link href="<?=base_url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')?>" rel="stylesheet">

    <? } ?> 



    <link href="<?=base_url('dist/css/style.min.css')?>" rel="stylesheet">

    <link href="<?=base_url('dist/css/custom.css')?>" rel="stylesheet">

    <link href="<?=base_url('assets/fontawesome/css/all.css')?>" rel="stylesheet">



    <? if (isset($isDateField)) { ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <? } ?>


    <? if (isset($isMap)) { ?>

        <style>
              #map {
                height: 500px;
                width: 100%;
               }

              #basemaps-wrapper {
                position: absolute;
                top: 10px;
                right: 10px;
                z-index: 400;
                background: white;
                padding: 5px;
              }
         
          </style>

     

     <? } ?>     

 



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

   <![endif]-->