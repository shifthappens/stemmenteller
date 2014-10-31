<?php $this->load->view('admin/loginbar'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Instellingen aanpassen</h1>
            <form action="settings" method="post">
                <table id="settings" class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="setting-name">Festival Titel</td>
                            <td class="setting-value"><input type="text" name="festival_name" value="NFF35" /></td>
                        </tr>
                        <tr>
                            <td class="setting-name">Stemmen</td>
                            <td class="setting-value">
                                <span class="radio-choice"><input type="radio" checked name="voting_status" value="1" /> Aan</span>
                                <span class="radio-choice"><input type="radio" name="voting_status" value="0" /> Uit</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="setting-name">Stemmen automatisch uit op</td>
                            <td class="setting-value">
                                <input type="date" name="voting_ends_date" />
                                <input type="text" name="voting_ends_time" placeholder="UU:MM" />
                            </td>
                        </tr>
                        <tr>
                            <td class="setting-name">Tussenstand weergave</td>
                            <td class="setting-value">
                                <span class="radio-choice"><input type="radio" checked name="show_ranking_status" value="1" /> Aan</span>
                                <span class="radio-choice"><input type="radio" name="show_ranking_status" value="0" /> Uit</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="setting-name">Minimum aantal stemmen</td>
                            <td class="setting-value">
                                <input type="text" name="voting_minimum" value="100" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" id="savechanges"><button class="btn btn-danger" type="submit">Wijzigingen opslaan</button>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
      </div>
    </div>
