<?php



	header('Content-Type: application/rss+xml; charset=utf-8');














include '_Markdown.php';
include '_MarkdownExtra.php';


// http://michelf.ca/projects/php-markdown/configuration/


    require_once('_prelude.php');

    $eventsForRSS = $events;		// make a copy so we can sort it
   	usort($eventsForRSS, array('Event', 'eventAnnounceCompare'));

    // http://cyber.law.harvard.edu/rss/rss.html

	echo '<' . '?xml version="1.0"?' . '>' . PHP_EOL;
?>
<rss version="2.0">
	<channel>
		<title>Tomorrow Youth Rep</title>
		<link><?php echo $urlBase; ?></link>
		<description>Events announced by TYR</description>
		<language>en-us</language>
		<pubDate><?php echo date('r', $now); ?></pubDate>
		<lastBuildDate><?php echo date('r', $now); /* Same as above?   Hmmmm...  */ ?></lastBuildDate>
		<docs>http://blogs.law.harvard.edu/tech/rss</docs>
<?php
foreach ($eventsForRSS as $event)
{
	$announceTime = strtotime($event->announceDate);
	if ($announceTime && $now >= $announceTime)		// ignore anything not announced yet
	{
		$nameCode = $event[BEFORE_NAMECODE];
		$id = $event->id();
		$title = $event->title();
		$eventStatus = $event[BEFORE_STATUS];
		$rehearsalStartDate = strtotime($event[BEFORE_RehearsalStartDate]);
		$this->ticketSaleDate = strtotime($event[BEFORE_TicketSaleDate]);
		$signupStartDate = strtotime($event[BEFORE_SignupStartDate]);
		$this->signupEndDate = strtotime($event[BEFORE_SignupEndDate]);
		$this->showFirstDate = strtotime($event[BEFORE_ShowFirstDate]);
		$this->showFirstDateLast = $this->showFirstDate;
		if (!empty($event[BEFORE_ShowLastDate]))
		{
			$this->showFirstDateLast = strtotime($event[BEFORE_ShowLastDate]);
		}
		$auditionTime1 = strtotime($event[BEFORE_AuditionDateTime1]);
		$auditionTime2 = !empty($event[BEFORE_AuditionDateTime2]) ? strtotime($event[BEFORE_AuditionDateTime2]) : strtotime($event[BEFORE_AuditionDateTime1]);

		$isSpecialEvent = $event[BEFORE_Type] == 'Event to Archive' || $event[BEFORE_Type] == 'Event Announce-Only';
		$isShow = $event[BEFORE_Type] == 'Audition Show' || $event[BEFORE_Type] == 'Class Show';
		$isAuditionShow = $event[BEFORE_Type] == 'Audition Show';
		$isBackstageCamp = $event[BEFORE_Type] == 'Backstage Camp';

		$showLogo = $eventStatus != STATE_PAST_ARCHIVE && !empty($event[BEFORE_LogoFilename]);
		$showLogoPNG = $showLogo && pathinfo($event[BEFORE_LogoFilename], PATHINFO_EXTENSION) == 'png';
		$showPhoto = $this->isComingSoonEvent() && !empty($event[BEFORE_PhotoFilename]);
		$ticketURL = $event[BEFORE_TicketURL];
		$tuitionWithDollars = $event[BEFORE_Tuition];

		$duringSignup = FALSE; /* we know now is after BEFORE_SignupStartDate */
		if ($isAuditionShow)
		{
			$duringSignup = $auditionTime2 ? ($now < $auditionTime2) : ($now < $auditionTime1);
		}
		else
		{
			if ($this->signupEndDate)
			{
				$duringSignup = ($now < $this->signupEndDate+86400);
			}
			else
			{
				$duringSignup = ($now < $rehearsalStartDate);	// no signup deadline, so assume rehearsal start is deadline
			}
		}


		echo '		<item>' . PHP_EOL;
		echo '			<title>' . htmlspecialchars($title) . '</title>' . PHP_EOL;
		if ($event[BEFORE_LINK])
		{
			echo '			<link>' . $event[BEFORE_LINK] . '</link>' . PHP_EOL;
		}
		echo '			<guid>' . $urlBase . '?id=' . $id . '</guid>' . PHP_EOL;

		// For legacy events, where announce time isn't relevant
		if ($announceTime < 1357794000)
		{
			//			error_log('announceTime was ' . date('r', $announceTime) . '... changing to:       ' . $title);
			$announceTime = $this->showFirstDate;
		}
		//		error_log('announceTime is  ' . date('r', $announceTime)     . '                   for ' . $title);

		echo '			<pubDate>' . date('r', $announceTime) . '</pubDate>' . PHP_EOL;
		echo '			<description>' . PHP_EOL;
		// Now, collect our output and encode it as XML.

		ob_start();




		$caption = '';
		$date = '';
		if ($this->isComingSoonEvent())
		{
			$date = date('F Y', $this->showFirstDate);			// Date of performance, just month/year
		}
		else if ($eventStatus == BEFORE_STATUS_LATER)	// Date of performance NOT audition, month/year or, if 1/1, 4/1, 7/1, 10/1, the season.
		{
			$dateInfo = getdate($this->showFirstDate);
			if (   $dateInfo['mon' ] % 3 == 1	// 1, 4, 7, 10a
				&& $dateInfo['mday'] == 1 )
			{
				$seasons = array('Winter', 'Spring', 'Summer', 'Fall');		// All you have to do is call!
				$date = $seasons[($dateInfo['mon']-1)/3] . date(' Y', $this->showFirstDate);
			}
			else
			{
				$date = date('F j', $this->showFirstDate);
			}
			$date = 'Coming ' . $date;
		}
		else if ($this->isUpcomingEvent())	// Need more specifics of what the date is.
		{
			if ($duringSignup)
			{
				if ($isAuditionShow)
				{
					if ($auditionTime1 == $auditionTime2)
					{
						$date = 'Audition ' . date('l, F j', $auditionTime1);
					}
					else
					{
						$month1 = date('F', $auditionTime1);
						$month2 = date('F', $auditionTime2);
						if ($month1 == $month2)
						{
							$date = 'Audition ' . $month1 . ' ' . date('j', $auditionTime1) . ' & ' . date('j', $auditionTime2);
						}
						else
						{
							$date = 'Audition ' . date('F j', $auditionTime1) . ' & ' . date('F j', $auditionTime2);
						}
					}
				}
				else
				{
					if ($this->signupEndDate)
					{
						$date = 'Register by ' . smartDate('F, M j', $this->signupEndDate);
					}
					else
					{
						$date = 'Registration Open';
					}
				}
			}
			else
			{
				if ($isSpecialEvent)
				{
					$date = date('F j', $this->showFirstDate);

					if (!empty($this->showFirstDateLast) && $this->showFirstDateLast != $this->showFirstDate)
					{
						$date .= ' – ';
						$month1 = date('F', $this->showFirstDate);
						$month2 = date('F', $this->showFirstDateLast);
						if ($month1 == $month2)
						{
							$date .= date('j', $this->showFirstDateLast);
						}
						else
						{
							$date .= date('F j', $this->showFirstDateLast);
						}
					}
				}
				else
				{
					$date = 'Opening ' . date('F j', $this->showFirstDate);
				}
			}
		}


		$imgURL = '';
		if ($showPhoto)
		{
			$photoFilename = $event[BEFORE_PhotoFilename];
			$matches = $this->matchesFromPhotoFilename();
			// Look for ending number, e.g. narnia3.jpg.  If so, that means we should 1 through n, so RANDOMLY pick one of them.
			if ($matches)
			{
				$photoCount = $matches[2];
				$photoCount = min($photoCount, 4);		// For RSS, don't show anything past first four
				if ($photoCount > 1)
				{
					$photoFilename = $matches[1] . '1.' . $matches[3];		// Always just use image #1 for RSS feed
				}
			}

			$imgURL = $urlBase . 'shows/photo/' . $photoFilename;

		}
		if ($imgURL)
		{
			// Cap to 304 pixels, so it's always retina
			echo '<p><img width="304" src="' . $imgURL . '" /></p>' . PHP_EOL;
		}


		if ($this->isUpcomingEvent())
		{
			$event->outputEventCard(FALSE, FALSE);
			$event->outputEventCurrentBlurb();
		}
		else if ($eventStatus == BEFORE_STATUS_LATER)
		{
			$event->outputEventCard(FALSE, FALSE);
		}

		else if ($this->isComingSoonEvent())
		{
			$html = Markdown::defaultTransform($event[BEFORE_DescriptionBefore]);
			echo $html;

			$html = Markdown::defaultTransform($event[BEFORE_HowTheShowWent]);
			echo $html;


			$multiDate = (!empty($event[BEFORE_ShowLastDate]) && $event[BEFORE_ShowFirstDate] != $event[BEFORE_ShowLastDate]);
			echo '<p>' . ($multiDate ? 'Dates' : 'Date') . ': ' . htmlspecialchars(date('F j', strtotime($event[BEFORE_ShowFirstDate])));
			if ($multiDate)
			{
				echo ' to ' . htmlspecialchars(date('F j', strtotime($event[BEFORE_ShowLastDate])));
			}
			echo htmlspecialchars(date(', Y', strtotime($event[BEFORE_ShowFirstDate])));
			echo '</p>' . PHP_EOL;
			if (!empty($event[BEFORE_PhotoURL1]))
			{
				echo '<p><a href="' . htmlspecialchars($event[BEFORE_PhotoURL1]) . '">More photos</a>';

				if (!empty($event[BEFORE_PhotoURL2]))
				{
					echo ' and <a href="' . htmlspecialchars($event[BEFORE_PhotoURL2]) . '">even more photos</a>';
				}
				echo '</p>' . PHP_EOL;
			}
		}



		// Social sharing -- I guess I can't include pinterest since the script is needed?
		//
		$event->outputSocialSharing(0, TRUE);


		$htmlToOutput = ob_get_clean();
		echo htmlspecialchars($htmlToOutput);
		echo '			</description>' . PHP_EOL;



		echo '		</item>' . PHP_EOL;
	}
	else
	{
	}
}
?>
	</channel>
</rss>