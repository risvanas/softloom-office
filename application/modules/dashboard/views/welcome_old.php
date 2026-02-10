<style>
.btn {
	 font-size: 11px;
}
</style>
<script src="<?php echo base_url();?>chart/Chart.js"></script>
 

<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.css">
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		
 
 
 <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/skins/all.css">
<div class="row" style="padding-top:20px;">
  <div class="col-sm-12"> 
    <!-- start: INLINE TABS PANEL -->
    <div class="panel panel-default">
      <div class="panel-heading"> <i class="icon-reorder"></i> Dashboard
        <div class="panel-tools"> <a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a> <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal"> <i class="icon-wrench"></i> </a> <a class="btn btn-xs btn-link panel-refresh" href="#"> <i class="icon-refresh"></i> </a> <a class="btn btn-xs btn-link panel-expand" href="#"> <i class="icon-resize-full"></i> </a> <a class="btn btn-xs btn-link panel-close" href="#"> <i class="icon-remove"></i> </a> </div>
      </div>
  <div class="panel-body">
 
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
       <!-- <div class="row">
          <div class="col-sm-12">
            <div class="tabbable">
              <ul id="myTab" class="nav nav-tabs tab-primary">
                <li class="active"> <a href="#panel_tab2_example1" data-toggle="tab" onclick="show_salcanvas()"> <i class="green  clip-bars"></i>&nbsp;Sales </a> </li>
                <li> <a href="#panel_tab2_example1" data-toggle="tab" onclick="show_paycanvas()"> <i class="green  clip-bars"></i>&nbsp;Sales Receivable </a> </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane in active" id="panel_tab2_example1">
                  <div class="row">
                    <div class="col-sm-11" id="output">
                      <canvas id="salcanvas"></canvas>
                      
                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>-->
		<div class="row">
						<div class="col-sm-12">
						<div class="row">
								
						
						<div class="col-sm-7">
						
						
						<?php
						$date=date('Y-m-d');
						$openings=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '39'
			  	AND tbl_transaction.DATE_OF_TRANSACTION <= '$date' "); 
				$balance=$this->db->query("SELECT OPENING_BALANCE AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID='39'");
				
				$opening=$openings->row_array();
				$balance1=$balance->row_array();
				$opening['opening'];
				$balance1['balance'];
				$data =  $balance1['balance'] + $opening['opening'] ;
				
				
				$openings2=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '40'
			  	AND tbl_transaction.DATE_OF_TRANSACTION <= '$date' "); 
				$balance2=$this->db->query("SELECT OPENING_BALANCE AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID='40'");
				
				$opening2=$openings2->row_array();
				$balance3=$balance2->row_array();
				$opening2['opening'];
				$balance3['balance'];
				$data1 =  $balance3['balance'] + $opening2['opening'] ;
				
				
				$openings3=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  '41'
			  	AND tbl_transaction.DATE_OF_TRANSACTION < '$date' "); 
				$balance3=$this->db->query("SELECT OPENING_BALANCE AS balance FROM tbl_account WHERE tbl_account.DEL_FLAG='1' AND tbl_account.ACC_ID='41'");
				
				$opening3=$openings3->row_array();
				$balance4=$balance3->row_array();
				$opening3['opening'];
				$balance4['balance'];
				$data2 =  $balance4['balance'] + $opening3['opening'] ;
				?>
				
				
				<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-calendar"></i>
									Asset Details
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="icon-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="icon-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="icon-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="icon-remove"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
				<div class="row">
				
				  <div class="col-md-3">
											<div class="btn btn-yellow btn-block">Cash <span>&#2352;&nbsp;<?php echo $data; ?></span></div>
											</div>
											
											
										<div class="col-md-3" >	
											<div class="btn btn-yellow btn-block">Axis <span>&#2352;&nbsp;<?php echo $data1; ?></span></div>
											
											
											
											</div>
											
											
										<div class="col-md-3" >	
											<div class="btn btn-yellow btn-block">SBT <span>&#2352;&nbsp;<?php echo $data2; ?></span></div>
						
						</div>
						<?php
						$sum=$data+$data1+$data2;
						?>
					 <div class="col-md-3" >
											<div class="btn btn-success btn-block">Total <span>&#2352;&nbsp;<?php echo $sum; ?></span></div>
											</div>
						</div>

							
							</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-calendar"></i>
									Calendar
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="icon-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="icon-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-expand" href="#">
											<i class="icon-resize-full"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="icon-remove"></i>
										</a>
									</div>
								</div>
								<div class="panel-body">
									<div id='calendar'></div>
								</div>
							</div>
						</div>
						<div class="col-sm-5">
						
						<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-checkbox"></i>
									Last Login Details
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="icon-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="icon-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="icon-remove"></i>
										</a>
									</div>
								</div>
								<div class="panel-body panel-scroll" style="height:280px">
								<ul class="todo">
								<?php
								 $sess_data=$this->session->userdata('logged_in');
								 $user_id=$sess_data['user_id'];
								  $sql1="select * from tbl_logindetails join tbl_user on tbl_logindetails.USER= tbl_user.USER_ID where tbl_logindetails.DEL_FLAG=1 and USER=$user_id order by tbl_logindetails.DATE_TIME desc limit 10";
								  $query1=$this->db->query($sql1);
								  foreach($query1->result() as $val)
								  {
                
               
$utc_time_zone = "Asia/Calcutta";//date_default_timezone_get();
$utc_time = $val->DATE_TIME;
                
                $utc_time = date("Y-m-d G:i", strtotime($utc_time));
                
                $utc_date = DateTime::createFromFormat('Y-m-d G:i', $utc_time, new DateTimeZone('UTC'));
                $nyc_date = $utc_date;
                $nyc_date->setTimeZone(new DateTimeZone($utc_time_zone));
                $date1=$nyc_date->format('j M Y g:i A'); // output: 5 Jan 2017 7:24 PM
				?>
                    <li>
											<a class="todo-actions" href="javascript:void(0)">
												<i class="icon-check-empty"></i>
												<span class="desc" style="opacity: 1; text-decoration: none;"><?php echo $val->DEVICE; ?></span>
												<span class="label label-danger" style="opacity: 1;"> <?php echo $date1; ?></span>
											</a>
										</li>
<?php									 
								  }
								?>
								</ul>
						</div></div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-checkbox"></i>
									Pending Invoice
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
										</a>
										<a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
											<i class="icon-wrench"></i>
										</a>
										<a class="btn btn-xs btn-link panel-refresh" href="#">
											<i class="icon-refresh"></i>
										</a>
										<a class="btn btn-xs btn-link panel-close" href="#">
											<i class="icon-remove"></i>
										</a>
									</div>
								</div>
								<div class="panel-body panel-scroll" style="height:300px">
								<ul class="todo">
								<?php
		$sql="select ACC_NAME,ACC_ID from tbl_account where PARENT_ACC_ID=47 AND DEL_FLAG=1 order by ACC_NAME asc";
		$result=$this->db->query($sql);
		$i=1;
		$sum_p=0;
		foreach($result->result() as $row)
		 {
			 $id=$row->ACC_ID;
			 $openings=$this->db->query("SELECT IFNULL( SUM( DEBIT ) , 0 ) - IFNULL( SUM( CREDIT ) , 0 ) AS opening
			  	FROM tbl_transaction
			 	WHERE tbl_transaction.DEL_FLAG =  '1'
			  	AND tbl_transaction.ACC_ID =  47
				AND tbl_transaction.SUB_ACC =  $id"); 
				
				
				$opening=$openings->row_array();
				$sum_p+=$opening['opening'];
                if($opening['opening'] > 0)
				{
				?>
			
				<li>
											<a class="todo-actions" href="javascript:void(0)">
												<i class="icon-check-empty"></i>
												<span class="desc" style="opacity: 1; text-decoration: none;"><?php echo $row->ACC_NAME; ?></span>
												<span class="label label-danger" style="opacity: 1;"> <?php echo $opening['opening']; ?></span>
											</a>
										</li> <?php }
				elseif($opening['opening'] < 0)
				       {
				?>
			
				<li>
											<a class="todo-actions" href="javascript:void(0)">
												<i class="icon-check-empty"></i>
												<span class="desc"><?php echo $row->ACC_NAME; ?></span>
												<span class="label label-warning"> <?php echo $opening['opening']; ?></span>
											</a>
										</li> <?php }

			$i++;
		 }  ?>
									
						<li>
											<a class="todo-actions" href="javascript:void(0)">
												<i class="icon-check-empty"></i>
												<span class="desc"><?php echo "Total"; ?></span>
												<span class="label label-warning"> <?php echo $sum_p; ?></span>
											</a>
										</li>				
									
									</ul>
								</div>
							</div>
						</div>

							
						 
						</div></div></div>

      </div>
    </div>
    <!-- end: INLINE TABS PANEL --> 
  </div>
</div>

		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.pie.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/flot/jquery.flot.resize.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/jquery.sparkline/jquery.sparkline.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/bootstrap-colorpicker/js/commits.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.js"></script>
		
<script>
			jQuery(document).ready(function() {
				Main.init();
				Index.init();
			});
			
			
			
			var Index = function () {
    // function to initiate Chart 1
    
    // function to initiate Chart 2
    
    // function to initiate Chart 3
    
    // function to initiate Sparkline
    
    // function to initiate EasyPieChart
    
    // function to initiate Full Calendar
    var runFullCalendar = function () {
        //calendar
        /* initialize the calendar
		 -----------------------------------------------------------------*/
        var $modal = $('#event-management');
        $('#event-categories div.event-category').each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 50 //  original position after the drag
            });
        });
        /* initialize the calendar
		 -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
		
		
		<?php
          $date=date('Y');
		  $date=$date.'-09-14';
		  $date=date('Y-m-d',strtotime($date));
	  
		?>
		var jomi ='<?php echo $date ?>';
		<?php
          $date1=date('Y');
		  $date1=$date1.'-01-01';
		  $date1=date('Y-m-d',strtotime($date1));
	  
		?>
		var gil ='<?php echo $date1 ?>';
		
		
		<?php
          $date2=date('Y');
		  $date2=$date2.'-01-01';
		  $date2=date('Y-m-d',strtotime($date2));
	  
		?>
		var brahma ='<?php echo $date2 ?>';
		<?php
          $date3=date('Y');
		  $date3=$date3.'-09-27';
		  $date3=date('Y-m-d',strtotime($date3));
	  
		?>
		var sunees ='<?php echo $date3 ?>';
		
		
		<?php
          $date4=date('Y');
		  $date4=$date4.'-03-29';
		  $date4=date('Y-m-d',strtotime($date4));
	  
		?>
		var elizabeth ='<?php echo $date4 ?>';
		<?php
          $date5=date('Y');
		  $date5=$date5.'-12-28';
		  $date5=date('Y-m-d',strtotime($date5));
	  
		?>
		var aparna ='<?php echo $date5 ?>';
		
		<?php
          $date6=date('Y');
		  $date6=$date6.'-05-05';
		  $date6=date('Y-m-d',strtotime($date6));
	  
		?>
		var jisa ='<?php echo $date6 ?>';
		<?php
          $date7=date('Y');
		  $date7=$date7.'-01-01';
		  $date7=date('Y-m-d',strtotime($date7));
	  
		?>
		var beena ='<?php echo $date7 ?>';
		
        var form = '';
        var calendar = $('#calendar').fullCalendar({
            buttonText: {
                prev: '<i class="icon-chevron-left"></i>',
                next: '<i class="icon-chevron-right"></i>'
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: [
			
			{
                title: 'Jomy Joseph Birthday',
                start: new Date(jomi),
                className: 'label-default'
            },
	        {
                title: 'Gil George Birthday',
                start: new Date(gil),
                className: 'label-default'
            },
			{
                title: 'Brahmadas R.I Birthday',
                start: new Date(brahma),
                className: 'label-default'
            },
	        {
                title: 'Suneesh S Sharma Birthday',
                start: new Date(sunees),
                className: 'label-default'
            },
			{
                title: 'Elizabeth Joseph Birthday',
                start: new Date(elizabeth),
                className: 'label-default'
            },
	        {
                title: 'Aparna Sarma Birthday',
                start: new Date(aparna),
                className: 'label-default'
            },
			{
                title: 'jisha u.a Birthday',
                start: new Date(jisa),
                className: 'label-default'
            },
	        {
                title: 'Bena C M Birthday',
                start: new Date(beena),
                className: 'label-default'
            }
			],
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped
                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');
                var $categoryClass = $(this).attr('data-class');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                if ($categoryClass)
                    copiedEventObject['className'] = [$categoryClass];
                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                $modal.modal({
                    backdrop: 'static'
                });
                form = $("<form></form>");
                form.append("<div class='row'></div>");
                form.find(".row").append("<div class='col-md-6'><div class='form-group'><label class='control-label'>New Event Name</label><input class='form-control' placeholder='Insert Event Name' type=text name='title'/></div></div>").append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>").find("select[name='category']").append("<option value='label-default'>Work</option>").append("<option value='label-green'>Home</option>").append("<option value='label-purple'>Holidays</option>").append("<option value='label-orange'>Party</option>").append("<option value='label-yellow'>Birthday</option>").append("<option value='label-teal'>Generic</option>").append("<option value='label-beige'>To Do</option>");
                $modal.find('.remove-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                    form.submit();
                });
                $modal.find('form').on('submit', function () {
                    title = form.find("input[name='title']").val();
                    $categoryClass = form.find("select[name='category'] option:checked").val();
                    if (title !== null) {
                        calendar.fullCalendar('renderEvent', {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay,
                                className: $categoryClass
                            }, true // make the event "stick"
                        );
                    }
                    $modal.modal('hide');
                    return false;
                });
                calendar.fullCalendar('unselect');
            },
            eventClick: function (calEvent, jsEvent, view) {
                var form = $("<form></form>");
                form.append("<label>Change event name</label>");
                form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success'><i class='icon-ok'></i> Save</button></span></div>");
                $modal.modal({
                    backdrop: 'static'
                });
                $modal.find('.remove-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.remove-event').unbind('click').click(function () {
                    calendar.fullCalendar('removeEvents', function (ev) {
                        return (ev._id == calEvent._id);
                    });
                    $modal.modal('hide');
                });
                $modal.find('form').on('submit', function () {
                    calEvent.title = form.find("input[type=text]").val();
                    calendar.fullCalendar('updateEvent', calEvent);
                    $modal.modal('hide');
                    return false;
                });
            }
        });
    };
    return {
        init: function () {
            
            runFullCalendar();
        }
    };
}();
		</script>