<?php
$session_data = $this->session->userdata('logged_in');
if ($session_data['user_id'] == '') {
    redirect(base_url());
}
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <title><?php echo $title; ?></title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="<?php echo $meta_description; ?>" name="description" />
        <meta content="<?php echo $meta_author; ?>" name="author" />
        <!-- end: META -->
        <!-- start: MAIN CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css"  media="screen">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main-responsive.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/skins/all.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme_light.css" id="skin_color">

        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>


        <!--[if IE 7]>
        <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
        <![endif]-->
        <!-- end: MAIN CSS -->

        <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/css/datepicker.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jQuery-Tags-Input/jquery.tagsinput.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/summernote/build/summernote.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/ckeditor/contents.css">

        <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->

        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" />



        <script src='<?php echo base_url(); ?>assets/invoice/js/jquery-1.3.2.min.js'></script>
        <script src='<?php echo base_url(); ?>assets/invoice/js/example.js'></script>


        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>     
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>

        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/blockUI/jquery.blockUI.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/iCheck/jquery.icheck.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>



        <!-- end: MAIN JAVASCRIPTS -->


        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script src="<?php echo base_url(); ?>assets/plugins/jquery-inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/autosize/jquery.autosize.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/form-elements.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>    
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ui-modals.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/commits.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jQuery-Tags-Input/jquery.tagsinput.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/ckeditor/adapters/jquery.js"></script>

        <script src="<?php echo base_url(); ?>assets/plugins/summernote/build/summernote.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/form-validation/remove_quote.js"></script>

        <script>
            function lode_image_true()
            {
                document.getElementById("loading").style.display = "block";
            }
            function lode_image_false()
            {
                document.getElementById("loading").style.display = "none";
            }
        </script>



    </head>

    <!-- end: HEAD -->

    <!-- start: BODY -->

    <body>
        <!-- start: HEADER --> 

        <?php echo $header; ?> 

        <!-- end: HEADER --> 

        <!-- start: MAIN CONTAINER -->

        <div class="main-container">
            <div class="navbar-content"> 

                <!-- start: SIDEBAR -->

                <div class="main-navigation navbar-collapse collapse"> 

                    <!-- start: MAIN MENU TOGGLER BUTTON -->

                    <div class="navigation-toggler"> <i class="clip-chevron-left"></i> <i class="clip-chevron-right"></i> </div>

                    <!-- end: MAIN MENU TOGGLER BUTTON --> 

                    <!-- start: MAIN NAVIGATION MENU --> 

                    <?php echo $side_bar; ?> 

                    <!-- end: MAIN NAVIGATION MENU --> 

                </div>

                <!-- end: SIDEBAR --> 

            </div>

            <!-- start: PAGE -->

            <div class="main-content"> 

                <!-- start: PANEL CONFIGURATION MODAL FORM -->

                <div class="modal fade" id="panel-config" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                                <h4 class="modal-title">Panel Configuration</h4>
                            </div>
                            <div class="modal-body"> Here will be a configuration form </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                                <button type="button" class="btn btn-primary"> Save changes </button>
                            </div>
                        </div>

                        <!-- /.modal-content --> 

                    </div>

                    <!-- /.modal-dialog --> 

                </div>

                <!-- /.modal --> 

                <!-- end: SPANEL CONFIGURATION MODAL FORM -->

                <div class="container"> 

                    <!-- start: PAGE HEADER -->

                    <div class="row">
                        <div class="col-sm-12"> 

                            <!-- start: STYLE SELECTOR BOX --> 

                            <!-- end: STYLE SELECTOR BOX --> 

                            <!-- start: PAGE TITLE & BREADCRUMB -->

                            <ol class="breadcrumb">
                                <?php
                                $query = $this->db->query("SELECT LOCK_DATE	 FROM tbl_lockdate WHERE DEL_FALG=1");
                                $row = $query->row_array();
                                $lock_date = $row['LOCK_DATE'];
                                $lock_date = strtotime($lock_date);
                                $lock_date = date("d-m-Y", $lock_date);
                                ?>
                                <li class="active"> Lock Date :     <?php echo $lock_date; ?> </li>
                                <li class="active">
                                    <form class="sidebar-search" style="position: inherit;">
                                        <div class="form-group" style="padding-top: 6px; padding-left: 13px;">
                                          <!--<input autocomplete="off" type="text" placeholder="Start Searching...">
                                          <button class="submit"> <i class="clip-search-3"></i> </button> -->
                                            <?php
                                            $sess_data = $this->session->userdata('logged_in');
                                            $comp_code = $sess_data['comp_code'];
                                            $query1 = $this->db->query("SELECT `COMP_NAME` FROM `tbl_company` WHERE `ID`=$comp_code");
                                            $row1 = $query1->row_array();
//                                            $comp_name = $row1['COMP_NAME'];
                                            echo $row1['COMP_NAME'];
                                            ?>
                                        </div>
<!--                                        <div class="form-group" style="padding-top: 6px; padding-left: 13px;">
                                          <input autocomplete="off" type="text" placeholder="Start Searching...">
                                          <button class="submit"> <i class="clip-search-3"></i> </button> 
                                            <?php
                                            $sess_data = $this->session->userdata('logged_in');
                                            echo 'ACCOUNTING YEAR : ' . $sess_data['year_code'];
                                            ?>
                                        </div>-->
                                    </form>
                                </li>
                                <li class="search-box">
                                    <form class="sidebar-search">
<!--                                        <div class="form-group" style="padding-top: 6px; padding-left: 13px;">
                                          <input autocomplete="off" type="text" placeholder="Start Searching...">
                                          <button class="submit"> <i class="clip-search-3"></i> </button> 
                                            <?php
                                            $sess_data = $this->session->userdata('logged_in');
                                            $comp_code = $sess_data['comp_code'];
                                            $query1 = $this->db->query("SELECT `COMP_NAME` FROM `tbl_company` WHERE `ID`=$comp_code");
                                            $row1 = $query1->row_array();
//                                            $comp_name = $row1['COMP_NAME'];
                                            echo $row1['COMP_NAME'];
                                            ?>
                                        </div>-->
                                        <div class="form-group" style="padding-top: 6px; padding-left: 13px;">
                                          <!--<input autocomplete="off" type="text" placeholder="Start Searching...">
                                          <button class="submit"> <i class="clip-search-3"></i> </button> -->
                                            <?php
                                            $sess_data = $this->session->userdata('logged_in');
                                            echo 'ACCOUNTING YEAR : ' . $sess_data['year_code'];
                                            ?>
                                        </div>
                                    </form>
                                </li>
                            </ol>

                            <!-- end: PAGE TITLE & BREADCRUMB --> 

                        </div>
                    </div>

                    <!-- end: PAGE HEADER --> 

                    <!-- start: PAGE CONTENT --> 

                    <?php echo $content; ?> 

                    <!-- end: PAGE CONTENT--> 

                </div>
            </div>

            <!-- end: PAGE --> 

        </div>

        <!-- end: MAIN CONTAINER --> 

        <!-- start: FOOTER -->

        <?php echo $footer; ?>

        <!-- end: FOOTER --> 

        <!-- start: MAIN JAVASCRIPTS --> 

        <!--[if lt IE 9]>
        
                        <script src="assets/plugins/respond.min.js"></script>
        
                        <script src="assets/plugins/excanvas.min.js"></script>
        
                        <![endif]--> 

        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <div id="loading" style="display:none;" align="center" class="loader">
        </div>
    </body>

    <!-- end: BODY -->

</html>