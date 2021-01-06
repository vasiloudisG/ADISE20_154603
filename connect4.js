var me = { username: null, token: null, piece_color: null };
var timer = null;

$(function() {
    draw_empty_board();
      //$('#move_pick').hide();
      $('#log_in_button').click(login_to_game);
      $('#reset_button').click(reset_game);
      $('#play_button').click(play);
      update_game_status();


}
);

function draw_empty_board() {
	var board= '<table id="score4_table">';
	for(var i=1;i<7;i++) {
		board += '<tr>';
		for(var j=1;j<8;j++) {
			board += '<td class="score4_box" id="box_'+i+'_'+j+'">' + i +','+j+'</td>';
		}
		//console.log("=/");
		board+='</tr>';
	}
	board+='</table>';
	$('#board').html(board);
}

function fill_board() {
	$.ajax(
	  {url: "connect4.php/board",
		method: 'GET',
		dataType: 'json',
		headers: { "X-Token": me.token },
		success:fill_board_data
		}
		);
}

function fill_board_data(data) {
    for (var i=0; i<data.length; i++) {
        var box = data[i];
        var id = '#box_' + box.x + '_' + box.y;
        if (box.piece_color == 'R') {
            $(id).css('background-color', 'red');
        }
        if (box.piece_color == 'Y') {
            $(id).css('background-color', 'yellow');
        }
// Το data είναι ένας array που αντιστοιχεί στα στοιχεία του πίνακα board από την βάση.
// Το διατρέχουμε. Κάθε στοιχείο του έχει .x και .y .
// Βρίσκουμε το id στο οποίο αντιστοιχεί το κάθε element του πίνακα.
    }
}

function login_to_game() {
	if($('#username').val()=='') {
		alert('You have to set a username');
		return;
	}

	$.ajax({url: "connect4.php/players/",
		method: 'PUT',
		dataType: "json",
		headers: { "X-Token": me.token },
		contentType: 'application/json',
		data: JSON.stringify( {username:$('#username').val(),piece_color: $('#piece_color').val() }),
		success: login_result,
		error: login_error});
}

function login_error(data) {
    //var x = data.responseJSON.errormesg;
    console.log(data);

    //alert(x);
	// Εάν συνέβη λάθος, εμφανίζουμε το μήνυμα λάθους.
}

function login_result(data) {
	me = data[0];
	$('#game').hide();
  alert("Welcome "+$('#username').val());
  $('#move_pick').show();
  console.log(data);
	//update_info();
	update_game_status();
	//Εάν ΔΕΝ συνέβη λάθος, κρατάμε την global μεταβλητή me (την ορίσαμε αρχικά στο .js).
	//Ενημερώνουμε το info_div.
	//ξεκινάμε το παιχνίδι.
}

function reset_game() {
    $.ajax({
        url: "connect4.php/board/reset/",
        method: 'POST',
        headers: { "X-Token": me.token },
        success: draw_empty_board
    });
      $('#username').val("");
      me = { username: null, token: null, piece_color: null };
      $('#game').show();
      update_game_status();
	}

  function play(){
    var $move = $('#column_pick').val();

    $.ajax({
        url: "connect4.php/board/piece/",
        method: 'PUT',
        dataType: 'json',
        headers: { "X-Token": me.token },
        contentType: 'application/json',
        data: JSON.stringify({ move: $move, piece_color: me.piece_color }),
        success: result_move,
        error: login_error
    });
  }

  function result_move(data) {
    update_game_status();
    fill_board();

}

function update_game_status() {
    clearTimeout(timer);
    $.ajax({
        url: "connect4.php/game_status/",
        headers: { "X-Token": me.token },
        success: update_status,
        error: login_error
    });
}

function update_status(data){
  p_turn = data[0].p_turn;
  status = data[0].status;
  fill_board();
  // if (game_status.status == 'aborted') {
  //     $('#game').hide(2000);
  //     timer = setTimeout(function() { update_game_status(); }, 4000);
      if (status == 'ended') {
          // $('#game').hide(1000);
          if (data[0].result=='R') {
            alert("Red Won!");
          }else if(data[0].result=='Y'){
            alert("Yellow Won!");
          }
          timer = setTimeout(function() {
             update_game_status();
             reset_game();
           }, 5000);
      } else if (p_turn == me.piece_color && me.piece_color != null) {
          document.getElementById("play_button").disabled = false;
          timer = setTimeout(function() {
             update_game_status();
           }, 10000);
      } else {
          timer = setTimeout(function() {
             update_game_status();
           }, 4000);
      }

}
