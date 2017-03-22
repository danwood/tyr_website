# tyr_website
Website for Tomorrow Youth Repertory

For this to work, caches/cache.0.csv needs to be world-writable.  THIS IS GOING AWAY.


Temporarily this will be set up so that requests for *.html will redirect to *.php.
On the deployed website, reload.php (invoked manually or from a cron job) rebuilds the cached .html files from the .php files so that the pages are served statically.  Maybe not such a big deal for a low-volume website but it's kind of cool that way.   A possible improvement would be to have some mechanism to rebuild the static cached files when the php changes or when the database changes.

