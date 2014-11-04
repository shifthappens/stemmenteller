<?php setlocale(LC_TIME, 'nl_NL'); ?>
<?php $this->load->view('admin/loginbar'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Stemmen beheren</h1>
          <a type="button" class="btn btn-danger btn-default" href="admin/votes/add"><span class="glyphicon glyphicon-plus"></span> Nieuwe Stemuitslag Toevoegen</a>
            <table id="votes" class="table table-striped sortr">
                <thead>
                    <th class="sortr-sortable">Film titel</th>
                    <th class="sortr-nonsortable">Vertoonmoment</th>
                    <th class="sortr-sortable">Tijdstip van invoer</th>
                    <th class="sortr-nonsortable">Acties</th>
                <tbody>
                    <?php foreach($votings->result() as $voting): ?>
                    <tr>
                        <td class="movie-name"><?=$voting->movie_name?></td>
                        <td class="movie-name"><?=strftime('%a %e %b %H:%M', $voting->showing_datetime)?></td>
                        <td class="vote-timestamp" data-sortr-sortby="<?=$voting->voting_datetime?>"><?=strftime('%a %e %b %H:%M', $voting->voting_datetime)?></td>
                        <td class="actions">
                            <a href="admin/votes/edit/<?=$voting->voting_id?>" class="btn btn-danger btn-xs">Bewerken</a>
                            <a class="btn btn-danger btn-xs" href="admin/votes/delete/<?=$voting->voting_id?>">Verwijderen</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
