<?php $this->load->view('admin/loginbar'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


          <h1 class="page-header">Film data exporteren <small><?=$movies->num_rows()?> films in totaal</small></h1>

          <h2>Publieksprijs</h2>
            <table id="movies" class="table table-striped sortr">
                <thead>
                    <th class="sortr-sortable">Film titel</th>
                     <th class="sortr-sortable">Cijfer</th>
                     <th class="sortr-sortable totalvotes-th">Aantal stemmen</th>
                     <th class="sortr-nonsortable star-th" style="display: none;"></th>
                <tbody>
<?php
foreach($movies->result() as $movie): ?>
<?php $gradeinfo = $this->Votings_model->calculate_grade($movie->movie_id); ?>
<?php if($gradeinfo['totalvotes'] >= 100 && $movie->movie_can_win == "1"): ?>
                    <tr>
                        <td class="movie-name"><?=$movie->movie_name?></td>
                         <td class="movie-grade"><?=number_format((double)$gradeinfo['grade'], 2)?></td>
                         <td class="movie-totalvotes"><?=$gradeinfo['totalvotes']?></td>
                         <td class="movie-can-win" style="display: none;"><?=$gradeinfo['totalvotes'] < $this->config->item('voting_minimum') ? '*' : ''?></td>
                    </tr>
<?php endif; ?>
<?php endforeach; ?>
                </tbody>
            </table>
          <h2>Barometer</h2>
            <table id="movies" class="table table-striped sortr">
                <thead>
                    <th class="sortr-sortable">Film titel</th>
                     <th class="sortr-sortable">Cijfer</th>
                     <th class="sortr-sortable totalvotes-th">Aantal stemmen</th>
                <tbody>
<?php
foreach($movies->result() as $movie): ?>
<?php $gradeinfo = $this->Votings_model->calculate_grade($movie->movie_id); ?>
                    <tr>
                        <td class="movie-name"><?=$movie->movie_name?></td>
                         <td class="movie-grade"><?=number_format((double)$gradeinfo['grade'], 2)?></td>
                         <td class="movie-totalvotes"><?=$gradeinfo['totalvotes']?></td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>          
        </div>
      </div>
    </div>