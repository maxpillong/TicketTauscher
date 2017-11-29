<html>
 <head>
  <title>PHP-Test</title>
	<style>
		#matchtile {
		font-family: myfont;
		background: white;
		width:265px;
		border: 1px #A8A8A8;
		box-shadow: 0 0 0.4em #808080;
		letter-spacing: 0.15em;
		overflow: hidden;
	}
	#matchtile:hover {
		font-family: myfont;
		background-image: url("../tiles/bmg.png");
		width:265px;
		height:510px;
		border: 1px #A8A8A8;
		box-shadow: 0 0 0.4em #808080;
		letter-spacing: 0.15em;
		overflow: hidden;
	}
	</style>
 </head>
 <body>
 <?php echo '<p>Hallo Welt</p>'; ?>

<?php
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
    echo "Sie benutzen Microsofts Internet Explorer.<br />";
}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE){
	echo"Firefox<br/>" ;
}

  echo $_SERVER['HTTP_USER_AGENT'];
?>
<?php echo"
<table>
	<tr>
		<td>
			<div id='matchtile'><img src=../tiles/halfbmg.png width=265px></div>
		</td>

	</tr>
</table>"
?>

 </body>
</html>