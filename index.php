<!DOCTYPE html>
<html>
	<head>
	<meta charset="UTF-8">
	<meta name="description" content="EFC Kotter Ticket Tauscher 2000">
	<meta name="keywords" content="Dauertkarte, SGE, ">
	<meta name="author" content="K^3 - kubic design - Jörn Klein, Max Pillong, Sebastian Witt">
	<style type="text/css">
	
	a:link{text-decoration:none;color:#606060}
	a:visited{text-decoration:none;color:#606060}
	a:hover{text-decoration:none;color:#606060}
	a:active{text-decoration:none;color:#606060}
	
	@font-face {
		font-family: "myfont";
		src: url("fonts/l.woff") format('woff');
	}
	
	@font-face {
		font-family: "myfont";
		src: url("fonts/lbi.woff") format('woff');
		font-style: italic;
	}
	
	#preload01 {
        background:url('gfx/button_get_hover.jpg');width:0px;height:0px
	}
	
	#preload02 {
        background:url('gfx/button_offer_hover.jpg');width:0px;height:0px
	}
	
	#preload03 {
        background:url('gfx/final_get_hover.jpg');width:0px;height:0px
	}
	
	#preload04 {
        background:url('gfx/final_offer_hover.jpg');width:0px;height:0px
	}
	
	#content {
		font-family: myfont;
		background-image: url('gfx/bgcontent.png');
		height:100%;
		width:950px;
		margin: 0 auto;
		font-family: myfont;
		overflow:hidden;
	}
	
	.black_overlay{
        display: none;
        position: fixed;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index:1001;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);
    }
	
	.white_content {
		border-radius: 10px 30px;
		background-color: #f4f4f3;
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        padding: 16px;
        border: 3px solid black;
        z-index:1002;
        overflow: auto;
		transform: translate(-50%, -50%);
		width:700px;
		letter-spacing: 0.15em;
    }
	
	<?php 
				//DB Setup
				$db_server = 'rdbms.strato.de';
				$db_user = 'U3175428';
				$db_pw = 'Hellskotter069';
				$db_name = 'DB3175428';
				$connection = mysqli_connect($db_server, $db_user, $db_pw) or die(mysql_error()); //Connect to server
				mysqli_query($connection, "SET NAMES 'utf8'");
				$selected_db = mysqli_select_db($connection, $db_name) or die("Cannot connect to database"); //Connect to database
				//Query to determine upcoming matches
				$sql = mysqli_query($connection, "SELECT matches.match_id FROM matches INNER JOIN opponents ON matches.opponent = opponents.opponent_id WHERE date >= CURDATE() ORDER BY date LIMIT 3");
				while ($row = $sql->fetch_assoc()){
					$matchid = $row['match_id'];
					echo "#matchtile" . $matchid . " {
		font-family: myfont;
		background: white;
		width:265px;
		height:510px;
		border: 1px #A8A8A8;
		box-shadow: 0 0 0.4em #808080;
		letter-spacing: 0.15em;
		overflow: hidden;
		}
	
	";
				}
	?>
	
	#ticket {
		font-family: myfont;
		width:108px;
		height:20px;
		background-image: url("gfx/ticket_bg_sm.png");
		line-height: 23px;
		text-align: center;
	}
	
	
	#buttonget {
		background-image: url('gfx/button_get.jpg');
		height: 18px;
		width: 112px;
	}
	
	#buttonget:hover {
		background-image: url('gfx/button_get_hover.jpg');
	}
	
	#buttonoffer {
		background-image: url('gfx/button_offer.jpg');
		height: 18px;
		width: 112px;
	}
	
	#buttonoffer:hover {
		background-image: url('gfx/button_offer_hover.jpg');
	}

	</style>
	<title>EFC Kotter Ticket Tauscher 2000</title>
	</head>
	<body bgcolor=#808080>
	<div id="preload01"></div>
	<div id="preload02"></div>
	<div id="preload03"></div>
	<div id="preload04"></div>
	<div id="header" style="width:100%;">
    <div id="content">
	<center>
	<table style="border-spacing:10px;">
	<tr>
	<td><br>
		<img src="gfx/header.jpg">
	</td>
	</tr>
	</table><br>
	<img src="gfx/header.png" width="950px"><br><br>
	<table style="border-spacing:35px;">
		<tr>
			<?php 
				//Query to determine upcoming matches
				$sql = mysqli_query($connection, "SELECT matches.match_id, matches.date, opponents.name, opponents.tile, matches.time, matches.opponent, matches.type_id FROM matches INNER JOIN opponents ON matches.opponent = opponents.opponent_id WHERE date >= CURDATE() ORDER BY date LIMIT 3");
				while ($row = $sql->fetch_assoc()){
					//Generate useful variables
					$months = array('JAN', 'FEB', 'MÄR', 'APR','MAI','JUN', 'JUL', 'AUG', 'SEP', 'OKT','NOV','DEZ');
					$days = array('SONNTAG', 'MONTAG', 'DIENSTAG', 'MITTWOCH','DONNERSTAG','FREITAG', 'SAMSTAG');
					$tl = array('tl_green.jpg','tl_yellow.jpg','tl_red.jpg');
					$desc = array('Es gibt freie Karten! Jetzt anmelden und du bist dabei!','Aktuell keine Warteliste! Jetzt anmelden und die nächste freie Karte ist dir!','Es sind bereits Leute vor dir in der Warteliste!');
					$matchdate = $row['date'];
					$matchid = $row['match_id'];
					//Query for tickets wanted
					$wantedtix = mysqli_query($connection, "SELECT * FROM exchanges INNER JOIN users ON exchanges.pers_id = users.pers_id WHERE match_id=" . $row['match_id'] . " AND exchanges.ticket_id IS NULL ORDER BY created");
					//Query for finished exchanges
					$takentix = mysqli_query($connection, "SELECT exchanges.created, tickets.name AS ownername, users.name FROM exchanges INNER JOIN tickets ON exchanges.ticket_id = tickets.ticket_id INNER JOIN users ON exchanges.pers_id = users.pers_id WHERE match_id=" . $row['match_id'] . " AND exchanges.pers_id IS NOT NULL AND exchanges.ticket_id IS NOT NULL ORDER BY created;");
					//Query for free tickets
					$freetix = mysqli_query($connection, "SELECT * FROM exchanges INNER JOIN tickets ON exchanges.ticket_id = tickets.ticket_id WHERE match_id=" . $row['match_id'] . " AND pers_id IS NULL ORDER BY created;");
					//Count wanted and free tickets to determine availability status
					$wantedcount = mysqli_num_rows($wantedtix);
					$freecount=mysqli_num_rows($freetix);
					$status = 0;
					if ($wantedcount>=1) {
						$status = 2;
					}
					else {
						if ($freecount>=1) {
							$status = 0;
						}
						else {
							$status = 1;
						}
					}
					echo "<td><div id='matchtile" . $matchid . "'><img src=tiles/" . $row['tile'] . ".jpg width=265px><br>
							<table border=0>
								<tr>
									<td width=5px>
									</td>
									<td><table width=100% border=0><tr><td width=70%><i><font size = 6>SGE - " . $row['name'] . "</font></i></td><td width=30% align=right><img src='gfx/" . $tl[$status] . "' alt='Verf&uuml;gbarkeitsampel' title='" . $desc[$status] . "' /></td></tr></table>
										<table width=100%><tr><td>" . $days[date('w', strtotime($row['date']))]. " " . date("d. ", strtotime($row['date'])) . $months[date("m", strtotime($row['date']))-1] . date(" Y", strtotime($row['date'])) . "<br>
										" . date("G:i", strtotime($row['time'])) . " UHR</td></tr></table>
										<center><table><tr><td>
										<br>
										<a href = 'javascript:void(0)' onclick = \"document.getElementById('tr_" . $matchid . "').style.display='block';document.getElementById('fade').style.display='block'\">
										<div id='buttonget'></div>
										</a>
										</td></tr><tr><td>
										
										<a href = 'javascript:void(0)' onclick = \"document.getElementById('to_" . $matchid . "').style.display='block';document.getElementById('fade').style.display='block'\">
										<div id='buttonoffer'></div>
										</a><br>
									
										</td></tr><tr height=10px><td></td></tr></table>
										</center>
										<i>&Uuml;BERSICHT</i><br>
										<table width=240px border=0>";
										while ($tk_tickets = $takentix->fetch_assoc()){
											echo "<tr><td width=108px align='left'><div id='ticket'>&nbsp;" . strtoupper($tk_tickets['ownername']) . "</div></td><td width=14px><img src='gfx/arrow2.jpg'></td><td width=100px align='left'>" . strtoupper($tk_tickets['name']) . "</td></tr>";
										}
										while ($av_tickets = $freetix->fetch_assoc()){
											echo "<tr><td width=108px align='left'><div id='ticket'>&nbsp;" . strtoupper($av_tickets['name']) . "</div></td><td width=14px><img src='gfx/arrow2.jpg'></td><td width=100px align='left'>???</td></tr>";
										}
										while ($wa_tickets = $wantedtix->fetch_assoc()){
											echo "<tr><td width=108px align='left'><div id='ticket'><center>???</center></div></td><td width=14px><img src='gfx/arrow2.jpg'></td><td width=100px align='left'>" . strtoupper($wa_tickets['name']) . "</td></tr>";
										}
										echo "</table></td>
								</tr>
							</table>
					</div></td>";
				}
			?>
		</tr>
	</table>
	<?php 
				//Query to determine upcoming matches
				$ticketnames = mysqli_query($connection, "SELECT ticket_id, name FROM tickets;");
				$usernames = mysqli_query($connection, "SELECT name FROM users;");
				$sql = mysqli_query($connection, "SELECT matches.match_id, matches.date, matches.time, opponents.name FROM matches INNER JOIN opponents ON matches.opponent = opponents.opponent_id WHERE date >= CURDATE() ORDER BY date LIMIT 3");
				while ($row = $sql->fetch_assoc()){
					//Individual ticket request dialogue box
					echo "<div id='tr_" . $row['match_id'] . "' class='white_content'><center>
					<center><p><img src='gfx/bar.png'></p>
					<table border=0 width=550px>
						<tr>
							<td width=50px></td>
							<td width=*><p><font size=6><center><i>ICH WILL HIN!</i></center></font></p></td>
							<td width=50px><a href='javascript:void(0)' onclick = \"document.getElementById('tr_" . $row['match_id'] . "').style.display='none';document.getElementById('fade').style.display='none'\"><font style='font-size:40px;color:#808080;'>[X]</font></a></td>
						</tr>
					</table>
					<p><img src='gfx/bar.png'></p>
					<table border=0 width=550px>
						<tr>
							<td width=375px><font size=6><i>SGE - " . $row['name'] . "</td>
							<td width=375px;></td>
						</tr>
						<tr>
							<td width=300px>" . $days[date('w', strtotime($row['date']))]. " " . date("d. ", strtotime($row['date'])) . $months[date("m", strtotime($row['date']))-1] . date(" Y", strtotime($row['date'])) . "</td>
							<td width=300px>" . date("G:i", strtotime($row['time'])) . " UHR</td>
						</tr>
					</table>
					<p><img src='gfx/bar.png'></p>
					<table border=0 width=550px>
						<tr>
							<td width=375px>&nbsp</td>
							<td width=375px;></td>
						</tr>
						<tr>
							<td width=300px>DEIN NAME?</td>
							<td width=300px><select name='owner'>
							<option selected='selected' value=\"owner1\">Bitte w&auml;hlen ...</option>";
							while ($row = $usernames->fetch_assoc()){
								echo "<option value=\"owner1\">" . $row['name'] . "</option>";
							}
							echo "</select>
							</td>
						</tr>
					</table><br>
					<p><img src='gfx/bar.png'></p>
					<br>
					<table border=0 width=550px>
						<tr>
							<td align='right'>
								<img src='gfx/button_get.jpg'>
							</td>
						</tr>
					</table>
					<br>
					</center>
					</div>
					";
					//Individual ticket offer dialogue box
					echo "<div id='to_" . $row['match_id'] . "' class='white_content'><center>
					<center><p><img src='gfx/bar.png'></p>
					<table border=0 width=550px>
						<tr>
							<td width=50px></td>
							<td width=*><p><font size=6><center><i>BIETE KARTE</i></center></font></p></td>
							<td width=50px><a href='javascript:void(0)' onclick = \"document.getElementById('to_" . $row['match_id'] . "').style.display='none';document.getElementById('fade').style.display='none'\"><font style='font-size:40px;color:#808080;'>[X]</font></a></td>
						</tr>
					</table>
					<p><img src='gfx/bar.png'></p>
					<table border=0 width=550px>
						<tr>
							<td width=375px><font size=6><i>SGE - " . $row['name'] . "</td>
							<td width=375px;></td>
						</tr>
						<tr>
							<td width=300px>" . $days[date('w', strtotime($row['date']))]. " " . date("d. ", strtotime($row['date'])) . $months[date("m", strtotime($row['date']))-1] . date(" Y", strtotime($row['date'])) . "</td>
							<td width=300px>" . date("G:i", strtotime($row['time'])) . " UHR</td>
						</tr>
					</table>
					<p><img src='gfx/bar.png'></p>
					<table border=0 width=550px>
						<tr>
							<td width=375px>&nbsp</td>
							<td width=375px;></td>
						</tr>
						<tr>
							<td width=300px>WESSEN DAUERKARTE?</td>
							<td width=300px><select name='owner'>
							<option selected='selected' value=\"owner1\">Bitte w&auml;hlen ...</option>";
							while ($row = $ticketnames->fetch_assoc()){
								echo "<option value=\"owner1\">" . $row['name'] . "</option>";
							}
							echo "</select>
							</td>
						</tr>
					</table><br>
					<p><img src='gfx/bar.png'></p>
					<br>
					<table border=0 width=550px>
						<tr>
							<td align='right'>
								<img src='gfx/button_offer.jpg'>
							</td>
						</tr>
					</table>
					<br>
					</center>
					</div>
					";
				}
	?>
	</center>
	</div>
	</div>
	<div id="fade" class="black_overlay"></div>
	</body>
</html>
<!-- Here be dragons! -->
