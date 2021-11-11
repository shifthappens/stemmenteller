Film Titel;Cijfer;Aantal stemmen<?= $this->uri->segment(4) == 'publieksprijs' ? ';Niet genoeg stemmen' : ''?>
<?php
print "\r\n";
foreach($movies->result() as $movie):
	$gradeinfo = $this->Votings_model->calculate_grade($movie->movie_id);
	print '"'.$movie->movie_name.'";';
	print number_format((double)$gradeinfo['grade'], 2).';';
	print $gradeinfo['totalvotes'];
	if($gradeinfo['totalvotes'] <= $this->config->item('voting_minimum') && $this->uri->segment(4) == 'publieksprijs')
		print ';*';
	else
		print ';';
	print "\r\n";
endforeach;