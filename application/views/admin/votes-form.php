<?php

$this->load->view('header');
$this->load->view('admin/loginbar');
?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <a href="javascript:history.back(-1);" class="btn btn-danger btn-sm">&laquo; Terug</a>
          <br /><br />
          <h1 class="page-header">
            <?php if($this->uri->segment(3) == "add"): $editing = FALSE; ?>
            Nieuwe Stemuitslag toevoegen
            <?php else: $editing = TRUE; ?>
            Stemuitslag X van '82 days in April' aanpassen <br />
            <small>Stemuitslag werd geregistreerd op do 6 nov om 13:37 door Gebruiker 1</small>
            <?php endif; ?>
        </h1>

            <form action="settings" method="post">
                <table id="vote" class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="movie-name">
                            <select name="movie-name" class="movie-name">
                                <option value="NULL">Kies een Film</option>
                                <option value="NULL" disabled>---------------</option>
                                <option value="12">82 Days in April</option>
                                <option value="12">82 Days in April</option>
                                <option value="12">82 Days in April</option>
                                <option value="12">82 Days in April</option>
                                <option value="12">82 Days in April</option>
                                <option value="12">82 Days in April</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="vote-grade-values">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[5]" />
                                        <br />
                                        <label class="big-digits">5</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[5]" />
                                        <br />
                                        <label class="big-digits">4</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[5]" />
                                        <br />
                                        <label class="big-digits">3</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[5]" />
                                        <br />
                                        <label class="big-digits">2</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[5]" />
                                        <br />
                                        <label class="big-digits">1</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input name="vote_num_visitors" type="text" class="big-digits" /> <label>Bezoekers</label></td>
                        </tr>
                        <tr>
                            <td><input name="vote_num_visitors_volunteer" type="text" class="big-digits" /> <label>Vrijwilligers</label></td>
                        </tr>
                            <td id="savechanges"><button class="btn btn-danger" type="submit">Stemuitslag opslaan</button>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
      </div>
    </div>

<?php $this->load->view('footer'); ?>
