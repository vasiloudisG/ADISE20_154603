var me = { username: null, token: null, piece_color: null };

$(function() {
    draw_empty_board();

      $('#log_in_button').click(login_to_game);
      $('#reset_button').click(reset_game);
}
);

function draw_empty_board() {
	var board= '<table id="score4_table">';
	for(var i=6;i>0;i--) {
		board += '<tr>';
		for(var j=1;j<8;j++) {
			board += '<td class="score4_square" id="square_'+j+'_'+i+'">' + j +','+i+'</td>';
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
        var id = '#square_' + box.x + '_' + box.y;
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
    var x = data.responseJSON.errormesg;
    alert(x);
	// Εάν συνέβη λάθος, εμφανίζουμε το μήνυμα λάθους.
}

function login_result(data) {
	me = data[0];
	$('#game').hide();
  console.log(data);
	//update_info();
	//game_start();
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
	}
