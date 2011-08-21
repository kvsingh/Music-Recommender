<?php
	function userInfo()
	{
		global $yahoo_session;
		$firehose = 'select image.imageUrl, profileUrl from social.profile where guid=me';
		$data = $yahoo_session->query($firehose);
		$json1 = json_decode($data, true);
		$retVal = $json1["query"]["results"]["profile"];
		echo "<p><b>" . "Full Name" . "</b></p>\n<a href='" . $retVal["profileUrl"] ."' target='_blank'><img src='" . $retVal["image"]["imageUrl"] . "' /></a>\n<p><a href='" . $retVal["profileUrl"] . "' target='_blank'>Visit your Profile</a></p>";
	}
?>
