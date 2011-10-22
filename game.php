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
<?php
	function db_connect() {
		mysql_connect('mysql.vverma.net', 'vverna', 'Verma123');
		mysql_select_db('taboo_generator');
	}
	function db_query() {
		$num_args = func_num_args();

		$args = array();
		for($i=0; $i < $num_args; $i++)
		{
			$args[] = func_get_arg($i);
		}
		$res = mysql_query(call_user_func_array(sprintf, $args)) or die(mysql_error());

		return $res;

	}

	function db_fetch_all($res) {
		$rv = array();

		while($row = mysql_fetch_assoc($res))
		{
			$rv[] = $row;
		}

		return $rv;
	}

	function debug_r($arr) {
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}

	function parse_from_db($text)
	{
		$text = trim($text, '[]');

		return array_map(create_function('$s','return trim($s);'), explode(',', $text));
	}


	db_connect();

	$results = db_fetch_all(db_query('SELECT * FROM taboo_words'));

	if(!is_numeric($_REQUEST['id']) || $_REQUEST['id'] < 0)
		$_REQUEST['id'] = 0;
	$word_card = max($results[$_REQUEST['id']], count($results)-1);

	$associated_words = parse_from_db($word_card['associated']);

?>
		
				<table id="card" border= "1px">
				<tr class="target_word"><strong> <th><?= $word_card['word']; ?></th> </strong></td>
<?
	for($i=0; $i<6; $i++) {
?>
		<tr> <td><?= strtoupper($associated_words[$i]); ?></td> </tr>	
<?
	}
?>
				</table> <br>

				<a href="/taboo/game.php?id=<?= $_REQUEST['id'] + 1; ?>"> <button id="next"> Next </button></a>
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
