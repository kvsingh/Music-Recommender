<?php
	include_once("ySession.php");
	include_once("userInfo.php");
	include_once("yahoo.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<meta>
		<title>Bhayanak Recommendations</title>
		<link rel="stylesheet" type="text/css" href="/hacku/style/hacku.css" />
		<script type="text/javascript" src="/hacku/scripts/ajax.js"></script>
	</meta>
	<body onload="userInfo();">
		<div id="wrapper">
			<div id="header">
				<div id="header-content">
					<img src="style/images/yLogo.png" />
					<div id="header-content-search">
						<form action="http://new.music.yahoo.com/search/" method="GET">
							<input type="text" id="p" name="p" length="50" />
							<input type="submit" id="submit" name="submit" value="Music Search"/>
						</form>
					</div>
				</div>
			</div>
			<div class="space"></div>
			<div id="main">
				<div id="main-content">
					<div id="main-content-left">
						<div id="left-box-1" class="box">
							<?php	userInfo();?>
						</div>
					</div>
					<div id="main-content-middle">
						<h2>Recommended Tracks</h2>
						<table width=100% border=2>
							<thead>
								<td align="center"><b>S.No.</b></td>
								<td align="center"><b>Title</b></td>
								<td align="center"><b>Artist</b></td>
								<td align="center"><b>Album</b></td>
								<td align="center"><b>Rating</b></td>
							</thead>
							<tbody>
								<?php	songRatings(); ?>
							</tbody>
						</table>
					</div>
					<div id="main-content-right">
						<div id="right-box-1" class="box" style="text-align:left;">
							<h3>What others are listening to..</h3>
							<div style="height:30%; overflow:scroll;">
								<ul>
									<?php	allSongs(); ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="space"></div>
			<div id="footer">
				<div id="footer-content">
					<div id="footer-content-text">
						<a href="http://www.iitk.ac.in" target="_blank">IIT Kanpur</a> | <a href="http://in.yahoo.com" target="_blank">Yahoo! Homepage</a><br />
						<b>Webmaster: </b><a href="mailto:aritrasaha90@ymail.com;sumit.innovation@gmail.com;agasheesh@gmail.com;karan.kornguy@gmail.com">Bhayanak Maut</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
