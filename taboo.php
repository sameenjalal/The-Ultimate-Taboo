<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Taboo</title>
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
						'url': '/taboo/contact.php',
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
					<input type="Submit" name="easy" value="     Play Easy!     " id="easy"/>
					<br>
					<br>
					<input type="Submit" name="hard" value="     Play Hard!     " id="hard"/>
					<br>
					<br>
					<input type="Submit" name="dirty" value="     Play Dirty!     " id="dirty"/>
				</form>

				<div id="overlay" class="overlay"> 
					<div id="details">
						<a id="overlay-close" class="close" title="Close">Close </a>
						<br>
						<span id="message">Leave us comments or suggestions!</span> <br>
						<form action="contact.php" method="get" id="message_sent">
							<textarea name="message_box" id="message_box"></textarea>
							<input type="Submit" name="message_input" value="Send" id="message_input" />
						</form>
					</div>
				</div>

					<br>
					<br>
					<input type="Submit" name="input" value="Input?" id="input_button" />

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
