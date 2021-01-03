<?php

function show_status() {

	global $mysqli;
	$sql = 'select * from game_status';
	$st = $mysqli->prepare($sql);

	$st->execute();
	$res = $st->get_result();

	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

}

function check_abort() {

  global $mysqli;
	$sql = "UPDATE game_status SET status='aborded', result=if(p_turn='R','Y','R'),p_turn=null where p_turn is not null and last_change<(now()-INTERVAL 2 MINUTE) and status='started'";
	$st = $mysqli->prepare($sql);
	$r = $st->execute();
}

function read_status() {
	global $mysqli;

	$sql = 'select * from game_status';
	$st = $mysqli->prepare($sql);

	$st->execute();
	$res = $st->get_result();
	$status = $res->fetch_assoc();
	return($status);
}

function update_game_status() {
	global $mysqli;

	$status = read_status();
	$new_status=null;
	$new_turn=null;

	$st3=$mysqli->prepare('select count(*) as aborted from players WHERE last_action< (NOW() - INTERVAL 15 MINUTE)');
	$st3->execute();
	$res3 = $st3->get_result();
	$aborted = $res3->fetch_assoc()['aborted'];
	if($aborted>0) {
		$sql = "UPDATE players SET username=NULL, token=NULL WHERE last_action< (NOW() - INTERVAL 15 MINUTE)";
		$st2 = $mysqli->prepare($sql);
		$st2->execute();
		if($status['status']=='started') {
			$new_status='aborted';
		}
	}

  $sql = 'select count(*) as count from players where username is not null';
  	$st = $mysqli->prepare($sql);
  	$st->execute();
  	$res = $st->get_result();
  	$active_players = $res->fetch_assoc()['count'];

  	switch($active_players) {
  		case 0: $new_status='not active'; break;
  		case 1: $new_status='initialized'; break;
  		case 2: $new_status='started';
  				if($status['p_turn']==null) {
  					$p_turn = rand(0, 1) ? 'R' : 'Y';
  				}
  				break;
  	}

  	$sql = 'update game_status set status=?, p_turn=?';
  	$st = $mysqli->prepare($sql);
  	$st->bind_param('ss',$new_status,$new_turn);
  	$st->execute();

  }



?>
