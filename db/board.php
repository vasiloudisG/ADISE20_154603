<?php

//klhsh tou procedure clear_game
function reset_board(){
  	global $mysqli;
  	$sql = 'CALL `clear_game`()';
  	$mysqli->query($sql);
}

function show_board()
{
	header('Content-type: application/json');
	print json_encode(read_board(), JSON_PRETTY_PRINT);
}

function read_board() {
	global $mysqli;
	$sql = 'select * from board';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	return($res->fetch_all(MYSQLI_ASSOC));
}

function move_board_piece($input){
	$token = $input['token'];
	if ($token == null || $token == '') {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg' => "token is not set."]);
		exit;
	} else {

		$column_pick = $input['move'];
		$piece_color = $input['piece_color'];
		global $mysqli;
		$sql = 'call `play`(?,?);';
		$st = $mysqli->prepare($sql);
		$st->bind_param('is', $column_pick, $piece_color);
		$st->execute();

		header('Content-type: application/json');
		print json_encode(read_board(), JSON_PRETTY_PRINT);
	}
}





















 ?>
