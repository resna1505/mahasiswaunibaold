<?php

//Selecting events records from events table
    //Selecting events records from events table
    $query = mysql_query("SELECT * FROM pengumuman");
    $data  = array(); 
    $resp = array();
    $i             = 0;
    $row         = mysqli_num_rows($query);
    if($row > 0){
        while($data['events'] = mysql_fetch_assoc($query))
        {
			$i++;
            //Geting event days
            $start = date("Y-m-d",strtotime($data['events']['TANGGALAWAL']));//die;
            $timestamp_start = strtotime($start);
            $end = date("Y-m-d",strtotime($data['events']['TANGGALAKHIR']));
            $timestamp_end = strtotime($end);
            $diff = abs($timestamp_end - $timestamp_start); // that's it!
            
            $days = floor($diff/(60*60*24));
            $days = $days+1;
            //Defining colors to events
            if($days == 1){
                $color='#FFDAB9';
            }elseif($days > 1 and $days <= 15){
                $color='#8FBC8F';
            }elseif($days > 15 and $days <= 30){
                $color='#C0C0C0';
            }elseif($days > 30 and $days <= 60){
                $color='#90EE90';
            }else{
                $color='#F4A460';
            }
            //Creating event short name with ...
            if(!empty($data['events']['JUDUL'])){
                for ($i = 1; $i <= $days; $i++) {
                    $add_day = $i - 1;
                    $start = date('Y-m-d', strtotime("+{$add_day} day", $timestamp_start));
                    $event_short_name = $data['events']['JUDUL'];
                   
                    #$event_short_name .= ' - ('.$i.$sub.' Day)';
                    
                    $startDate = strtotime($start);
                    //Colecting data in array         
                    $resp[$start . '_' . $data['events']['ID'] . '_' . $i] = array(
                        'id'    => $data['events']['ID'],
                        'title' => $event_short_name,
						'description' => strip_tags(html_entity_decode($data['events']['RINCIAN'])),
                        'start' => $start,
                        'color' => $color,
                    );
                }
            }            
        }
        $resp = array_values($resp);
    }
echo "\r\n<script language=\"javascript\" type=\"text/javascript\" src=\"../tiny_mce/init_tiny_mce.js\"></script>\r\n";
#echo "<script src='../tampilan/default/assets/app/js/dashboard.js' type='text/javascript'></script>";
?>
<script>
	$(document).ready(function() {
    $('#m_calendar').fullCalendar({
		themeSystem: 'bootstrap4',
		
        defaultView: 'month',
		editable: false,
        events: <?php echo json_encode($resp)?>,
        eventRender: function(eventObj, $el) {
			$el.popover({
			  content: eventObj.description,
			  trigger: 'hover',
			  placement: 'top',
			  container: 'body'
			});
		  },
    });
	
});    
</script>

<?php
echo "PILIHANNYA".$pilihan;
echo "<div class=\"m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body\">
				<div class=\"m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-container m-container--responsive m-container--xxl m-container--full-height\">
					<div class=\"m-grid__item m-grid__item--fluid m-wrapper\">
						<!-- BEGIN: Subheader -->
						<div class=\"m-subheader \">
							<div class=\"d-flex align-items-center\">
								<div class=\"mr-auto\">
									<h3 class=\"m-subheader__title \">
										Dashboard
									</h3>
								</div>
								<div>
									<span class=\"m-subheader__daterange\" id=\"m_dashboard_daterangepicker\">
										<span class=\"m-subheader__daterange-label\">
											<span class=\"m-subheader__daterange-title\"></span>
											<span class=\"m-subheader__daterange-date m--font-brand\"></span>
										</span>
										<a href=\"#\" class=\"btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill\">
											<i class=\"la la-angle-down\"></i>
										</a>
									</span>
								</div>
							</div>
						</div>
						<!-- END: Subheader -->"; 	
echo "<div class=\"m-content\"><div class=\"row\">
							<div class=\"col-xl-12\">
								<!--begin::Portlet-->
								<div class=\"m-portlet \" id=\"m_portlet\">
									<div class=\"m-portlet__head\">
										<div class=\"m-portlet__head-caption\">
											<div class=\"m-portlet__head-title\">
												<span class=\"m-portlet__head-icon\">
													<i class=\"flaticon-map-location\"></i>
												</span>
												<h3 class=\"m-portlet__head-text\">
													Calendar
												</h3>
											</div>
										</div>
										
									</div>
									<div class=\"m-portlet__body\">
										<div id=\"m_calendar\"></div>
									</div>
								</div>
								<!--end::Portlet-->
							</div>
						</div>
						<!--End::Section-->
	
";?>
