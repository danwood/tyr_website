
/* ==========================================================================
   Breakpoints
   ========================================================================== */

@media only screen and (max-width:35.99em)
{
}

@media only screen and (min-width:36em) and (max-width:47.99em)
{
	.current-show, .current-event, .later, .past, .past-six { width:50%; }

<?php if (count($currentOther) % 2 == 1)		// An odd number? If so, center the last one.
{
	echo "\t" . '.current-event:last-child { margin-left:25%; }' . PHP_EOL;
}
if (count($currentShows) % 2 == 1)		// An odd number? If so, center the last one.
{
	echo "\t" . '.current-show:last-child { margin-left:25%; }' . PHP_EOL;
}
if (count($laterEvents) % 2 == 1)
{
	echo "\t" . '.later:last-child { margin-left:25%; }' . PHP_EOL;
}
if (count($pastEvents) % 2 == 1)
{
	// .past is for unknown quantities of past events; use .past-six when there are exactly six

	echo "\t" . '.past:last-child { margin-left:25%; }' . PHP_EOL;
}

/*  I still need to write the logic to equalize only the cards appaearing on the same row; not the orphan card(s).... */

// Below had  .later:nth-child(-n+2) .equalize-later -- but that wasn't general enough?

?>
	.equalize-show, .equalize-other, .equalize-later  { page-break-before:always; } /* to trigger equalizing heights */
}

@media only screen and (min-width:48em)
{
	.current-event, .current-show, .later, .past, .past-six { width:33.33%; }
<?php
	/*
		_ # _

		.# #.

		# # #

		.# #.
		.# #.

		# # #
		.# #.
	*/
if (count($currentOther) == 1)		// Exactly 1, so move over 1/3 of the way
{
	echo "\t" . '.current-event:last-child { margin-left:33.33%; }' . PHP_EOL;

}
else if (count($currentOther) % 3 ==  2)	// 2 left over, so give second-from-last a margin to center last 2
{
	echo "\t" . '.current-event:nth-last-child(2) { clear:left; margin-left:16.67% }' . PHP_EOL;

}
else if (count($currentOther) % 3 ==  1)	// 1 left over, so make last 2 rows center those 2
{
	echo "\t" . '.current-event:nth-last-child(2), .current-event:nth-last-child(4) { clear:left; margin-left:16.67% }' . PHP_EOL;
}

if (count($currentShows) == 1)		// Exactly 1, so move over 1/3 of the way
{
	echo "\t" . '.current-show:last-child { margin-left:33.33%; }' . PHP_EOL;

}
else if (count($currentShows) % 3 ==  2)	// 2 left over, so give second-from-last a margin to center last 2
{
	echo "\t" . '.current-show:nth-last-child(2) { clear:left; margin-left:16.67% }' . PHP_EOL;

}
else if (count($currentShows) % 3 ==  1)	// 1 left over, so make last 2 rows center those 2
{
	echo "\t" . '.current-show:nth-last-child(2), .current-show:nth-last-child(4) { clear:left; margin-left:16.67% }' . PHP_EOL;
}

if (count($laterEvents) == 1)		// Exactly 1, so move over 1/3 of the way
{
	echo "\t" . '.later:last-child { margin-left:33.33%; }' . PHP_EOL;

}
else if (count($laterEvents) % 3 ==  2)	// 2 left over, so give second-from-last a margin to center last 2
{
	echo "\t" . '.later:nth-last-child(2) { clear:left; margin-left:16.67% }' . PHP_EOL;

}
else if (count($laterEvents) % 3 ==  1)	// 1 left over, so make last 2 rows center those 2
{
	echo "\t" . '.later:nth-last-child(2), .later:nth-last-child(4) { clear:left; margin-left:16.67% }' . PHP_EOL;
}
/*


DON'T DO THIS NOW UNLESS WE HAVE A WAY TO DO THIS FOR EACH YEAR'S GROUPS

if (count($pastEvents) == 1)		// Exactly 1, so move over 1/3 of the way
{
	echo "\t" . '.past:last-child { margin-left:33.33%; }' . PHP_EOL;

}
else if (count($pastEvents) % 3 ==  2)	// 2 left over, so give second-from-last a margin to center last 2
{
	echo "\t" . '.past:nth-last-child(2) { clear:left; margin-left:16.67% }' . PHP_EOL;

}
else if (count($pastEvents) % 3 ==  1)	// 1 left over, so make last 2 rows center those 2
{
	echo "\t" . '.past:nth-last-child(2), .past:nth-last-child(4) { clear:left; margin-left:16.67% }' . PHP_EOL;
}
*/

?>
	.equalize-show, .equalize-other, .equalize-later  { page-break-before:always; } /* to trigger equalizing heights */
}


