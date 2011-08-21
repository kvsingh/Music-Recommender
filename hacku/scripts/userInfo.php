<?php
	include_once("/hacku/ySession.php");

	function userInfo()
	{
		global $yahoo_session;
		$firehose = 'select image.imageUrl, profileUrl from social.profile where guid=me';
		$data = $yahoo_session->query($firehose);
		$json1 = json_decode($data, true);
		$retVal = $json1["query"]["results"]["profile"];
		return $retVal;
	}

	$userInfo = userInfo();
	echo "<p><b>" . "Full Name" . "</b></p>\n<a href='" . $userInfo["profileUrl"] ."'><img src='" . $userInfo["image"]["imageUrl"] . "' /></a>\n<p><a href='" . $userInfo["profileUrl"] . "'>Visit your Profile</a></p>";
?>
