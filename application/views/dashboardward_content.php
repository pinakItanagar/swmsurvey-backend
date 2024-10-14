<!-- ============================================================== -->

<!-- Sales Cards  -->
<style>
    .count {
      
      color:white;
      margin-left:2px;
      margin-right:2px;
      font-size:16px;
   }
   
   
</style>

<div class="row">

    <!-- Column -->
    
    <? foreach($wards as $w) 
    { 

      $total_footprints = $w->total_footprints;
      $survey_done = $w->finishedSurvey + $w->newProperty;      
      $survey_pending = $total_footprints - $survey_done;
      $new_added = $w->totalProperty+$w->totalExistingProperty- $total_footprints;

    ?>
    <div class="col-md-4 col-lg-4 col-xlg-4">

        <div class="card card-hover">
          
                <div class="box bg-cyan text-center">

                    <h1 class="font-light text-white"><i class="mdi mdi-city"></i></h1>

                    <h6 class="text-white"> <a href="<?=base_url('dashboard/overallwardinfo/'.$w->ward_no) ?>" style="text-decoration:none; color:#fff;"> Ward No <?=$w->ward_no?> </a> </h6>

                  <!--  <a href="#"> <h2 class="text-white">(<span class="count"></span>)</h2> </a> -->
                    
                   
                
               </div>
               <div class="box bg-secondary text-left">
                 <h6 class="text-white"><a href="<?= base_url('dashboard/existingproperty/'.$w->ward_no) ?>" class="text-white">Total Footprint : (<span class="count"><?=$total_footprints?></a></span>)</h6>
               </div>

               <div class="box bg-success text-left">
                 <h6 class="text-white"><a href="<?= base_url('dashboard/existingproperty/'.$w->ward_no) ?>" class="text-white">Survey Done : (<span class="count"><?=$survey_done?></a></span>)</h6>
               </div>
            
               <div class="box bg-orange text-left">
                   <h6 class="text-white"><a href="<?= base_url('dashboard/surveypending/'.$w->ward_no) ?>" class="text-white">Survey Pending : (<span class="count"><?=$survey_pending?></a></span>) </h6>
               </div>
            
               <div class="box bg-danger text-left">
                   <h6 class="text-white"><a href="<?= base_url('dashboard/newproperty/'.$w->ward_no) ?>" class="text-white">New Property Added : (<span class="count"><?=$w->newProperty?></a></span>) </h6>
               </div>               
               

        </div>
         

    </div>
    
    <? } ?>

</div>   


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


















