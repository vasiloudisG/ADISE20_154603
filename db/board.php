<?php

//klhsh tou procedure clear_game
function reset_board(){
  	global $mysqli;
  	$sql = 'CALL `clear_game`()';
  	$mysqli->query($sql);
}

























 ?>
