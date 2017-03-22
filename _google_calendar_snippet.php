		$googleCalendar = trim($this->googleCalendar);
		if ($staging) error_log('Google calendar URL = ' . $googleCalendar);
		if ($googleCalendar)
		{
			echo '<p><a href="' . htmlspecialchars($googleCalendar) . '">Schedule — Google Calendar</a>';

			$matched = preg_match('/src=(.+)&/', $googleCalendar, $matches);
			if ($matched)
			{
				$fragment = $matches[1];
				$iCalURL = 'webcal://www.google.com/calendar/ical/' . $fragment . '/public/basic.ics';

				echo '&nbsp;&nbsp;&nbsp; <a style="color:#ddd" href="' . $iCalURL . '">[iCalendar Subscription Link]</a></p>' . PHP_EOL;

	?>
	<!-- Responsive iFrame http://themeloom.com/2013/02/tips-embed-google-maps-and-calendars-in-a-responsive-wordpress-theme/ -->
	<div class="responsive-iframe-container">
	<!-- https://www.google.com/calendar/embed?src=lna97bbhu6s8663hr9gt76i4b8%40group.calendar.google.com&ctz=America/Los_Angeles -->
	<!-- iCal: https://www.google.com/calendar/ical/lna97bbhu6s8663hr9gt76i4b8%40group.calendar.google.com/public/basic.ics -->
	<iframe
	src="https://www.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=<?php
	echo $fragment;
	?>&amp;color=%236B3304&amp;ctz=America%2FLos_Angeles"
	style="border-width:0"
	width="620"
	height="400"
	frameborder="0"
	scrolling="no"></iframe>
	</div>
	<?php
			}
			else
			{
				// Problem, but at least we have the URL, so we've output that.  End paragraph.
				echo "</p>\n";
			}


		}
