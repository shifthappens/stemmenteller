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
          <a href="admin/votes" class="btn btn-danger btn-sm">&laquo; Terug</a>
          <br /><br />
          <h1 class="page-header">
            <?php if($this->uri->segment(3) == "add"): $editing = FALSE; ?>
            Nieuwe Stemuitslag toevoegen
            <?php else: $editing = TRUE; ?>
            Stemuitslag X van '82 days in April' aanpassen <br />
            <small>Stemuitslag werd geregistreerd op do 6 nov om 13:37 door Gebruiker 1</small>
            <?php endif; ?>
        </h1>

        <?php if($this->session->userdata('message') !== NULL): ?>
        <div class="alert alert-<?=$this->session->userdata('message-type')?>"><?=$this->session->userdata('message')?></div>
        <?php endif; ?>

        <?php if($this->session->userdata('message-type') === "success"): ?>
        <a class="btn btn-danger" href="admin/votes/add">Voeg nog een Stemuitslag toe</a>
        <?php
            $this->session->unset_userdata('message-type');
            $this->session->unset_userdata('message');
            else:
                if(count($this->form_validation->error_array()) != 0):
        ?>
        <div class="alert alert-danger form-errors">
        <?php
            echo validation_errors('<li>', '</li>');
        ?>
        </div>
        <?php
                endif;
        ?>

            <form action="admin/votes/add" method="post">
                <table id="vote" class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="movie-name">
                            <select name="movie_id" class="movie-name" id="movie-name-for-showings">
                                <option value="">Kies een Film</option>
                                <option value="" disabled>---------------</option>
                                <?php foreach($movies->result() as $movie): ?>
                                <option value="<?=$movie->movie_id?>" <?=set_select('movie_id', $movie->movie_id)?>><?=$movie->movie_name?></option>
                                <?php endforeach; ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="showing-id">
                            <select name="showing_id" class="showing-id" id="showing-ids" disabled>
                                <option value="">Wacht op filmkeuze...</option>
                                <option value="">Kies een Vertoonmoment</option>
                                <option value="" disabled>---------------</option>
                            </select>
                            <input type="hidden" id="showing-id-saved" value="<?=$this->input->post('showing_id')?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="vote-grade-values">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[5]" value="<?=set_value('vote_grade_value[5]', '')?>" placeholder="0" />
                                        <br />
                                        <label class="big-digits">5</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[4]" value="<?=set_value('vote_grade_value[4]', '')?>" placeholder="0" />
                                        <br />
                                        <label class="big-digits">4</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[3]" value="<?=set_value('vote_grade_value[3]', '')?>" placeholder="0" />
                                        <br />
                                        <label class="big-digits">3</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[2]" value="<?=set_value('vote_grade_value[2]', '')?>" placeholder="0" />
                                        <br />
                                        <label class="big-digits">2</label>
                                    </div>
                                    <div class="form-group">
                                        <input class="big-digits" type="text" name="vote_grade_value[1]" value="<?=set_value('vote_grade_value[1]', '')?>" placeholder="0" />
                                        <br />
                                        <label class="big-digits">1</label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><input name="num_visitors" type="text" class="big-digits" value="<?=set_value('num_visitors', '')?>" placeholder="0" /> <label>Bezoekers</label></td>
                        </tr>
                        <tr>
                            <td><input name="num_volunteers" type="text" class="big-digits" value="<?=set_value('num_volunteers', '')?>" placeholder="0" /> <label>Vrijwilligers</label></td>
                        </tr>
                            <td id="savechanges"><button class="btn btn-danger" type="submit" name="submit">Stemuitslag opslaan</button>
                        </tr>
                    </tbody>
                </table>
            </form>
<?php endif; ?>
        </div>
      </div>
    </div>

<?php $this->load->view('footer'); ?>
