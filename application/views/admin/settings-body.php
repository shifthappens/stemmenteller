<?php $this->load->view('admin/loginbar'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Instellingen aanpassen</h1>
            <form action="admin/settings" method="post">
                <table id="settings" class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="setting-name">Festival Titel</td>
                            <td class="setting-value"><input type="text" name="settings[festival_name]" value="<?=$this->config->item('festival_name')?>" /></td>
                        </tr>
                        <tr>
                            <td class="setting-name">Tussenstand weergave</td>
                            <td class="setting-value">
                                <span class="radio-choice"><input type="radio" <?=$this->config->item('show_ranking_status') == 'top5' ? 'checked' : '' ?> name="settings[show_ranking_status]" value="top5" /> Top 5</span>
                                <span class="radio-choice"><input type="radio" <?=$this->config->item('show_ranking_status') == 'from4' ? 'checked' : '' ?> name="settings[show_ranking_status]" value="from4" /> Vanaf plek 4</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="setting-name">Minimum aantal stemmen</td>
                            <td class="setting-value">
                                <input type="text" name="settings[voting_minimum]" value="<?=$this->config->item('voting_minimum')?>" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" id="savechanges"><button class="btn btn-danger" type="submit" name="submit" value="submit">Wijzigingen opslaan</button>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
      </div>
    </div>
