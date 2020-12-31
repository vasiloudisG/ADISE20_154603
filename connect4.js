var me = { username: null, piece_color: null };

function draw_empty_board() {
	var table='<table id="score4_table">';
	for(var i=6;i>0;i--) {
		table += '<tr>';
		for(var j=1;j<8;j++) {
			table += '<td class="score4_square" id="square_'+j+'_'+i+'">' + j +','+i+'</td>';
		}
		table+='</tr>';
	}
	table+='</table>';
	$('#score4_board').html(table);
}

function fill_board() {
	$.ajax(
	   {url: "connect4.php/board",
		method: 'GET',
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
		contentType: 'application/json',
		data: JSON.stringify( {username:$('#username').val(),piece_color: $('#piece_color').val() }),
		success: login_result,
		error: login_error});
}

function login_error(data) {
    var x = data.responseJSON;
    alert(x.errormesg);
	// Εάν συνέβη λάθος, εμφανίζουμε το μήνυμα λάθους.
}

function login_result(data) {
	me = data[0];
	$('#game').hide();
	update_info();
	game_start();
	//Εάν ΔΕΝ συνέβη λάθος, κρατάμε την global μεταβλητή me (την ορίσαμε αρχικά στο .js).
	//Ενημερώνουμε το info_div.
	//ξεκινάμε το παιχνίδι.
}