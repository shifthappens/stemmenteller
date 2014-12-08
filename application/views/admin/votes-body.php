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
                    <th class="sortr-sortable">Vertoonmoment</th>
                    <th class="sortr-sortable">Invoertijd</th>
                    <th class="sortr-nonsortable">5</th>
                    <th class="sortr-nonsortable">4</th>
                    <th class="sortr-nonsortable">3</th>
                    <th class="sortr-nonsortable">2</th>
                    <th class="sortr-nonsortable">1</th>
                    <th class="sortr-nonsortable">Totaal</th>
                    <th class="sortr-sortable">Bezoekers</th>
                    <th class="sortr-sortable">Vrijw.</th>
                    <th class="sortr-nonsortable">Acties</th>
                <tbody>
                    <?php foreach($votings->result() as $voting): $voting->grades = unserialize($voting->grades); ?>
                    <tr>
                        <td class="movie-name"><?=$voting->movie_name?></td>
                        <td class="showing-datetime" data-sortr-sortby="<?=$voting->showing_datetime?>"><?=strftime('%a %e %b %H:%M', $voting->showing_datetime)?></td>
                        <td class="vote-timestamp" data-sortr-sortby="<?=$voting->voting_datetime?>"><?=strftime('%a %e %b %H:%M', $voting->voting_datetime)?></td>
                        <td class="vote-num-votes"><?=$voting->grades[5]?></td>
                        <td class="vote-num-votes"><?=$voting->grades[4]?></td>
                        <td class="vote-num-votes"><?=$voting->grades[3]?></td>
                        <td class="vote-num-votes"><?=$voting->grades[2]?></td>
                        <td class="vote-num-votes"><?=$voting->grades[1]?></td>
                        <td class="vote-num-votes"><?=$voting->grades[1] + $voting->grades[2] + $voting->grades[3] + $voting->grades[4] + $voting->grades[5]?></td>
                        <td class="vote-num-visitors"><?=$voting->num_visitors?></td>
                        <td class="vote-num-volunteers"><?=$voting->num_volunteers?></td>
                        <td class="actions">
                            <a class="btn btn-danger btn-xs btn-delete" href="admin/votes/delete/<?=$voting->voting_id?>">Verwijderen</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
