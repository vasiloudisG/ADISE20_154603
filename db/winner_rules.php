<?php
function convert_board(&$main_board) {
	$board=[];
	foreach($main_board as $i=>&$row) {
		$board[$row['x']][$row['y']] = &$row;
	}
	return($board);
}

function check_winner(){
  global $mysqli;
  $main_board = read_board();
  $board = convert_board($main_board);
  $Red_W = false;
  $Yellow_W = false;

  //Elegxw orizontia gia score4
  for ($i = 6; $i >= 1; $i--) {
    for ($j = 1; $j <= 4; $j++) {
      if ($board[$i][$j]['piece_color'] == 'R'){
        $x=$j+1;
        if ($board[$i][$x]['piece_color'] == 'R'){
          $x=$j+2;
          if ($board[$i][$x]['piece_color'] == 'R'){
            $x=$j+3;
            if ($board[$i][$x]['piece_color'] == 'R'){
              $Red_W=true;
              break;
}}}}
      elseif ($board[$i][$j]['piece_color'] == 'Y'){
        $x=$j+1;
        if ($board[$i][$x]['piece_color'] == 'Y'){
          $x=$j+2;
          if ($board[$i][$x]['piece_color'] == 'Y'){
            $x=$j+3;
            if ($board[$i][$x]['piece_color'] == 'Y'){
              $Yellow_W=true;
              break;
}}}}}}

  //Elegxw katheta gia score4
  for ($i = 6; $i >= 4; $i--) {
      for ($j = 7; $j >= 1; $j--) {
        if ($board[$i][$j]['piece_color'] == 'R'){
          $x=$i-1;
          if ($board[$x][$j]['piece_color'] == 'R'){
            $x=$i-2;
            if ($board[$x][$j]['piece_color'] == 'R'){
              $x=$i-3;
              if ($board[$x][$j]['piece_color'] == 'R'){
                  $Red_W=true;
                  break;
}}}}
        elseif ($board[$i][$j]['piece_color'] == 'Y'){
          $x=$i-1;
          if ($board[$x][$j]['piece_color'] == 'Y'){
            $x=$i-2;
            if ($board[$x][$j]['piece_color'] == 'Y'){
              $x=$i-3;
              if ($board[$x][$j]['piece_color'] == 'Y'){
                  $Yellow_W=true;
                  break;
}}}}}}

  //Elegxw diagwnia apo katw aristera pros ta panw deksia
  for ($i=6; $i>=4; $i--){
        for ($j=1; $j<=4; $j++){
          if ($board[$i][$j]['piece_color'] == 'R'){
            $x=$i-1;
            $y=$j+1;
            if ($board[$x][$y]['piece_color'] == 'R'){
              $x=$i-2;
              $y=$j+2;
              if ($board[$x][$y]['piece_color'] == 'R'){
                $x=$i-3;
                $y=$j+3;
                if ($board[$x][$y]['piece_color'] == 'R'){
                    $Red_W=true;
                    break;
}}}}
          elseif ($board[$i][$j]['piece_color'] == 'Y'){
            $x=$i-1;
            $y=$j+1;
            if ($board[$x][$y]['piece_color'] == 'Y'){
              $x=$i-2;
              $y=$j+2;
              if ($board[$x][$y]['piece_color'] == 'Y'){
                $x=$i-3;
                $y=$j+3;
                if ($board[$x][$y]['piece_color'] == 'Y'){
                    $Yellow_W=true;
                    break;
}}}}}}

  //Elegxw diagwnia apo panw aristera pros ta katw deksia
  for ($i=1; $i<=3; $i++){
        for ($j=4; $j>=1; $j--){
          if ($board[$i][$j]['piece_color'] == 'R'){
            $x=$i+1;
            $y=$j+1;
            if ($board[$x][$y]['piece_color'] == 'R'){
              $x=$i+2;
              $y=$j+2;
              if ($board[$x][$y]['piece_color'] == 'R'){
                $x=$i+3;
                $y=$j+3;
                if ($board[$x][$y]['piece_color'] == 'R'){
                    $Red_W=true;
                    break;
}}}}
          elseif ($board[$i][$j]['piece_color'] == 'Y'){
            $x=$i+1;
            $y=$j+1;
            if ($board[$x][$y]['piece_color'] == 'Y'){
              $x=$i+2;
              $y=$j+2;
              if ($board[$x][$y]['piece_color'] == 'Y'){
                $x=$i+3;
                $y=$j+3;
                if ($board[$x][$y]['piece_color'] == 'Y'){
                    $Yellow_W=true;
                    break;
}}}}}}

  //Elegxw poios kerdise kai kanw update to status
  if($Red_W){
    $sql = "update game_status set status='ended', result='R' where p_turn is not null and status='started'";
    $st = $mysqli->prepare($sql);
    $r = $st->execute();
  }
  else if($Yellow_W){
    $sql = "update game_status set status='ended', result='Y',p_turn=null where p_turn is not null and status='started'";
    $st = $mysqli->prepare($sql);
    $r = $st->execute();
  }console.log(data);
  else{
    //An den exei kerdisei kaneis akoma
    return;
  }
}

?>
