<?php $this->load->view('admin/loginbar'); ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php $this->load->view('admin/sidenav'); ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


          <h1 class="page-header">Film data importeren</small></h1>
        <?php if($this->input->post('upload_submit')): ?>
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
                
                <form action="admin/import/verify" method="post">
                
                    <table id="csvverify-table" class="table table-striped">
                            <?php foreach($csv_headers as $header):?>
                            <th>
                            <select name="csvverify-select-<?=strtolower($header)?>">
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
                            <tr>
                                <?php for($i = 0; $i < count($sample_data[0]); $i++): ?>
                                <td>...</td>
                                <?php endfor; ?>
                            </tr>
                        </table>
                    </div>

                    <div class="center"><button type="submit" name="submit" value="1">Confirm</button></div>                    
                    
                </form>
          <?php else: ?>
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