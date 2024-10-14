 <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title"><?=$page_title?></h4>
        <? if(isset($breadcrum)) { ?>
        <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <? for($bx=0; $bx<count($breadcrum); $bx++) { ?>
                        <? if($breadcrum[$bx]['link'] != "#") { ?>
                            <li class="breadcrumb-item">
                                <a href="<?=base_url($breadcrum[$bx]['link'])?>"><?=$breadcrum[$bx]['text']?></a>
                            </li>
                        <? } else { ?>
                            <li class="breadcrumb-item active"><?=$breadcrum[$bx]['text']?></li>
                        <? } ?>    
                    <? } ?>
                    
                </ol>
            </nav>
        </div>
       <? } ?>
    </div>
</div>