#!/bin/sh

# TYR_USERNAME and TYR_PORT must be defined for this to work.

# DIRNAME is public_html unless this script has 'staging' in its name
DIRNAME="public_html"

if [[ ${BASH_SOURCE[0]} == *"staging"* ]]; then
	DIRNAME="staging_html"
fi


cd "$( dirname "${BASH_SOURCE[0]}" )"

echo 'Fixing file ownership...'
sudo chown -R $USER:staff *

echo 'Fixing file permissions... All files but commands to 644'
find . -type f ! -name '*.command' -exec chmod 644 {} \;

echo 'Fixing directory permissions...'
find . -type d -exec chmod 755 {} \;

echo 'Fixing show directory permissions so they can be modified on server...'
find shows -type d -exec chmod a+rwX {} \;
find shows -type f -exec chmod 644 {} \;

echo 'Fixing directory permissions for database... removing so it gets loaded from remote...'
chmod 777 db
rm db/tyr.sqlite3

echo 'Fixing CSS file permissions for server...'
find . -name '*.css' -exec chmod 444 {} \;
find . -name '*.scss' -exec chmod 600 {} \;

# Put most files up on www.tomorrowyouthrep.org
# Skip files that are newer on the server (-u), in case somebody has made changes there, they won't be obliterated.

echo
echo
echo 'Sending changed files to remote server... but NOT the database!'

# 		--checksum \

rsync	--exclude 'error_log' --exclude 'php.ini' --exclude 'cgi-bin' \
		--include 'wymiframe.html' \
		--exclude '*.html' \
		--exclude 'backup.*' \
		--exclude '*.codekit*' \
		--exclude '.*' \
		--exclude '*.subl*' \
		--exclude '*.command' \
		--exclude 'tyr.sqlite3' \
		-vuaze "ssh -p $TYR_PORT" \
		* $TYR_USERNAME@tomorrowyouthrep.org:/home/$TYR_USERNAME/$DIRNAME

echo
echo
echo 'Listing files that maybe should be deleted from remote -- BUT ARENT ...'

# 		--checksum \

rsync	--dry-run \
		--delete \
		--exclude 'error_log' --exclude 'php.ini' --exclude 'cgi-bin' \
		--include 'wymiframe.html' \
		--exclude '*.html' \
		--exclude '*.codekit*' \
		--exclude '.*' \
		--exclude '*.subl*' \
		--exclude '*.command' \
		--exclude 'tyr.sqlite3' \
		-vuaze "ssh -p $TYR_PORT" \
		* $TYR_USERNAME@tomorrowyouthrep.org:/home/$TYR_USERNAME/$DIRNAME


# Now put any new files from the server to the local machine. Just in case, skip files that are new here (-u)

echo
echo
echo 'Getting files from remote server that somebody may have uploaded...'

#		--checksum \

rsync	--exclude 'error_log' --exclude 'php.ini' --exclude 'cgi-bin' \
		--include 'wymiframe.html' \
		--exclude '*.html' \
		--exclude 'backup.*' \
		--exclude '*.codekit*' \
		--exclude '.*' \
		-vuaze "ssh -p $TYR_PORT" \
		$TYR_USERNAME@tomorrowyouthrep.org:/home/$TYR_USERNAME/$DIRNAME/* .


echo
echo
echo 'Listing files that maybe should be deleted from local -- BUT ARENT ...'

#		--checksum \

rsync	--dry-run \
		--delete \
		--exclude 'error_log' --exclude 'php.ini' --exclude 'cgi-bin' \
		--include 'wymiframe.html' \
		--exclude '*.html' \
		--exclude 'backup.*' \
		--exclude '*.codekit*' \
		--exclude '.*' \
		-vuaze "ssh -p $TYR_PORT" \
		$TYR_USERNAME@tomorrowyouthrep.org:/home/$TYR_USERNAME/$DIRNAME/* .


echo 'Restoring file permissions for local system...'
chmod 666 db/tyr.sqlite3
find . -name '*.css' -exec chmod 644 {} \;
find . -name '*.scss' -exec chmod 600 {} \;
find . -type f -name '*.html' -exec chmod 666 {} \;


echo 'Sleeping for 10 seconds...'

sleep 10
