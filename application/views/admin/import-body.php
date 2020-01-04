<?php $this->load->view('admin/loginbar'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


          <h1 class="page-header">Film data importeren</small></h1>

            <?php if(isset($errors)): ?>
            <div class="bg-warning nice-padding">
                <?php if(is_array($errors)):
                        foreach($error as $message): ?>
                    <p><?=$message?></p>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <p><?=$errors?></p>
                    <?php endif; ?>
            </div>
            <?php endif; ?>

          <?php if(isset($imported_movies)): ?>
          <h4>Totaal aantal films geïmporteerd: <?=count($imported_movies)?></h4>
            <?php foreach($imported_movies as $imported_movie): ?>
            <div class="bg-success nice-padding">
                Film '<?=$imported_movie['movie_name']?>' geïmporteerd 
                met <strong><?= isset($imported_movie['movie_showings']) ? count($imported_movie['movie_showings']) : "0"; ?></strong> vertoonmomenten
            </div>
            <?php endforeach; ?>

        <?php elseif($this->input->post('upload_submit') && !isset($errors["upload_error"])): ?>
                <div class="bg-warning nice-padding">
                    <p>Selecteer de kolommen die corresponderen met de data die de import tool snapt.
                        Klik op een drop-down menu om een kolom aan te merken als de juiste data voor
                         dat stukje informatie.</p>
                    <p>Staat je kolom er niet bij? Dan is het CSV bestand misschien niet goed geformatteerd
                        en heeft de tool de kolom niet herkend. Controleer je Excel bronbestand en exporteer opnieuw
                        naar CSV en probeer het opnieuw.</p>
                    <p>Hieronder zie je de eerste 5 rijen in het CSV bestand zodat je kan controleren of het goed herkend is.
                        Uiteraard gaan straks alle herkende rijen geïmporteerd worden.</p>
                </div>
                <form action="admin/verify_import" method="post">
                
                    <table id="csvverify-table" class="table table-striped">
                            <?php foreach($csv_headers as $key => $header):?>
                            <th>
                            <select name="csvverify-header[<?=$key?>]">
                                <option value="NULL"<?=$this->input->post('csvverify-select-'.strtolower($header)) && $this->input->post('csvverify-select-'.strtolower($header)) == 'NULL' ? ' selected="selected"' : '' ?>>--Deze kolom negeren--</option>
                                <?php foreach($accepted_headers as $accepted_header_name => $accepted_header_label): ?>
                                <option value="<?=$accepted_header_name?>" <?=$this->input->post('csvverify-select-'.strtolower($header)) && $this->input->post('csvverify-select-'.strtolower($header)) == $accepted_header_name ? ' selected="selected"' : '' ?>><?=$accepted_header_label?></option>
                                <?php endforeach; ?> 
                            </select><br />
                            <?=$header?>
                            </th>
                            <?php endforeach; ?>
                            <?php foreach($sample_data as $row): ?>
                            <tr>
                                <?php foreach($row as $value): ?>
                                <td><?=$value?></td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                            <?php if($num_rows > count($sample_data)): ?>
                            <tr>
                                <td colspan="<?=count($sample_data[0])?>">...en nog <strong><?=$num_rows-count($sample_data)?></strong> meer...</td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <td colspan="2" id="savechanges"><button class="btn btn-danger" type="submit" name="verify-submit" value="1">Bevestig keuzes</button>
                            </tr>

                        </table>
                    </div>

                    <div class="center"></div>    
                </form>
          <?php else: ?>
          <div class="bg-warning nice-padding">
            <p>Met deze simpele tool kan je film informatie gemakkelijk vanuit Excel in de database zetten.
                De tool kan heel krachtig zijn, als je de volgende regels aanhoudt:</p>
                <ul>
                    <li>Exporteer de vertoningslijst als CSV (comma separated values) bestand</li>
                    <li>Zorg ervoor dat er minimaal kolommen zijn voor "Film titel", "Datum Vertoonmoment 1", "Tijd vertoonmoment 1", "Publieksprijs ja/nee"</li>
                    <li>Voor de publieksprijs en wel/niet importeren kolommen geldt: ja of 'x' betekent positief, al het andere negatief.</li>
                    <li>Zorg ervoor dat datum en tijd aparte kolommen zijn, voor alle vertoonmomenten</li>
                    <li>Je kan films aanmerken als "niet importeren graag". Als er in die kolom iets staat dan wordt de film bij import overgeslagen. Wordt die kolom niet gedefinieerd in de volgende stap of is de inhoud leeg dan wordt de film gewoon geïmporteerd.</li>
                    <li>Zorg ervoor dat de datum als dd-mm-jjjj wordt aangeleverd en de tijd als uu:mm</li>
                    <li>Er kunnen <strong>maximaal 5</strong> vertoonmomenten aangemaakt worden per film</li>
                </ul>
            <p>Mocht de import niet goed verlopen zijn, dan kun je via <a href="admin/settings">Instellingen</a> weer de database leeggooien en het opnieuw proberen.</p>
          </div>
          <?= form_open_multipart('admin/import') ?>
            <table id="import" class="table table-striped">
                <tbody>
                    <tr>
                        <td>Selecteer CSV bestand</td>
                        <td><input type="file" name="import" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" id="savechanges"><button class="btn btn-danger" type="submit" name="upload_submit" value="submit">Importeren</button>
                    </tr>
                </tbody>
            </table>
        </form>
        <?php endif; ?>
        </div>
      </div>
    </div>