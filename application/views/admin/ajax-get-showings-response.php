<?php
setlocale(LC_TIME, 'nl_NL');

if($response->num_rows() == 0):
?>
<option value="NULL" disabled>Geen vertoonmomenten gevonden</option>
<?php
exit;
else:
?>
<option value="NULL" selected disabled>Kies een vertoonmoment...</option>
<option value="NULL" disabled>-------------------</option>
<?php
foreach($response->result() as $row):
?>
<option value="<?=$row->showing_id?>"><?=strftime('%a %e %b %H:%M', $row->showing_datetime)?></option>
<?php
endforeach;
endif;
?>