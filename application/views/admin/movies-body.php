<?php $this->load->view('admin/loginbar'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Films beheren <small>3 films in totaal</small></h1>
          <a class="btn btn-danger btn-default" href="movies/add"><span class="glyphicon glyphicon-plus"></span> Nieuwe Film toevoegen</a>
            <table id="movies" class="table table-striped sortr">
                <thead>
                    <th class="sortr-sortable">Film titel</th>
                    <th class="sortr-sortable">Cijfer</th>
                    <th class="sortr-nonsortable">Acties</th>
                <tbody>
                    <tr>
                        <td class="movie-name">82 dagen in April</td>
                        <td class="movie-grade">6,8</td>
                        <td class="actions"><a href="" class="btn btn-danger btn-xs">Bewerken</a><a class="btn btn-danger btn-xs" href="">Verwijderen</a></td>
                    </tr>
                    <tr>
                        <td class="setting-name">Nordic horror night</td>
                        <td class="movie-grade movie-grade-unknown">Onbekend</td>                        
                        <td class="actions"><a href="" class="btn btn-danger btn-xs">Bewerken</a><a class="btn btn-danger btn-xs" href="">Verwijderen</a></td>
                    </tr>
                    <tr>
                        <td class="setting-name">Antboy</td>
                        <td class="movie-grade movie-grade-unknown">8,2</td>                        
                        <td class="actions"><a href="" class="btn btn-danger btn-xs">Bewerken</a><a class="btn btn-danger btn-xs" href="">Verwijderen</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
