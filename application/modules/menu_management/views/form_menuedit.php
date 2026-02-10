<div class="row" style="padding-top:20px;">
    <div class="col-md-12">         
        <!-- start: DYNAMIC TABLE PANEL -->        
        <div class="panel panel-default">            
            <div class="panel-heading"> <i class="icon-external-link-sign"></i>&nbsp Menu Management                
                <div class="panel-tools"> 
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#"></a>
                    <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"><i class="icon-wrench"></i></a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#"><i class="icon-refresh"></i></a>
                    <a class="btn btn-xs btn-link panel-expand" href="#"><i class="icon-resize-full"></i></a>
                    <a class="btn btn-xs btn-link panel-close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <form  method="post" name="form" action="<?php echo site_url('menu_management/menu_update'); ?>" id="form"> 
                <div class="panel-body"> 
                    <div class="successHandler alert alert-success <?php if ($msg == "") { ?> no-display <?php } ?>"> 
                        <button class="close" data-dismiss="alert">                            ×                        </button>                        <i class="icon-ok-sign"></i> <?php echo $msg; ?> 
                    </div>       
                    <div class="successHandler alert alert-danger <?php if ($errmsg == "") { ?> no-display <?php } ?>"> <i class="icon-remove"></i> <?php echo $errmsg; ?> </div> 
                    <h2><i class="icon-edit-sign teal"></i> Update Menu</h2>
                    <div> 
                        <hr />  
                    </div>     
                    <?php
                    foreach ($menu->result() as $row) {
                        $menu_id = $row->MENU_ID;
                        $p_menu = $row->P_MENU_ID;
                        $sub_menu = $row->SUB_MENU;
                        $url = $row->URL;
                        $icon = $row->ICON;
                        $source = $row->SOURCE;
                        $order = $row->MENU_ORDER;
                        $mobile_menu = $row->MENU_SHOW_ON_MOBILE;
                    }
                    ?>  
                    <div class="row">     
                        <div class="col-md-12">    
                            <div class="row">   
                                <div class="col-md-6">
                                    <div class="form-group">  
                                        <label class="control-label"> Parent Menu </label>    
                                        <input type="hidden" id="m_id" name="m_id" value="<?php echo $menu_id; ?>">   
                                        <select class="form-control" id="drp_prt_menu" name="drp_prt_menu">  
                                            <option value="">select</option>                                            
                                            <?php foreach ($pmenu->result() as $row) { ?>       
                                                <option value="<?php echo $row->MENU_ID; ?>" <?php if ($p_menu == $row->MENU_ID) { ?> selected="selected" <?php } ?>><?php echo $row->SUB_MENU; ?></option>
                                            <?php } ?>     
                                        </select>                                 
                                    </div>           
                                </div> 
                            </div>              
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group">      
                                        <label class="control-label"> Sub Menu <span class="symbol required"> </span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_sub_menu" name="txt_sub_menu" value="<?php echo $sub_menu; ?>"/> 
                                    </div>
                                </div>  
                            </div>      
                            <div class="row">   
                                <div class="col-md-6">         
                                    <div class="form-group">
                                        <label class="control-label"> URL <span class="symbol required"></span> </label> 
                                        <input autocomplete="off" type="text" class="form-control" id="txt_url" name="txt_url"  value="<?php echo $url; ?>"/>   
                                    </div>      
                                </div> 
                            </div>    
                            <div class="row"> 
                                <div class="col-md-3">    
                                    <div class="form-group"> 
                                        <label class="control-label"> Icon <span class="symbol required"></span> </label>

                                        <input autocomplete="off" type="text" class="form-control" id="txt_icon" name="txt_icon"  value="<?php echo $icon; ?>"/>
                                    </div>   
                                </div>       
                                <div class="col-md-3">   
                                    <div class="form-group"> 
                                        <label class="control-label"> Status </label>  
                                        <select class="form-control" id="txt_source" name="txt_source">
                                            <option value="">select</option> 
                                            <option value="active" <?php if ($source == 'active') { ?> selected='selected' <?php } ?>>Active</option> 
                                            <option value="inactive" <?php if ($source == 'inactive') { ?> selected='selected' <?php } ?>>Inactive</option>                                        
                                        </select>    
                                    </div>                  
                                </div>              
                            </div>             
                            <div class="row">   
                                <div class="col-md-3"> 
                                    <div class="form-group"> 
                                        <label class="control-label"> Menu Order <span class="symbol required"></span> </label>
                                        <input autocomplete="off" type="text" class="form-control" id="txt_order" name="txt_order"  value="<?php echo $order; ?>"/> 
                                    </div>  
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label"> Mobile view <span class="symbol required"></span> </label>
                                        <select class="form-control" name="drp_mobile_view" id="drp_mobile_view">
                                            <option value="1" <?php if($mobile_menu == '1') { echo "selected"; } ?>>On</option>
                                            <option value="0" <?php if($mobile_menu == '0') { echo "selected"; } ?>>Off</option>
                                        </select>
                                    </div>
                                </div>  
                            </div>                          
                            <div class="row"> 
                                <div class="col-md-12">                    
                                    <div> 
                                        <span class="symbol required"></span>Required Fields    
                                        <hr />                      
                                    </div>  
                                </div>                       
                            </div>
                            <div class="row">                          
                                <div class="col-md-10">   
                                    <p> </p>                            
                                </div> 
                                <div class="col-md-2">                                
                                    <button class="btn btn-primary btn-block" type="submit"> Update <i class="icon-circle-arrow-right"></i> </button> 
                                </div> 
                            </div>
                        </div> 
                    </div> 
                    <!-- end: DYNAMIC TABLE PANEL -->  
                </div>  
            </form>    
        </div> 
    </div> 
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY --> </div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/form-validation/add_menu.js"></script>
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormValidator.init();
        FormElements.init();
    });
</script> 