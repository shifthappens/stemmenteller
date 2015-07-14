Film Titel;Cijfer;Aantal stemmen;Niet genoeg stemmen
<?php
foreach($movies->result() as $movie):
$gradeinfo = $this->Votings_model->calculate_grade($movie->movie_id);
print '"'.$movie->movie_name.'";';
print number_format((double)$gradeinfo['grade'], 2).';';
print $gradeinfo['totalvotes'];
if($gradeinfo['totalvotes'] >= 100 && $movie->movie_can_win == "1")
	print ';*';
print "\r\n";
endforeach;