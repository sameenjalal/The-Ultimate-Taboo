<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Taboo Game</title>
		<meta name="author" content="Sameen Jalal" />
		<link rel="stylesheet" type="text/css" href="main.css" media="screen" />
		<script type="text/javascript" src="/taboo/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="js/core.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#overlay-close').click(function(){
					$('#overlay').hide();
				});

				$('#input_button').click(function(event){
					$('#overlay').show();
					event.preventDefault();
					return false;
				});

                $('#message_sent').submit(function(){
                    $.ajax({ 
                    'url': '/taboo/taboo.php',
                    'data': $(this).serialize()
					});
                    return false;
				});

			});
		</script>
	</head>

	<body id="taboo">

		<div id="wrapper">
			<img src="images/logo.png"/>
		<!--	<h1><font face="Helvetica">Play Taboo Online!</font></h1>-->

			<div id="buttons">
				<br>
				<br>
				<br>

				<form action="game.php" method="get">
		
				<table id="card" border= "1px">
					<tr class="target_word"><strong> <th>penis</th> </strong></td>
					<tr> <td>penis</td> </tr>	
					<tr> <td>penis</td> </tr>	
					<tr> <td>penis</td> </tr>	
					<tr> <td>penis</td> </tr>	
					<tr> <td>penis</td> </tr>	
					<tr> <td>penis</td> </tr>	
				</table> <br>

				<!--	<input type="Submit" name="right" value="right" id="right"/>
					<input type="Submit" name="wrong" value="wrong" id="wrong"/>
					--><input type="Submit" name="pass" value="pass" id="Pass"/>
				</form>

			</div> <!--buttons ends -->
		
		</div> <!-- wrapper ends -->

		<div id="footer">
			<br>
			Copyright &copy; 2011
				<a href="http://sameenjalal.com">Sameen Jalal</a>,
				<a href="http://vverma.net">Vaibhav Verma</a>,
				Joseph Galaro
		</div>
	</body>
</html>
