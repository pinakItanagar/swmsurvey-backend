    <? if ((!isset($isDateField)) &&  (!isset($isImageCrop))) { ?>

    <script src="<?=base_url('assets/libs/jquery/dist/jquery.min.js')?>"></script>

   <? } ?>

   


     



    <!-- Bootstrap tether Core JavaScript -->

    <script src="<?=base_url('assets/libs/popper.js/dist/umd/popper.min.js')?>"></script>

    <script src="<?=base_url('assets/libs/bootstrap/dist/js/bootstrap.min.js')?>"></script>

    <? if (!isset($isImageCrop)) { ?>

    <script src="<?=base_url('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')?>"></script>

    <? } ?> 

    <script src="<?=base_url('assets/extra-libs/sparkline/sparkline.js')?>"></script>

    <!--Wave Effects -->

    <script src="<?=base_url('dist/js/waves.js')?>"></script>

    <!--Menu sidebar -->

    <script src="<?=base_url('dist/js/sidebarmenu.js')?>"></script>

    <!--Custom JavaScript -->

    <script src="<?=base_url('dist/js/custom.min.js')?>"></script>



     <? if($page_title == "Dashboard") { ?>

    <!--This page JavaScript -->

    <!-- <script src="<?=base_url('dist/js/pages/dashboards/dashboard1.js')?>"></script> -->

    <!-- Charts js Files -->

    <script src="<?=base_url('assets/libs/flot/excanvas.js')?>"></script>

    <script src="<?=base_url('assets/libs/flot/jquery.flot.js')?>"></script>

    <script src="<?=base_url('assets/libs/flot/jquery.flot.pie.js')?>"></script>

    <script src="<?=base_url('assets/libs/flot/jquery.flot.time.js')?>"></script>

    <script src="<?=base_url('assets/libs/flot/jquery.flot.stack.js')?>"></script>

    <script src="<?=base_url('assets/libs/flot/jquery.flot.crosshair.js')?>"></script>

    <script src="<?=base_url('assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js')?>"></script>

    <script src="<?=base_url('dist/js/pages/chart/chart-page-init.js')?>"></script>

   <? } ?> 



     <? if((isset($page_code)) && ($page_code == "DATA_TABLE")) { ?>

     <script src="<?=base_url('assets/extra-libs/multicheck/datatable-checkbox-init.js')?>"></script>

        <script src="<?=base_url('assets/extra-libs/multicheck/jquery.multicheck.js')?>"></script>

        <script src="<?=base_url('assets/extra-libs/DataTables/datatables.min.js')?>"></script>

        <script>

            /****************************************

             *       Basic Table                   *

             ****************************************/

            $('#zero_config').DataTable();

        </script>

    <? } ?> 

  
     
 




   <script type="text/javascript"> 
    $(document).ready(function () {

      
       $("#circle").change(function(){
            var circle_id = $(this).val();
            //alert(circle_id);
            $.ajax({
                url : '<?php echo base_url('managesurveyor/getWards')?>/',
                type : 'POST',
                data : {circle_id:circle_id},
                dataType : 'json',
                success : function(response){
                    if(response['wards']) {
                        $('#wardsBox').html(response['wards']);
                    }
                }
            });
            $("#surveyorsBox").html("<select name=\"surveyor\" id=\"surveyor\" class=\"form-control\">\
                                        <option value=\"\">Select a Surveyor</option>\
                                    </select>");
        });

       $(document).on("change", "#ward", function(){
        var ward_id = $(this).val();
        //alert(ward_id);
        $.ajax({
                url : '<?php echo base_url('managesurveyor/getSurveyors')?>/',
                type : 'POST',
                data : {ward_id:ward_id},
                dataType : 'json',
                success : function(response){
                    if(response['surveyors']) {
                        $('#surveyorsBox').html(response['surveyors']);
                    }
                }
            });
       });
    
    $("#property_circle").change(function(){
            var circle_id = $(this).val();
            //alert(circle_id);
            $.ajax({
                url : '<?php echo base_url('manageproperty/getWards')?>/',
                type : 'POST',
                data : {circle_id:circle_id},
                dataType : 'json',
                success : function(response){
                    if(response['wards']) {
                        $('#wardsBox').html(response['wards']);
                    }
                }
            });
        });
    });


    $("#property_audit").click(function(){
            var ward_no = $("#ward").val();
            var audit_date = $("#audit_date").val();
            //alert(circle_id);
            $.ajax({
                url : '<?=base_url('manageproperty/getPropertyByDate')?>',
                type : 'POST',
                data : { ward_no : ward_no , audit_date : audit_date},
                dataType : 'HTML',
                success : function(response) {
                 
                        $('#searchResult').html(response);
                    
                }
            });
    });
    
    function saveremarks(pid) {

        var elementRemark = "#audit_remark_" + pid;
        var elementReject = "#isreject_" + pid;
        var elementRecordId = "#p_record_id_" + pid;

        var elementAddressRemark = "#addr_verification_" + pid;
        var elementCallStatus = "#call_status_" + pid;
        var elementCallDate = "#call_date_" + pid;
        //alert($(elementRemark).val());
        


        $.ajax({
                url : '<?php echo base_url('manageproperty/savePropertyRemark')?>/',
                type : 'POST',
                data : {elementRemark:$(elementRemark).val(), elementReject:$(elementReject).val(), elementRecordId:$(elementRecordId).val(), elementAddressRemark:$(elementAddressRemark).val(), elementCallStatus:$(elementCallStatus).val(), elementCallDate:$(elementCallDate).val()},
                dataType : 'HTML',
                success : function(response){
                    
                        alert("Record Has Been Updated Successfully !");
                   
                }
            });

      
    }     
   $("#savePoints").click(function(){
            
            var ward_no = $("#ward_no").val();
            var ward_misspoints = JSON.stringify(missedpoints);
            $.ajax({
                url : '<?=base_url('managepropertygis/savemisspoints')?>',
                type : 'POST',
                data : { ward_no : ward_no , ward_misspoints : ward_misspoints},
                dataType : 'HTML',
                success : function(response) {
                 
                        $('#misspointSearchResult').html(response);
                    
                }
            });
          
     });
     
     function checkpoint(lat, lng) {
        
           $.ajax({
                url : '<?=base_url('api/mycheckpoint.php')?>',
                type : 'POST',
                data : { lat : lat , lng : lng},
                dataType : 'HTML',
                success : function(response) {
                 
                        $('#misspointSearchResult').html(response);
                    
                }
            });
     
    }
    
    <? if($page_title != "Dashboard") { ?>

     $("#getReport").click(function(){
            var img = '<?=base_url('images/gear1.gif')?>' ;
            $('#reportResult').html("<div align='center'><img src='" + img + "'></div>");
            var report_date = $("#report_date").val();
            //alert(circle_id);
            $.ajax({
                url : '<?=base_url('footprintreport/preparereport')?>',
                type : 'POST',
                data : {  report_date : report_date},
                dataType : 'HTML',
                success : function(response) {
                 
                        $('#reportResult').html(response);
                    
                }
            });
    });
    
    
     $("#getJCBReport").click(function(){
            var img = '<?=base_url('images/infinity.gif')?>' ;
            $('#jcbReportResult').html("<div align='center'><img src='" + img + "'></div>");
            var report_date = $("#report_date").val();
           // alert(Armsensor);
            $.ajax({
                url : '<?=base_url('armsensor/showAllJcbData/')?>' + report_date,
                type : 'POST',
                data : {  report_date : report_date},
                dataType : 'HTML',
                success : function(response) {
                 
                        $('#jcbReportResult').html(response);
                    
                }
            });
    });
    
    
    

  
    
    
    
     $("#searchBtn").click(function(){
           // var img = '<?=base_url('images/gear1.gif')?>' ;
            //$('#globalSearchResult').html("<div align='center'><img src='" + img + "'></div");
            $('#globalSearchResult').html("");
            var search = $("#search").val();
            //alert(circle_id);
            
            if(search != "") {
                $.ajax({
                    url : '<?=base_url('globalsearch/property')?>',
                    type : 'POST',
                    data : {  search : search},
                    dataType : 'HTML',
                    success : function(response) {

                            $('#globalSearchResult').html(response);

                    }
                });
            }
    });

    <? } ?>
    
 </script>    