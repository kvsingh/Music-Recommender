<?php
	include_once("keys.php");
	if(CONSUMER_KEY == '' or CONSUMER_SECRET == '')
		die('This example needs a comsumer key and secret. Start a new project at <a href="http://developer.apps.yahoo.com/dashboard/">http://developer.apps.yahoo.com/dashboard/</a> to get yours and edit the keys.php file.');
	include_once("lib/Yahoo.inc");
//	Enable debugging. Errors are reported to Web server's error log.
	YahooLogger::setDebug(true);
//	Initializes session and redirects user to Yahoo! to sign in and then authorize app
	$yahoo_session = YahooSession::requireSession(CONSUMER_KEY, CONSUMER_SECRET);
	if($yahoo_session == NULL)
		fatal_error("yahoo_session");
?>
