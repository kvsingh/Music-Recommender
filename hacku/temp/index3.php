<?php
		include_once("keys.php");
		if(CONSUMER_KEY == '' or CONSUMER_SECRET == '')
			die('This example needs a comsumer key and secret. Start a new project at <a href="http://developer.apps.yahoo.com/dashboard/">http://developer.apps.yahoo.com/dashboard/</a> to get yours and edit the keys.php file.');
		include_once("lib/Yahoo.inc");
//		Enable debugging. Errors are reported to Web server's error log.
		YahooLogger::setDebug(true);

//		Initializes session and redirects user to Yahoo! to sign in and then authorize app
		$yahoo_session = YahooSession::requireSession(CONSUMER_KEY, CONSUMER_SECRET);
		if($yahoo_session == NULL)
			fatal_error("yahoo_session");
//			echo "Check";




$firehose = 'select fields.value from social.contacts(100) where guid=me';list($b, $a, $songtempID) = split("_", $songID);
$data = $yahoo_session->query($firehose);
//echo $data;

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
echo($userInfo["profileUrl"]." ".$userInfo["image"]["imageUrl"]."<br/>");

function songIDtoTitle($songID)
{
	global $yahoo_session;
	//select title, album, artist
	
	$firehose = 'select title,Album.title,Artist.name from music.track.id where ids="'. $songID .'"';
	$data = $yahoo_session->query($firehose);
	$json1 = json_decode($data, true);
	$retVal = $json1["query"]["results"]["Track"];
	return $retVal;
}

function parseContacts($jsonString)
{
	$json1 = json_decode($jsonString, true);
	$contacts = $json1["query"]["results"]["contact"];
	$emails = Array();
	for($i=0,$j=0;$i<sizeof($contacts);$i=$i+1)
	{
		if(gettype($contacts[$i]["fields"]["value"])=="string")
		{
			if(strstr($contacts[$i]["fields"]["value"], 'yahoo.') or strstr($contacts[$i]["fields"]["value"], 'ymail.'))
			{
				$emails[$j] = $contacts[$i]["fields"]["value"];
				echo($emails[$j]);
				echo("<br/>");
				$j+=1;
			}
		}
	}
	return $emails;
}
function parseGuid($jsonString)
{
	//echo($jsonString);
	$json1 = json_decode($jsonString, true);
	$guid = $json1["query"]["results"]["identity"]["guid"];
	//echo($guid);
	return $guid;
}
function parseUpdates($updates)
{
	//$json1 = json_decode($jsonString, true);
	//$updates = $json1["query"]["results"]["update"];
	//echo $updates;
	
	$ratings = Array();
	$counts = Array();
	echo("waaaaaaaaaaaaaaaaaa".sizeof($updates));
	for($i=0; $i<sizeof($updates);++$i)
	{
		//echo("hel");
		$update_array = $updates[$i];
		for($j=0; $j<sizeof($update_array); $j++)
		{
			$update = $update_array[$j];
			
			//echo $update;
			$songID = $update["suid"];
			//list($songID = 
			//echo "<br/>$$$$$$$$$$$".$update["suid"]."$$$$$$$$$$$<br/>";
			//echo "<br/>$$$$$$$$$$$".$update["itemtxt"]."$$$$$$$$$$$<br/>";
			$rating = $update["infoTxt1"][0];	
			//echo $rating;
			list($b, $a, $songtempID) = split("_", $songID);
			if(array_key_exists($songtempID, $ratings))
			{
				
				$ratings[$songtempID] += $rating;
				$counts[$songtempID] += 1;
			}
			else
			{
				$ratings[$songtempID] = $rating;
				$counts[$songtempID] = 1;
			}
		}
	}
	echo("<br/>");
	foreach($ratings as $songtempID => $rating)
	{
		//echo("rating : ".$rating." count : ".$counts[$songtempID]);
		$ratings[$songtempID] /= $counts[$songtempID];
		//echo("average rating for the song : ".$songtempID." is ".$ratings[$songtempID]);
		//$songinfo = songIDtoTitle($songtempID);
		//echo("average rating for the song : ".$songinfo["title"]." is ".$ratings[$songtempID]);
		//echo("<br/>"); 
	}
	arsort($ratings);
	//$ratings = array_reverse($ratings, true);
	foreach($ratings as $songtempID => $rating)
	{
		echo("rating : ".$rating." count : ".$counts[$songtempID]);
		//$ratings[$songtempID] /= $counts[$songtempID];
		//echo("average rating for the song : ".$songtempID." is ".$ratings[$songtempID]);
		$songinfo = songIDtoTitle($songtempID);
		echo("average rating for the song : ".$songinfo["title"]." is ".$ratings[$songtempID]);
		echo("<br/>"); 
	}
	
}

$emails =  parseContacts($data);
$guids=Array();
for($i=0;$i<sizeof($emails);$i++)
{
	$firehose = 'select guid from yahoo.identity where yid="'.$emails[$i].'"';
	$data = $yahoo_session->query($firehose);
	$guid = parseGuid($data);
	if($guid!=""){ 	$guids[$i] = $guid;}
	echo $guid;
	echo "<br/>";
}
$updates=Array();
$count = 0;
for($i=0;$i<sizeof($guids);$i++)
{
	if($guids[$i]!="")
	{
		$firehose = 'select itemtxt,suid,infoTxt1 from social.updates.search(10) where source="y.music" and type="trackrate"and guid="'.$guids[$i].'"'; 
		$data = $yahoo_session->query($firehose);

		$json = json_decode($data, true);
		//echo($firehose);
		if($json["query"]["results"]!=null)
		{
			$update = $json["query"]["results"]["update"];
			echo($guids[$i].sizeof($updates));
			$updates[$count]=$update;
			$count = $count + 1;
		}
	}
//	if($guids[$i]!="") {$firehose = $firehose.' or guid="'.$guids[$i].'"';}
}
parseUpdates($updates);
//$firehose = $firehose.')';
//echo "<br/>".$firehose."<br/>";


//echo substr("abcdefghijklmnop",2,-2);
?>
