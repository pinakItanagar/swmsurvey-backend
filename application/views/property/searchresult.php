 <? foreach($properties as $property) 
 { 
  
    if (date('Y-m-d',strtotime($property->date_updated))>'2021-03-12')
    {
        $filename = 'download/w'.$property->ward_no.'/property_pic/pic_property_'.$property->pid.'.jpeg'; 
        $primage = base_url($filename); 
        $filename1 = 'download/w'.$property->ward_no.'/qrcode_pic/pic_qrcode_'.$property->pid.'.jpeg'; 
        $qrimage = base_url($filename1); 
    }
    else
    {
        $primage = 'data:image/jpeg;base64,' . $property->property_pic; 
        $qrimage = 'data:image/jpeg;base64,' . $property->property_qrcode_pic; 
    }



?>

    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="jumbotron jumbotron-fluid">
                
                <div class="container" style="background-color:#8EB9D9">

                   <div class="card">
                  <div class="card-body">


                          <div class="row">

                             <div class="col-lg-6">
                               
                                 <h3> QR Code Image</h3>
                                
                            </div>
                            <div class="col-lg-6">
                                
                                 <h3> Property Image With QR Code  </h3> 
                                
                            </div>


                        </div>

                        <div class="row">

                             <div class="col-lg-6">
                                <? 
                                    echo '<img src="'. $qrimage .'" class="img-fluid">';
                                ?>
                             </div>
                            <div class="col-lg-6">
                                <div style="float: left; padding-left: 10px">
                                <? 
                                    echo '<img src="'. $primage .'" class="img-fluid" style="float: left;">';
                                ?>
                                </div>
                            </div>


                        </div>
                      
                      
                      
                     
                      
                     
                          
                                 <b>
                                     <? if($property->isflat == 1 ) { 
                                        //$accuracyCount = strlen(strrchr($property->gpsaccuracy, '.')) -1;
                                        $accuracyCount = round($property->gpsaccuracy);
                                        $accuracyMsg = $accuracyCount>10?'<font color=red>Revisit Required</font>':'<font color=green>Accuracy is good</font>';
                                    ?>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <hr>
                                            </div>    
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Property ID</label>
                                                    <input type="text" class="form-control" name="pid" id="pid" value="<?=$property->pid?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>QR-Code</label>
                                                    <input type="text" class="form-control" name="pid" id="pid"  value="<?=$property->qr_code?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Mobile No.</label>
                                                    <input type="text" class="form-control" name="mobile_no" id="mobile_no"  value="<?=$property->mobile_no?>" disabled="disabled" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Apartment Name</label>
                                                    <input type="text" class="form-control" name="flatname" id="flatname"  value="<?=$property->flatname?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Update Apartment Name</label>
                                                    <input type="text" class="form-control" name="owner_apt_name_<?=$property->pid?>" 
                                                    id="owner_apt_name_<?=$property->pid?>" value="<?=$property->owner_apt_name?>" placeholder="Enter Address">
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control" name="address_street" id="address_street"  value="<?=$property->address_street?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Update Address</label>
                                                    <input type="text" class="form-control" name="updated_address_<?=$property->pid?>" id="updated_address_<?=$property->pid?>" value="<?=$property->updated_address?>" placeholder="Enter Address">
                                                </div>
                                            </div>
                                        </div>  
					                    <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>House No.</label>
                                                    <input type="text" class="form-control" name="address_street" id="address_hno"  value="<?=$property->houseno?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Landmark</label>
                                                    <input type="text" class="form-control" name="address_street" id="address_landmark"  value="<?=$property->area_landmark?>" disabled="disabled" >
                                                </div>
                                            </div>
                                           
                                        </div> 
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Accuracy</label>
                                                    <input type="text" class="form-control" name="gpsaccuracy" id="gpsaccuracy"  value="<?=$property->gpsaccuracy?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Lat/Long</label>
                                                    <input type="text" class="form-control" name="latlong" id="latlong"  value="<?=$property->latitude?>/<?=$property->longitude?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Data capture date</label>
                                                    <input type="text" class="form-control" name="date_updated" id="date_updated"  value="<?=$property->date_updated?>" disabled="disabled" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">

                                                     <div class="form-group">
                                                     <label>System Generated Remark</label>
                                                    <input type="text" class="form-control" name="sys_remark" id="sys_remark"  value="<?=$accuracyMsg?>" disabled="disabled" >
                                                </div>
                                                    
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Surveyor : <?=$property->first_name.' '.$property->last_name?></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Surveyor Mobile : <?=$property->mobile?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    
                                                    <label>Remark</label>
                                                    <input type="text" class="form-control" name="audit_remark_<?=$property->pid?>" id="audit_remark_<?=$property->pid?>"  value="<?=$property->audit_remark?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    
                                                    <label>Address Verification Remark</label>
                                                    <input type="text" class="form-control" name="addr_verification_<?=$property->pid?>" id="addr_verification_<?=$property->pid?>"  
                                                    value="<?=$property->address_verification_remark?>">
                                                </div>
                                            </div>
                                            
                                         </div>

                                         <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Audit Status</label>
                                                    <select name="isreject_<?=$property->pid?>" id="isreject_<?=$property->pid?>" class="form-control">
                                                        <option value="1" <?php if($property->isreject==1) {echo "selected=selected";} ?>>Reject</option>
                                                        <option value="0" <?php if($property->isreject==0) {echo "selected=selected";} ?>>Approved</option>

                                                    </select>    
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Call Status</label>
                                                    <select name="call_status_<?=$property->pid?>" id="call_status_<?=$property->pid?>" class="form-control">
                                                        
                                                        <option value="1" <?php if($property->call_status==1) {echo "selected=selected";} ?>>Reject</option>
                                                        <option value="0" <?php if($property->call_status==0) {echo "selected=selected";} ?>>Approved</option>

                                                    </select>    
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Call Date</label>
                                                    <input type="text" class="form-control" name="call_date_<?=$property->pid?>" id="call_date_<?=$property->pid?>" onclick="datepicks(this.id);" value="<?=$property->call_date?>">
                                                </div>
                                            </div>
                                          
                                            <input type="hidden" name="p_record_id_<?=$property->pid?>" id="p_record_id_<?=$property->pid?>" value="<?=$property->p_record_id?>">

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                  <div style="padding-top: 30px">
                                                  <button type="button" class="btn btn-primary" id="saveRemarks" name="saveRemarks" onclick="saveremarks('<?=$property->pid?>');">Save Remark</button>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>

                                       
                                      
                                    <? } else { 
                                        $accuracyCount = round($property->gpsaccuracy);
                                        $accuracyMsg = $accuracyCount>10?'Revisit Required':'Accuracy is good';
                                        ?>
                                         <div class="row">
                                            <div class="col-lg-12 col-md-12 ">
                                                <hr>
                                            </div>    
                                        </div>
                                        <div class="row" >
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Property ID</label>
                                                    <input type="text" class="form-control" name="pid" id="pid"  value="<?=$property->pid?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>QR-Code</label>
                                                    <input type="text" class="form-control" name="pid" id="pid"  value="<?=$property->qr_code?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Mobile No.</label>
                                                    <input type="text" class="form-control" name="mobile_no" id="mobile_no"  value="<?=$property->mobile_no?>" disabled="disabled" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Owner Name</label>
                                                    <input type="text" class="form-control" name="owner_name" id="owner_name"  value="<?=$property->owner_name?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Update Owner Name</label>
                                                    <input type="text" class="form-control" name="owner_apt_name_<?=$property->pid?>" 
                                                    id="owner_apt_name_<?=$property->pid?>" value="<?=$property->owner_apt_name?>" placeholder="Enter Owner Name">
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control" name="address_street" id="address_street"  value="<?=$property->address_street?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Update Address</label>
                                                    <input type="text" class="form-control" name="updated_address_<?=$property->pid?>" id="updated_address_<?=$property->pid?>" value="<?=$property->updated_address?>" placeholder="Enter Address">
                                                </div>
                                            </div>
                                        </div> 

					                   <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>House No.</label>
                                                    <input type="text" class="form-control" name="address_street" id="address_hno"  value="<?=$property->houseno?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Landmark</label>
                                                    <input type="text" class="form-control" name="address_street" id="address_landmark"  value="<?=$property->area_landmark?>" disabled="disabled" >
                                                </div>
                                            </div>
                                           
                                        </div> 
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Accuracy</label>
                                                    <input type="text" class="form-control" name="gpsaccuracy" id="gpsaccuracy"  value="<?=$property->gpsaccuracy?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Lat/Long</label>
                                                    <input type="text" class="form-control" name="latlong" id="latlong"  value="<?=$property->latitude?>/<?=$property->longitude?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Data capture date</label>
                                                    <input type="text" class="form-control" name="date_updated" id="date_updated"  value="<?=$property->date_updated?>" disabled="disabled" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                     <label>System Generated Remark</label>
                                                    <input type="text" class="form-control" name="sys_remark" id="sys_remark"  value="<?=$accuracyMsg?>" disabled="disabled" >
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Surveyor : <?=$property->first_name.' '.$property->last_name?></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Surveyor Mobile : <?=$property->mobile?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    
                                                    <label>Remark</label>
                                                    <input type="text" class="form-control" name="audit_remark_<?=$property->pid?>" id="audit_remark_<?=$property->pid?>"  value="<?=$property->audit_remark?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    
                                                    <label>Address Verification Remark</label>
                                                    <input type="text" class="form-control" name="addr_verification_<?=$property->pid?>" id="addr_verification_<?=$property->pid?>"  
                                                    value="<?=$property->address_verification_remark?>">
                                                </div>
                                            </div>
                                            
                                         </div>

                                         <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Audit Status</label>
                                                    <select name="isreject_<?=$property->pid?>" id="isreject_<?=$property->pid?>" class="form-control">
                                                        <option value="1" <?php if($property->isreject==1) {echo "selected=selected";} ?>>Reject</option>
                                                        <option value="0" <?php if($property->isreject==0) {echo "selected=selected";} ?>>Approved</option>

                                                    </select>    
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Call Status</label>
                                                    <select name="call_status_<?=$property->pid?>" id="call_status_<?=$property->pid?>" class="form-control">
                                                        <option value="1" <?php if($property->call_status==1) {echo "selected=selected";} ?>>Reject</option>
                                                        <option value="0" <?php if($property->call_status==0) {echo "selected=selected";} ?>>Approved</option>

                                                    </select>    
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Call Date</label>
                                                    <input type="text" class="form-control" name="call_date_<?=$property->pid?>" id="call_date_<?=$property->pid?>" onclick="datepicks(this.id);" value="<?=$property->call_date?>">
                                                </div>
                                            </div>
                                          
                                            <input type="hidden" name="p_record_id_<?=$property->pid?>" id="p_record_id_<?=$property->pid?>" value="<?=$property->p_record_id?>">

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                  <div style="padding-top: 30px">
                                                  <button type="button" class="btn btn-primary" id="saveRemarks" name="saveRemarks" onclick="saveremarks('<?=$property->pid?>');">Save Remark</button>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                       

                                    <? } ?>                                 </b>
                          
                  </div>
            </div>
                    
                </div>    
                
            </div>     
        </div>
    </div>
   
 <? } ?>     

