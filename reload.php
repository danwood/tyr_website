<?php

// This file is used by the cron job only now; no need to do manually.

include('_reload.php');	// not a function, and not called from a function, so all globals work right.


?>
<p>Rebuilding of the HTML pages is now done automatically when there is a change to the database.</p>
<p>So there is no need to do this manually.</p>
<p>However, this process is also done every night, so that each day's website shows fresh data.</p>
