<?php
setlocale(LC_ALL, 'nl_NL');
$this->load->view('header');
$this->load->view('admin/loginbar');
?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">
            <?php if($this->uri->segment(3) == "add"): $editing = FALSE; ?>
            Nieuwe Film toevoegen
            <?php else: $editing = TRUE; ?>
            Film '<?=$movie->movie_name?>' aanpassen
            <?php endif; ?>
        </h1>

        <?php if($this->session->userdata('message') !== NULL): ?>
        <div class="alert alert-<?=$this->session->userdata('message-type')?>"><?=$this->session->userdata('message')?></div>
        <?php endif; ?>

        <?php if($this->session->userdata('message-type') === "success"): ?>
        <a class="btn btn-danger" href="admin/movies/<?= $editing ? '' : 'add'?>"><?= $editing ? 'Terug naar Filmoverzicht' : 'Voeg nog een Film toe' ?></a>
        <?php
            $this->session->unset_userdata('message-type');
            $this->session->unset_userdata('message');
            else:
            echo validation_errors('<div class="alert alert-danger">', '</div');
        ?>

            <form action="admin/movies/<?= $editing ? 'edit/'.$movie->movie_id : 'add' ?>" method="post">
                <?php if($editing): ?><input type="hidden" name="movie_id" value="<?=$movie->movie_id?>" /><?php endif; ?>
                <table id="movies" class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="movie-name">Film Titel</td>
                            <td class="movie-name-value"><input type="text" size="80" name="movie_name" placeholder="Voer een titel in..." value="<?= $editing ? $movie->movie_name : set_value('movie_name')?>" /></td>
                        </tr>
                        <tr>
                            <td class="movie-can-win">Dingt mee voor Publieksprijs?<br />
                                <small>Indien een film niet meedingt, wordt het een Barometer film</small></td>
                            <td class="movie-can-win-value">
                                <span class="radio-choice"><input type="radio" <?= $editing && $movie->movie_can_win ? 'checked' : set_radio('movie_can_win', '1', TRUE)?> name="movie_can_win" value="1" /> Ja</span>
                                <span class="radio-choice"><input type="radio" <?= $editing && !$movie->movie_can_win ? 'checked' : set_radio('movie_can_win', '0')?> name="movie_can_win" value="0" /> Nee</span>
                            </td>
                        </tr>
                        <?php for($i = 0; $i <= 4; $i++): ?>
                        <tr>
                            <td class="movie-showing">Vertoonmoment <?=$i+1?></td>
                            <td class="movie-showing-value">
                                <!-- <?= $showing[$i]['showing_datetime'] . ' = ' . date('Y-m-d H:i', $showing[$i]['showing_datetime']) ?> -->
                                <select name="movie_showings[<?=$i?>][date]">
                                    <option value="NULL">Vertoonmoment <?=$i+1?></option>
                        <?php
	                        $interval = new DateInterval('P1D');
	                        $start = new DateTime($this->config->item('festival_date_start'));
	                        $end = new DateTime($this->config->item('festival_date_end'));
	                        $end = $end->modify("+1 day");
							$daterange = new DatePeriod($start, $interval, $end);
                            $datefound = FALSE; //In case a date is imported that is not within the start and end date of the festival, we can check against this

							foreach($daterange as $date):
								$dateymd = $date->format('Y-m-d');
						?>
                                    <option value="<?=$dateymd?>"<?php if($editing && isset($showing[$i]) && date_match($showing[$i]['showing_datetime'], $dateymd) === true) { echo 'selected'; $datefound = TRUE; } else { set_select('movie_showings[$i][date]', $dateymd); } ?>><?=strftime('%a %e %b %Y', strtotime($dateymd) )?></option>
						<?php endforeach; ?>
                                    <?php
                                        if($datefound === FALSE && isset($showing[$i]))
                                        {
                                    ?>
                                    <option selected value="<?= date('Y-m-d', $showing[$i]['showing_datetime'])?>"><?=strftime('%A %e %b %Y', $showing[$i]['showing_datetime'])?></option>
                                    <?php        
                                        }
                                    ?>

                                </select>
                                <input name="movie_showings[<?=$i?>][hour]" class="clock-digits" value="<?= $editing && isset($showing[$i]) ? date('H', $showing[$i]['showing_datetime']) : set_value('movie_showings[$i][hour]') ?>" />
                                <span>:</span>
                                <input name="movie_showings[<?=$i?>][minutes]" class="clock-digits" value="<?= $editing && isset($showing[$i]) ? date('i', $showing[$i]['showing_datetime']) : set_value('movie_showings[$i][minutes]') ?>" />
                                <?php if($datefound === FALSE && isset($showing[$i])) { ?><p><strong><small>LET OP: datum buiten bereik begin/einddatum filmfestival!</small></strong></p><?php } ?>
                            </td>
                        </tr>
                        <?php endfor; ?>
                        <tr>
                            <td colspan="2" id="savechanges"><button class="btn btn-danger" type="submit" name="submit">Film opslaan</button>
                        </tr>
                    </tbody>
                </table>
            </form>

        <?php
            endif;
        ?>
        </div>
      </div>
    </div>

<?php $this->load->view('footer'); ?>
