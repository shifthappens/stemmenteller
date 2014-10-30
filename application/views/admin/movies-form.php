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
          <h1 class="page-header">
            <?php if($this->uri->segment(3) == "add"): $editing = FALSE; ?>
            Nieuwe Film toevoegen
            <?php else: $editing = TRUE; ?>
            Film '82 days in April' aanpassen
            <?php endif; ?>
        </h1>

            <form action="settings" method="post">
                <table id="settings" class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="setting-name">Film Titel</td>
                            <td class="setting-value"><input type="text" name="festival_name" placeholder="Voer een titel in..." value="<?php if($editing): ?>82 Days in April<?php endif; ?>" /></td>
                        </tr>
                        <tr>
                            <td class="setting-name">Dingt mee voor prijs?</td>
                            <td class="setting-value">
                                <span class="radio-choice"><input type="radio" checked name="movie_price_status" value="1" /> Ja</span>
                                <span class="radio-choice"><input type="radio" name="movie_price_status" value="0" /> Nee</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" id="savechanges"><button class="btn btn-danger" type="submit">Film opslaan</button>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
      </div>
    </div>

<?php $this->load->view('footer'); ?>
