<?php $this->load->view('admin/loginbar'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


          <h1 class="page-header">Films beheren <small><?=$movies->num_rows()?> films in totaal</small></h1>
          <a class="btn btn-danger btn-default" href="admin/movies/add"><span class="glyphicon glyphicon-plus"></span> Nieuwe Film toevoegen</a>
            <table id="movies" class="table table-striped sortr">
                <thead>
                    <th class="sortr-sortable">Film titel</th>
<!--                     <th class="sortr-sortable">Cijfer</th>
 -->                    <th class="sortr-nonsortable">Acties</th>
                <tbody>
<?php
foreach($movies->result() as $movie): ?>
                    <tr>
                        <td class="movie-name"><?=$movie->movie_name?></td>
<!--                         <td class="movie-grade">6,8</td> -->
                        <td class="actions"><a href="admin/movies/edit/<?=$movie->movie_id?>" class="btn btn-danger btn-xs">Bewerken</a>
                            <a class="btn btn-danger btn-xs" href="admin/movies/delete/<?=$movie->movie_id?>">Verwijderen</a></td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>