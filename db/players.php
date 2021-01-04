<?php

function  manage_player($method, $input){
    if ($method == 'GET') {
          show_player($input['piece_color']);
      } else if ($method == 'PUT') {
          create_player($input);
      }
}

//epistrofh paikth me to xrwma tou
function show_player($piece_color){
    global $mysqli;
    $sql = 'select username,piece_color,token from players where piece_color=?';
    $st = $mysqli->prepare($sql);
    $st->bind_param('s', $piece_color);
    $st->execute();
    $res = $st->get_result();
    header('Content-type: application/json');
    print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

//epistrofh twn paiktwn pou uparxoun vash
function show_players(){
    global $mysqli;
    $sql = 'select count(*) as p from players where username is not null';
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    $players = $res->fetch_assoc()['p'];
    return($players);
  }

function create_player($input){

    if (!isset($input['username'])) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "No username found."]);   //?
        exit;
    }
    $username = $input['username'];
    $piece_color = $input['piece_color'];
    global $mysqli;
    $sql = 'select count(*) as count from players where username=?';
    $st = $mysqli->prepare($sql);
    $st->bind_param('s', $username);
    $st->execute();
    $res = $st->get_result();
    $res_count = $res->fetch_all(MYSQLI_ASSOC);
    if ($res_count[0]['count'] > 0) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "This username already exists.Try something else"]);
        exit;
    }

    $sql2 = 'select count(*) as count from players where piece_color=? and username is not null';
    $st2 = $mysqli->prepare($sql2);
    $st2->bind_param('s', $piece_color);
    $st2->execute();
    $res2 = $st2->get_result();
    $res_count2 = $res2->fetch_all(MYSQLI_ASSOC);
    if ($res_count2[0]['count'] > 0) {
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "The color you picked is already taken."]);
        exit;
    }

    $sql3 = 'update players set username=?, token=md5(CONCAT( ?, NOW())) where piece_color=?';
    $st3 = $mysqli->prepare($sql3);
    $st3->bind_param('sss', $username, $username, $piece_color);
    $st3->execute();

    update_game_status();
    $sql4 = 'select * from players where piece_color=?';
    $st4 = $mysqli->prepare($sql4);
    $st4->bind_param('s', $piece_color);
    $st4->execute();
    $res4 = $st4->get_result();
    header('Content-type: application/json');
    print json_encode($res4->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}




?>
