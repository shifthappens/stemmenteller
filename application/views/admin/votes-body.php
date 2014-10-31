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
                    <th class="sortr-sortable">Tijdstip van invoer</th>
                    <th class="sortr-nonsortable">Stemronde</th>
                    <th class="sortr-nonsortable">Acties</th>
                <tbody>
                    <tr>
                        <td class="movie-name">82 dagen in April</td>
                        <td class="vote-timestamp" data-sortr-sortby="10000">do 6 nov, 13:37</td>
                        <td class="vote-round">2</td>
                        <td class="actions"><a href="admin/votes/edit" class="btn btn-danger btn-xs">Bewerken</a><a class="btn btn-danger btn-xs" href="admin/votes/delete">Verwijderen</a></td>
                    </tr>
                    <tr>
                        <td class="setting-name">Nordic horror night</td>
                        <td class="vote-timestamp">woe 6 nov, 10:37</td>
                        <td class="vote-round">1</td>
                        <td class="actions"><a href="admin/votes/edit" class="btn btn-danger btn-xs">Bewerken</a><a class="btn btn-danger btn-xs" href="admin/votes/delete">Verwijderen</a></td>
                    </tr>
                    <tr>
                        <td class="setting-name">Antboy</td>
                        <td class="vote-timestamp">woe 6 nov, 09:37</td>
                        <td class="vote-round">1</td>
                        <td class="actions"><a href="admin/votes/edit" class="btn btn-danger btn-xs">Bewerken</a><a class="btn btn-danger btn-xs" href="admin/votes/delete">Verwijderen</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
