<?php
/*----------------------------------------
/* Note: For non-English translations to
/* the datepicker, please be sure that
/* the text encoding of this file is set
/* to the "UTF-8" option, if issues arise.
/*--------------------------------------*/

//Woo Settings
$woo_calendar_formatting = get_option('woo_calendar_formatting');
$woo_booking_form = get_option('woo_booking_form');
$woo_start_calendar_range = get_option('woo_start_calendar_range');
$woo_end_calendar_range = get_option('woo_end_calendar_range');
$woo_events_category = get_option('woo_events_category');
$woo_events_ical_export = get_option('woo_events_ical_export');
$woo_booking_form_external_url = get_option('woo_booking_form_external_url');
$woo_booking_form_page = get_option('woo_booking_form_page');
$today = date("m\/d\/Y");
?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
			//JQUERY UI DATEPICKER
			if (jQuery('#events_calendar').length) {
				var startRangeDate=new Date('<?php echo $woo_start_calendar_range; ?>');
				var endRangeDate=new Date('<?php echo $woo_end_calendar_range; ?>');
				//CHECK if Calendar has been setup correctly
				if (endRangeDate > startRangeDate) {
					var defaultDate;
					jQuery('#events_calendar').datepicker({
						dateFormat: '<?php echo $woo_calendar_formatting; ?>',
						minDate: startRangeDate, 
						maxDate: endRangeDate,
						defaultDate: +0,
						onSelect: function(dateText, inst) {
							showEvents(dateText, inst);
						}
					});
					//Default UpComing Events
					showUpcomingEvents();
					//highlightEvents();
					
				}
				else {
					jQuery('#message-none').removeClass('hide');
					jQuery('#message-none').text('<?php _e('Please setup the event calendar theme options in the backend correctly.', 'woothemes'); ?>');
				}
				
					
			}
			
			jQuery('.add-calendar').each(function(){
				jQuery(this).parent().find('ul').hide();
				jQuery(this).click(function() {
  					jQuery(this).parent().find('ul').toggle();
				});
				jQuery(this).parent().find('ul li').each(function() {	
  					jQuery(this).find('a').click(function() {
  						jQuery(this).parent().parent().hide();
					});
				});
			});
			
			
	});
	
	jQuery(document).ready(function(){
		//resetCalendarClickers();
	});
	
	//reset the jquery on month change
	function resetCalendarClickers() {

		//Next Month button
		if (jQuery('.ui-datepicker-next').attr('onClick') !== undefined) {
    		// attribute exists
			
			var currentOnClickJS = jQuery('.ui-datepicker-next').attr('onClick');

			jQuery('.ui-datepicker-next').removeAttr('onclick');
			
			jQuery('.ui-datepicker-next').bind('click', function () { DP_jQuery.datepicker._adjustDate('#events_calendar', +1, 'M'); highlightEvents(); } );
			
			/*
    		var currentOnClickJS = jQuery('.ui-datepicker-next').attr('onClick');
    		currentOnClickJS = currentOnClickJS.toString() + 'highlightEvents();';
    		jQuery('.ui-datepicker-next').attr('onClick',currentOnClickJS);
			*/
		} 
		else {
   			// attribute does not exist
   			
		}

		//Previous Month button
		if (jQuery('.ui-datepicker-prev').attr('onClick') !== undefined) {
    		// attribute exists
			
			var currentOnClickJS = jQuery('.ui-datepicker-prev').attr('onClick');

			jQuery('.ui-datepicker-prev').removeAttr('onclick');
			
			jQuery('.ui-datepicker-prev').bind('click', function () { DP_jQuery.datepicker._adjustDate('#events_calendar', -1, 'M'); highlightEvents(); } );
			
			/*
    		var currentOnClickJS = jQuery('.ui-datepicker-prev').attr('onClick');
    		currentOnClickJS = currentOnClickJS.toString() + 'highlightEvents();';
    		jQuery('.ui-datepicker-prev').attr('onClick',currentOnClickJS);
			*/
		} 
		else {
   			// attribute does not exist
		}
		
		jQuery('.ui-datepicker-calendar a.ui-state-default').each(function (){
			
			if (jQuery(this).parent().attr('onClick') !== undefined) {
    			// attribute exists
    			
				var currentOnClickJS = jQuery(this).parent().attr('onClick');
				var functionData = currentOnClickJS.toString().split(',');
				
				var monthNum = functionData[1];
				var yearNum = functionData[2];
				
				jQuery(this).parent().removeAttr('onclick');

				jQuery(this).parent().bind('click', function () {
					
					DP_jQuery.datepicker._selectDay('#events_calendar',monthNum,yearNum, this);
					highlightEvents();
					return false;
				
				} );
				/*
				var currentOnClickJS = jQuery(this).parent().attr('onClick');
    			var strcurrentOnClickJS = currentOnClickJS.toString();
    			var brokenstring = strcurrentOnClickJS.split(';'); 
  			
  				var stringpart1 = brokenstring[0];
  				var stringpart2 = brokenstring[1];
  				
    			strcurrentOnClickJS = stringpart1.toString() + ';highlightEvents();' + stringpart2.toString() + ';';
    			jQuery(this).parent().attr('onClick',strcurrentOnClickJS);
				*/
			} 
			else {
   				// attribute does not exist
			}
		});
		
		
		resetCalendarDayClickers();
		
	}
	
	function resetCalendarDayClickers() {
		jQuery('.ui-datepicker-calendar a.ui-state-default').each(function (){
		
			if ((jQuery(this).hasClass('ui-state-highlight')) || (jQuery(this).hasClass('ui-state-active'))) {
				//Remove href attribute
				jQuery(this).removeAttr('href');
			}
			else {
				jQuery(this).parent().addClass('ui-datepicker-unselectable ui-state-disabled');
				jQuery(this).removeAttr('href');
			}
			
			if ((jQuery(this).hasClass('ui-state-highlight')) && (jQuery(this).parent().hasClass('ui-datepicker-today'))) {
				//check if has events for todays date
				var currentDate = new Date('<?php echo $today ?>');
				var datepickermonth = jQuery('span.ui-datepicker-month').text();
				var datepickeryear = jQuery('span.ui-datepicker-year').text();
				var hasevents = false;

				jQuery('#events-calendar div.event').each(function (){
					var startDateRaw = jQuery(this).find('p.date span.startdate').text();
					var startDate = new Date(startDateRaw);
					//Check for End Date
					if (jQuery(this).find('p.date span.enddate').text().length) {
						
						var endDateRaw = jQuery(this).find('p.date span.enddate').text();
						var endDate = new Date(endDateRaw);
					
						date1 = currentDate;
						date2 = startDate;
						date3 = endDate;
						
						if ( (date1.valueOf() >= date2.valueOf()) && (date1.valueOf() <= date3.valueOf()) ) {
							hasevents = true;
						}
						else {
							//Do Nothing
						}
						
					}
					else {
					
						date1 = currentDate;
						date2 = startDate;
						if (date1.valueOf() == date2.valueOf()) {
							hasevents = true;
						}
						else {
							//Do Nothing
						}
					}
						
				});
				
				//Check if has events for today
				if (hasevents) {
					//Do Not remove highlighting
					jQuery(this).removeClass('ui-state-hover');
				}
				else {
					//Remove highlighting from today
					jQuery(this).parent().addClass('ui-datepicker-unselectable ui-state-disabled');
					jQuery(this).removeClass('ui-state-highlight');
				}
				
			}
				
		});
	}
	
	//Highlights all event dates in the calendar
	function highlightEvents() {

		var eventDates=new Array();
		//Iterate through all the events
		jQuery('#events-calendar div.event').each(function (){
			//Add start date to the array
			var startDateRaw = jQuery(this).find('p.date span.startdate').text();
			var startDate = new Date(startDateRaw);
			var startDay = startDate.getDate();
			var startMonth = startDate.getMonth();
			var startYear = startDate.getFullYear();
			eventDates.push(startYear + '/' + (startMonth + 1) + '/' + startDay);
			//Add end date to the array
			if (jQuery(this).find('p.date span.enddate').text().length) {
				var endDateRaw = jQuery(this).find('p.date span.enddate').text();
				var endDate = new Date(endDateRaw);
				var endDay = endDate.getDate();
				var endMonth = endDate.getMonth();
				var endYear = endDate.getFullYear();
				eventDates.push(endYear + '/' + (endMonth + 1) + '/' + endDay);
			
				date1 = endDate;
  				date2 = startDate;
				while (date1 > date2)
  				{
  					
					date2.setDate(date2.getDate()+1);
  					// The number of milliseconds in one day
    				var ONE_DAY = 1000 * 60 * 60 * 24;
    				// Convert both dates to milliseconds
    				var date1_ms = endDate.getTime();
    				var date2_ms = startDate.getTime();
    				// Calculate the difference in milliseconds
    				var difference_ms = Math.abs(date1_ms - date2_ms);
    				// Convert back to days and return
    				var daysInBetween = Math.round(difference_ms/ONE_DAY);
					//Add date to the array
					var date2Day = date2.getDate();
					var date2Month = date2.getMonth();
					var date2Year = date2.getFullYear();
					eventDates.push(date2Year + '/' + (date2Month + 1) + '/' + date2Day);
			
  				}
			}
			
  			
						
		});
		
		//Sort the events data
		var sortedEvents = arrayUnique(eventDates.sort());
		//alert(sortedEvents);
		
		var currentDate = new Date(jQuery('#events_calendar').datepicker('getDate'));
		var calendarYear = jQuery('span.ui-datepicker-year').text();
		var calendarMonth = jQuery('span.ui-datepicker-month').text();
		//jQuery('a.ui-state-default');
		//alert(calendarMonth);
		//alert ( currentDate );
		//Iterate through all the calendar dates
		
		for (x in sortedEvents)
  		{
  			var eventItem =sortedEvents[x];
  			var streventItem = eventItem.toString();
  			var brokenstring = streventItem.split('/'); 
  			
  			var eventYear = brokenstring[0];
  			var eventMonth = brokenstring[1];
  			var eventDay = brokenstring[2];
  			
  			//alert(typeof eventMonth);
  			
  			switch(eventMonth)
			{
				case '1':
  					eventMonth = '<?php _e('January', 'woothemes') ?>';
  					break;
				case '2':
  					eventMonth = '<?php _e('February', 'woothemes') ?>';
  					break;
				case '3':
  					eventMonth = '<?php _e('March', 'woothemes') ?>';
  					break;
				case '4':
  					eventMonth = '<?php _e('April', 'woothemes') ?>';
  					break;
				case '5':
  					eventMonth = '<?php _e('May', 'woothemes') ?>';
  					break;
				case '6':
  					eventMonth = '<?php _e('June', 'woothemes') ?>';
  					break;
				case '7':
  					eventMonth = '<?php _e('July', 'woothemes') ?>';
  					break;
				case '8':
  					eventMonth = '<?php _e('August', 'woothemes') ?>';
  					break;
				case '9':
  					eventMonth = '<?php _e('September', 'woothemes') ?>';
  					break;
				case '10':
  					eventMonth = '<?php _e('October', 'woothemes') ?>';
  					break;
				case '11':
  					eventMonth = '<?php _e('November', 'woothemes') ?>';
  					break;
				case '12':
  					eventMonth = '<?php _e('December', 'woothemes') ?>';
  					break;
				default:
  					eventMonth = '<?php _e('January', 'woothemes') ?>';
			}
			
			if (eventMonth == calendarMonth) {
				
				jQuery('.ui-datepicker-calendar a.ui-state-default').each(function (){
					var calendarDay = jQuery(this).text();
					//alert(jQuery(this).text());
					//alert (typeof calendarDay);
					//alert (typeof eventDay);
					if (calendarDay == eventDay) {
						jQuery(this).addClass('ui-state-highlight');
					}
					else {
						//jQuery(this).parent().removeAttr('onClick');
					}
				
				});
				
			}
  		}
		

		//Add highlight class to the calendar dates that match the events
		resetCalendarClickers();
	}
	
	//Removes duplicate Array values
	function arrayUnique(arrayName) {
    	var a = [];
    	var l = arrayName.length;
    	for(var i=0; i<l; i++) {
      	for(var j=i+1; j<l; j++) {
        	// If arrayName[i] is found later in the array
        	if (arrayName[i] === arrayName[j])
         	j = ++i;
      	}
      	a.push(arrayName[i]);
    	}
    	return a;
	}
	
	//Hides all event items from view
	function hideAllEvents() {
	
		jQuery('#events-calendar div.event-outer').each(function (){
			if (jQuery(this).hasClass('hide')) {
				//DO NOTHING
			}
			else {
				jQuery(this).addClass('hide');
			}
		});
		
	}
	
	//Displays relevant event items
	function showEvents(dateText, inst) {
		
		var dateCalendar = new Date(dateText);
		//Prepare events
		hideAllEvents();
		//alert(dateCalendar);
		var globalcount = 0;
		//Iterate through event items
		jQuery('#events-calendar div.event p.date span.startdate').each(function (){
			var rawDateEvent = jQuery(this).text();
			var dateEvent = new Date(rawDateEvent);
			var eventEndDateRaw = jQuery(this).parent().find('span.enddate').text();
			var eventEndDate = new Date(eventEndDateRaw);
			
			
			//Compare dates
			if (dateEvent.valueOf() == dateCalendar.valueOf()) {
				if (jQuery(this).parent().parent().parent().hasClass('hide')) {
					jQuery(this).parent().parent().parent().removeClass('hide');
					globalcount++;
				}
				else {
					//DO NOTHING
				}	
			}
			else if (eventEndDateRaw !== undefined) {
				//alert('test');
				if ((dateCalendar.valueOf() > dateEvent.valueOf()) && (dateCalendar.valueOf() <= eventEndDate.valueOf())) {
					if (jQuery(this).parent().parent().parent().hasClass('hide')) {
						jQuery(this).parent().parent().parent().removeClass('hide');
						globalcount++;
					}
					else {
						//DO NOTHING
					}
				}
			}
			else {
				//DO NOTHING
			}	
	
		});
		
		//Validation Message Output
		if (globalcount == 0) {
			showNoEvents();
		}
		else {
			if (jQuery('#message-none').hasClass('hide')) {
				//DO NOTHING
			}
			else {
				jQuery('#message-none').addClass('hide');
			}
			
			if (jQuery('#message-upcoming').hasClass('hide')) {
				//DO NOTHING
			}
			else {
				jQuery('#message-upcoming').addClass('hide');
			}
			
		}
		//alert(jQuery('#calendar h2 span').text());
		var selectedDate = jQuery('#events_calendar').datepicker('getDate');
		var selectedMonth = monthText(selectedDate);
		jQuery('#calendar h2 span').text(selectedMonth);
		highlightEvents();
	}
	
	//Returns Month Name in text format
	function monthText(dateText) {
		var d=new Date(dateText);
		var month=new Array(12);
		month[0]="<?php _e('January', 'woothemes') ?>";
		month[1]="<?php _e('February', 'woothemes') ?>";
		month[2]="<?php _e('March', 'woothemes') ?>";
		month[3]="<?php _e('April', 'woothemes') ?>";
		month[4]="<?php _e('May', 'woothemes') ?>";
		month[5]="<?php _e('June', 'woothemes') ?>";
		month[6]="<?php _e('July', 'woothemes') ?>";
		month[7]="<?php _e('August', 'woothemes') ?>";
		month[8]="<?php _e('September', 'woothemes') ?>";
		month[9]="<?php _e('October', 'woothemes') ?>";
		month[10]="<?php _e('November', 'woothemes') ?>";
		month[11]="<?php _e('December', 'woothemes') ?>";
		var formattedDate = month[d.getMonth()];
		return formattedDate;
	}
	
	//Shows error messages
	function showNoEvents() {
		
		if (jQuery('#message-none').hasClass('hide')) {
			jQuery('#message-none').removeClass('hide');
		}
		else {
			//DO NOTHING
		}
		
		if (jQuery('#message-upcoming').hasClass('hide')) {
			//DO NOTHING
		}
		else {
			jQuery('#message-upcoming').addClass('hide');
		}
		
	}
	
	//Shows Upcoming Events		
	function showUpcomingEvents() {
				
		var count = 0;
		var nextDate;
		
		var currentDate = new Date(jQuery('#events_calendar').datepicker('getDate'));
		
		//Iterate through event items
		jQuery('#events-calendar div.event p.date span.startdate').each(function (){
			var dateEvent = new Date(jQuery(this).text())
			var rawDateEvent = jQuery(this).text();
			var rawDateEnd = jQuery(this).parent().find('span.enddate').text();
				
			//check if there isnt an end date for this event
			if (rawDateEnd == '') {
				var dateEnd = '';
			}
			else {
				var dateEnd = new Date(rawDateEnd);
			}
			
			//check if end date is defined
			if (dateEnd != '') {
				//if event start or end date equals todays date
				if ( (dateEvent.valueOf() == currentDate.valueOf()) || (dateEnd.valueOf() == currentDate.valueOf()) ) {
					nextDate = dateEvent;	
				}
				else {
					// if start date less than todays date and end date great than todays date
					if ( (dateEvent.valueOf() <= currentDate.valueOf()) && (dateEnd.valueOf() >= currentDate.valueOf())  ) {
					
						if (nextDate == undefined) {
							nextDate = dateEvent;
							
						}
					}
					else {
					
						//Default comparison
						if ( dateEvent.valueOf() >= currentDate.valueOf() ) {
						
							if (nextDate == undefined) {
							
								nextDate = dateEvent;
							}
						}
					}
				}
			} 
			else {
			
				//if event start date equals todays date
				if ( dateEvent.valueOf() == currentDate.valueOf() ) {
					nextDate = dateEvent;
				}
				else {
					//Default comparison
					if ( dateEvent.valueOf() >= currentDate.valueOf() ) {
						if (nextDate == undefined) {
							nextDate = dateEvent;
						}
					}
				}
			}
			
			
		});
		if (nextDate == undefined) {
		
			//throw error
			var enddate = jQuery('#events-calendar div.event p.date span.enddate:last').text();
			if (enddate == '') {
				enddate = jQuery('#events-calendar div.event p.date span.startdate:last').text()
			}
			nextDate = new Date(enddate);
			//Set calendar date and show events		
			//alert(nextDate);
			jQuery('#events_calendar').datepicker('setDate', nextDate );
			var inst = 0;
			showEvents(nextDate, inst);
		
		} else {
		
			//Set calendar date and show events		
			jQuery('#events_calendar').datepicker('setDate', nextDate );
			var inst = 0;
			showEvents(nextDate, inst);	
		}
	}
	
	//Display the next set of events on a date	
	function nextEventDate() {
		
		var count = 0;
		var nextDate;
		
		var currentDate = new Date(jQuery('#events_calendar').datepicker('getDate'));
		//Iterate through event items
		jQuery('#events-calendar div.event p.date span.startdate').each(function (){
			var dateEvent = new Date(jQuery(this).text())
			var rawDateEvent = jQuery(this).text();
			//Compare dates
			if (dateEvent > currentDate) {
				if (nextDate == undefined) {
					nextDate = dateEvent;
				}
			}
		});
		//If no event found for criteria
		if (nextDate == undefined) {
			//Iterate through event items from earliest
			jQuery('#events-calendar div.event p.date span.startdate').each(function (){
				var dateEvent = new Date(jQuery(this).text())
				var rawDateEvent = jQuery(this).text();
				//Get the first event item in the list
				if (count == 0) {
					if (dateEvent < currentDate) {
						nextDate = dateEvent;
						count++;
					}
					else {
						//DO NOTHING
					}
				}
			});
		}
		else {
			//DO NOTHING
		}
		
		if (nextDate == undefined) {
			var enddate = jQuery('#events-calendar div.event p.date span.enddate:last').text();
			if (enddate == '') {
				enddate = jQuery('#events-calendar div.event p.date span.startdate:last').text()
			}
			nextDate = new Date(enddate);
		}
		//Set calendar date and show events
		jQuery('#events_calendar').datepicker('setDate', nextDate );
		var inst = 0;
		showEvents(nextDate, inst);	
		highlightEvents();	
	}
	
	//Display the previous set of events on a date	
	function previousEventDate() {

		var count = 0;
		var nextDate;
		
		var currentDate = new Date(jQuery('#events_calendar').datepicker('getDate'));
		//Iterate through event items
		jQuery('#events-calendar div.event p.date span.startdate').each(function (){	
			var dateEvent = new Date(jQuery(this).text())
			var rawDateEvent = jQuery(this).text();
			//Compare dates			
			if (dateEvent < currentDate) {
				nextDate = dateEvent;
			}
		});
		//If no event found for criteria
		if (nextDate == undefined) {
			//Iterate through event items from earliest
			jQuery('#events-calendar div.event p.date span.startdate').each(function (){
				var dateEvent = new Date(jQuery(this).text())
				var rawDateEvent = jQuery(this).text();
				//Compare dates until last event found
				if (dateEvent > currentDate) {
					nextDate = dateEvent;
				}
				else {
					//DO NOTHING
				}				
			});
		}
		else {
			//DO NOTHING
		}
		
		if (nextDate == undefined) {
			var enddate = jQuery('#events-calendar div.event p.date span.enddate:last').text();
			if (enddate == '') {
				enddate = jQuery('#events-calendar div.event p.date span.startdate:last').text()
			}
			nextDate = new Date(enddate);
		}
		//Set calendar date and show events
		jQuery('#events_calendar').datepicker('setDate', nextDate );
		var inst = 0;
		showEvents(nextDate, inst);	
		highlightEvents();
	}
	</script>
<?php if ($woo_booking_form == 'disabled') { ?>
<style type="text/css">
	#events-calendar .event .buttons ul li.tip {
		left:18% !important;
	}
</style>
<?php } ?>
    <div id="events-calendar-outer">
    
	    <div id="events-calendar">
			
			<div id="calendar" class="fl">
			
				<h2><?php _e('Upcoming events in ', 'woothemes') ?><span><?php _e('November', 'woothemes') ?></span></h2>
				<div id="events_calendar"></div>
				<p class="months">
					<span class="fl"><a class="button" onclick="previousEventDate()"><?php _e('Previous Event', 'woothemes') ?></a></span>
					<span class="fr"><a class="button" onclick="nextEventDate()"><?php _e('Next Event', 'woothemes') ?></a></span>
				</p>
				
			</div><!-- /#calendar  -->
			<?php $js_formatting = stripslashes($woo_calendar_formatting); ?>
			<?php 
			switch ($js_formatting) {
				/*case "mm/dd/yy" :
					$php_formatting = "m\/d\/Y";
					break;
				case "yy-mm-dd" :
					$php_formatting = "Y\-m\-d";
					break;
				case "d M, y" :
					$php_formatting = "d M, Y";
					break;
				case "d MM, y" :
					$php_formatting = "d F Y";
					break;
				case "DD, d MM, yy" :
					$php_formatting = "l, d F, Y";
					break;
				case "'day' d 'of' MM 'in the year' yy" :
					$php_formatting = "\\d\a\y d \\o\\f F \\i\\n \\t\h\e \\y\e\a\\r Y";
					break;*/
				default :
					$php_formatting = "m\/d\/Y";
					break;	
			} ?>
			<?php $category_id = get_cat_ID( $woo_events_category ); ?>
			
			<?php
			//Improved Diarise get events query
			$query_args['cat'] = $category_id;
			$query_args['showposts'] = -1;
			$query_args['status'] = 'publish';
			$num_events = get_option('woo_upcoming_events');
			$time_now = strtotime('now');
			$the_query = new WP_Query($query_args);
			$search_results = array();
			if ($the_query->have_posts()) : $count = 0;

			while ($the_query->have_posts()) : $the_query->the_post();
				//add post to array
				global $post;
				$event_start_date = get_post_meta($post->ID,'event_start_date',true);
				$event_end_date = get_post_meta($post->ID,'event_end_date',true);
				if ($event_end_date == '') { $event_end_date = $event_start_date; }

				if ( ( $event_start_date != '' ) && ( $event_end_date != '' ) ) {

					$time_start = strtotime($event_start_date);
					$time_end = strtotime($event_end_date);
					$start_range = strtotime($woo_start_calendar_range);
					$end_range = strtotime($woo_end_calendar_range);

					if ( ( ( $time_start <= $start_range ) && ( $time_end >= $start_range ) ) || ( ( $time_start >= $start_range ) && ( $time_end <= $end_range ) ) || ( ( $time_start <= $end_range ) && ( $time_end >= $end_range ) ) ) {
						$search_results[$post->ID] = array( 'ID' => $post->ID , 'start' =>  $time_start , 'end' => $time_end );
					}
				}
				
			endwhile; else:
    			//no posts	    	
    		endif;
    		
    		function woo_compare_date_fields($a, $b) { 
    			$retval = strnatcmp($a['start'], $b['start']); 
    			if(!$retval) {
    				return strnatcmp($a['end'], $b['end']); 
    			}
    			return $retval; 
    		} 
    		//sort alphabetically by start and end 
    		usort($search_results, 'woo_compare_date_fields');
    		
			$counter = 0;
			$event_results = array();
			foreach ($search_results as $search_result) {
				
				if ( $counter < $num_events ) { // Removed the '=' to correct the event display count, due to zero-indexed array.
					array_push($event_results,$search_result['ID']);
					$counter++;
				}
				
			}
			
			$array_counter = count($event_results);
			if ( $array_counter > 0 ) {
				$query_args['post__in'] = $event_results;
				$has_results = true;
			
			} else {
				$has_results = false;
			}
			?>
			<?php
			foreach ($event_results as $event_result) {
			
			$query_args['post__in'] = array($event_result);
			?>
			<?php query_posts($query_args); ?>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                	<?php 
            		//Post Meta
            		$event_start_date = get_post_meta($post->ID,'event_start_date',true);
            		$event_end_date = get_post_meta($post->ID,'event_end_date',true);
            		$event_start_time = get_post_meta($post->ID,'event_start_time',true);
            		$event_end_time = get_post_meta($post->ID,'event_end_time',true);
            		$event_location = get_post_meta($post->ID,'event_location',true);
            		$maps_active = get_post_meta($post->ID,'woo_maps_enable',true);
            		//Change this to whatever you want your custom date output format to be.
            		$custom_formatting = $php_formatting; 
            		?>
                	<?php if ( ((strtotime($event_start_date)) >= (strtotime($woo_start_calendar_range))) && ((strtotime($event_start_date)) <= (strtotime($woo_end_calendar_range))) ) { ?>
                	<div class="event-outer fr hide">
                	
						<div class="event">
							<?php woo_get_image('image',$GLOBALS['feat_w'],$GLOBALS['feat_h'],'thumbnail '.$GLOBALS['feat_align']); ?> 
							<p class="date">
								<span class="startdate hide"><?php echo date($php_formatting,strtotime($event_start_date)); ?></span>
								<span class="enddate hide"><?php if ( (date($php_formatting,strtotime($event_end_date))) > (date($php_formatting,strtotime($event_start_date))) ) { ?> - <?php echo date($php_formatting,strtotime($event_end_date)); } ?></span>
								<span class="startdateoutput"><?php echo date($custom_formatting,strtotime($event_start_date)); ?></span>
								<span class="enddateoutput"><?php if ( (date($php_formatting,strtotime($event_end_date))) > (date($php_formatting,strtotime($event_start_date))) ) { ?> - <?php echo date($custom_formatting,strtotime($event_end_date)); } ?></span>
							</p>
							
							<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
							
							<?php if ($woo_booking_form == 'disabled' && $woo_events_ical_export == 'false') { } else { ?>
								<div class="buttons">
									<?php if ($woo_booking_form == 'disabled') { } else { ?>
										<a href="<?php if ($woo_booking_form == 'bookingurl') { echo $woo_booking_form_external_url; } else { echo get_bloginfo('url').'/'.$woo_booking_form_page.'/?event_id='.$post->ID; } ?>" class="button book-tickets"><?php _e('Book Tickets', 'woothemes'); ?></a>
									<?php } ?>
									<?php if ($woo_events_ical_export == 'true') { ?>
									<a onclick="" class="button add-calendar"><?php _e('Add to Calendar', 'woothemes'); ?></a>
									<?php $icalurl = woo_get_ical($post->ID,$php_formatting); ?>
									<ul>
										<li class="outlook"><a href="<?php echo get_bloginfo('template_url'); ?>/download.php?calendar=<?php echo $icalurl['ical']; ?>" title="Microsoft Outlook">Microsoft Outlook</a></li>
										<li class="ical"><a href="<?php echo get_bloginfo('template_url'); ?>/download.php?calendar=<?php echo $icalurl['ical']; ?>" title="Apple iCal">Apple iCal</a></li>
										<li class="google"><a href="<?php echo $icalurl['google']; ?>" target="_blank" title="Google Calendar">Google Calendar</a></li>
										<li class="tip">&nbsp;</li>
									</ul>
										
									<?php } ?>
								</div>
							<?php } ?>
								
							<?php the_excerpt(); ?>
							
                            <?php if ( $event_location ) { ?><span>Location : </span><?php if ($maps_active == 'on') { ?><a href="<?php the_permalink() ?>#eventlocation"><?php echo $event_location; ?></a><?php } else { ?><span><?php echo $event_location; ?></span><?php } ?><?php } ?>
							<div class="fix"></div>
							
						</div><!-- /#event  -->
						
					</div><!-- /#event-outer  -->
					<?php } ?>
            <?php endwhile; endif; ?>
            <?php } // End FOREACH Loop ?>
					<div id="message-none" class="hide">
						<p><?php _e('There are no events for this date.', 'woothemes') ?></p>
					</div><!-- /#message  -->
					<div id="message-upcoming" class="hide">
						<p><?php _e('There are no upcoming events.', 'woothemes') ?></p>
					</div><!-- /#message  -->
			<div class="fix"></div>
			
		</div><!-- /#events-calendar  -->
	 
	</div><!-- /#events-calendar-outer  -->