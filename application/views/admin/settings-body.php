<?php $this->load->view('admin/loginbar'); ?>
<?php $repop = isset($upload_errors) || FALSE; ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <?php if($this->session->flashdata('message')): ?>
            <div class="bg-<?=$this->session->flashdata('message-type')?> nice-padding"><strong><?=$this->session->flashdata('message')?></strong></div>
            <?php endif; ?>

            <?php if(isset($upload_errors) && $upload_errors !== FALSE): ?>
            <div class="bg-warning nice-padding"><strong><?=$upload_errors?></strong></div>
            <?php endif; ?>

            <?php if(isset($message) && $message !== FALSE): ?>
            <div class="bg-success nice-padding"><strong><?=$message?></strong></div>
            <?php endif; ?>

          <h1 class="page-header">Instellingen aanpassen</h1>
            <?php echo form_open_multipart("admin/settings") ?>
                <table id="settings" class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="setting-name">Festival Titel</td>
                            <td class="setting-value"><input type="text" name="settings[festival_name]"
                                value="<?= $repop ? $this->input->post('settings[festival_name]') : $this->config->item('festival_name'); ?>" /></td>
                        </tr>
                        <tr>
                            <td class="setting-name">Festival Begin en Einddata</td>
                            <td class="setting-value">
	                            Startdatum: <input type="date" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" name="settings[festival_date_start]"
                                value="<?= $repop ? $this->input->post('settings[festival_date_start]') : $this->config->item('festival_date_start'); ?>" />
                                <br />
	                            Einddatum: <input type="date" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" name="settings[festival_date_end]"
                                value="<?= $repop ? $this->input->post('settings[festival_date_end]') : $this->config->item('festival_date_end'); ?>" /></td>
                        </tr>
                        <tr>
                            <td class="setting-name">Tussenstand weergave</td>
                            <td class="setting-value">
                                <span class="radio-choice">
                                    <input 
                                    type="radio" 
                                    <?php if($this->input->post('settings[show_ranking_status]') == 'top5') echo 'checked'; elseif(!$repop && $this->config->item('show_ranking_status') == 'top5') echo 'checked'; else echo ''; ?>
                                    name="settings[show_ranking_status]" 
                                    value="top5" /> Top 5</span>
                                <span class="radio-choice">
                                    <input 
                                    type="radio" 
                                    <?php if($this->input->post('settings[show_ranking_status]') == 'top10') echo 'checked'; elseif(!$repop && $this->config->item('show_ranking_status') == 'top10') echo 'checked'; else echo ''; ?>
                                    name="settings[show_ranking_status]" 
                                    value="top10" /> Top 10</span>
                                <span class="radio-choice">
                                    <input type="radio" 
                                    <?php if($this->input->post('settings[show_ranking_status]') == 'from4') echo 'checked'; elseif(!$repop && $this->config->item('show_ranking_status') == 'from4') echo 'checked'; else echo ''; ?>
                                    name="settings[show_ranking_status]" 
                                    value="from4" /> Vanaf plek 4</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="setting-name">Tussenstand weergave automatisch naar "Vanaf plek 4"</td>
                            <td class="setting-value">
                                <input type="text" size="2"
                                value="<?= $repop ? $this->input->post('settings[show_ranking_auto_limit_day]') : $this->config->item('show_ranking_auto_limit_day'); ?>" name="settings[show_ranking_auto_limit_day]" />
                                <input type="text" size="2" 
                                value="<?= $repop ? $this->input->post('settings[show_ranking_auto_limit_month]') : $this->config->item('show_ranking_auto_limit_month')?>" name="settings[show_ranking_auto_limit_month]" />
                                <input type="text" size="4" 
                                value="<?= $repop ? $this->input->post('settings[show_ranking_auto_limit_year]') : $this->config->item('show_ranking_auto_limit_year')?>" name="settings[show_ranking_auto_limit_year]" />
                                <input type="text" size="2" 
                                value="<?= $repop ? $this->input->post('settings[show_ranking_auto_limit_hour]') : $this->config->item('show_ranking_auto_limit_hour')?>" name="settings[show_ranking_auto_limit_hour]" /> :
                                <input type="text" size="2" 
                                value="<?= $repop ? $this->input->post('settings[show_ranking_auto_limit_minutes]') : $this->config->item('show_ranking_auto_limit_minutes')?>" name="settings[show_ranking_auto_limit_minutes]" />
                           </td>
                        </tr>
                        <tr>
                            <td class="setting-name">Minimum aantal stemmen</td>
                            <td class="setting-value">
                                <input type="text" name="settings[voting_minimum]" value="<?= $repop ? $this->input->post('settings[voting_minimum]') : $this->config->item('voting_minimum')?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="setting-name">Achtergrondafbeelding<br />
                                <small>Wijzig hier de achtergrondafbeelding die je kan zien op de voorpagina. <br /> De afbeelding zal worden opgerekt om het scherm volledig te vullen.</small></td>
                            <td class="setting-value">
                                <input type="file" name="background_image" value="" />
                                (<a href="<?=site_url().'uploads/'.$this->config->item('background_image_url')?>" target="_blank">Huidige achtergrondafbeelding</a>)
                            </td>
                        </tr>
                        <tr>
                            <td class="setting-name">Aangepaste tekst op voorpagina<br />
                                <small>Tekst die i.p.v. de ranglijsten wordt getoond, indien ingevuld. Laat leeg om te negeren. <br/>
                                    HTML opmaak beperkt toegestaan.</small>
                            </td>
                            <td class="setting-value">
                                <textarea name="settings[custom_text]" id="custom-text" cols="50" rows="10"><?= $repop ? $this->input->post('settings[custom_text]') : $this->config->item('custom_text')?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" id="savechanges"><button class="btn btn-danger" type="submit" name="submit" value="submit">Wijzigingen opslaan</button>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Alles verwijderen</h1>
          <div class="bg-warning purge-warning-message"><p><strong>Let op!</strong><br />Hiermee verwijder je alle films, vertoonmomenten en stemuitslagen uit de database. Dit kan niet meer ongedaan worden gemaakt!</p></div>
            <form action="admin/purge" method="post">
                <table id="settings" class="table table-striped">
                    <tbody>
                        <tr>
                            <td colspan="2" id="savechanges" align="center"><button class="btn btn-danger btn-lg btn-purge" type="submit" name="submit" value="submit">Alle films en stemuitslagen verwijderen</button>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
      </div>
    </div>
