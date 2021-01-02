<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Score 4</title>
    <link rel="stylesheet" href="connect4.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="connect4.js"></script>

  </head>
  <body>
    <h1>Score 4</h1>
    <div class="" id="board">

    </div>
    <br>
    <div class="info" id="game">
      Enter your name: <input type="text" id="username"><br>
      Select your color: <select id="piece_color">
            <option value="R">R</option>
            <option value="Y">Y</option>
      </select><br>
      <button type="button" id="log_in_button">LOG IN</button>
    </div>
<br>
	<div class="move_pick" id="move_pick">
    Select the column to insert the piece:
    <select id="colum_pick">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
    </select>
    <button type="button" id="play_button">PLAY</button>
    <button type="button" id="reset_button">RESET</button>
  </div>
  </body>
</html>
