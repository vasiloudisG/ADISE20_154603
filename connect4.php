<?php

require_once "db/dbconnect.php";
require_once "db/board.php";
require_once "db/players.php";
require_once "db/game.php";
require_once "db/winner_rules.php";

//??
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);
if (isset($_SERVER['HTTP_X_TOKEN'])) {
    $input['token'] = $_SERVER['HTTP_X_TOKEN'];
}

//sumfona me ta parapanw epilegoume thn katallhlh methodo apo to swsto db/ .
switch ($r=array_shift($request)) {
  case 'board':
      switch ($b=array_shift($request)) {
          case 'reset':
                   reset_board();
                   break;
          case '':
          case 'move': handle_board($method,$input); //?
                   break;
          case 'piece': handle_piece($method,$input);
                   break;
          default: header("HTTP/1.1 404 Not Found");
                   break;
                }
              break;
  case 'players': handle_player($method,$input);
              break;

   case 'game_status':
          if(sizeof($request)==0) {show_status();}
          else {header("HTTP/1.1 404 Not Found");}
			             break;

   default:  header("HTTP/1.1 404 Not Found");
                   exit;
}

function handle_board($method,$input) {
    if($method=='GET') {
          show_board($input);
  } else if($method=='POST') {
          reset_board();
          show_board($input);
          }
}

function handle_piece($method,$input) {
       	if($method=='GET') {
		        show_board_piece($x,$y);
	      }else if($method=='PUT') {
		        move_board_piece($input);
	         }
}

function handle_player($method,$input) {
    manage_player($method, $input);
}


 ?>
