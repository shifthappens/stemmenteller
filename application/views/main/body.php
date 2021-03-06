<!-- <div style="width: 1366px; height: 768px; border: 2px solid red; position: absolute; top: 0; left: 0;"></div>
 -->
 <div class="container">
    <?php
    if(trim($this->config->item('custom_text')) != ''):
            echo strip_tags($this->config->item('custom_text'), '<h1><h2><h3><h4><h5><h6><p><a><strong><em><i><br><hr>');
    else:
    	if(isset($top)): ?>
    <div id="publieksprijs">
        <h1 id="h1-pp">Tussenstand Publieksprijs</h1>
        <ol class="<?=$this->config->item('show_ranking_status')?>">
        <?php foreach($top as $key => $movie): ?>
            <li><?=$key+1?>. 
                <?php echo $movie['grade'] == 'Onbekend' ? 'Nog niet bekend' : $movie['movie_name'].' <strong>('.number_format($movie['grade'], 1).')</strong>'?>
                <?= $movie['totalvotes'] <= $this->config->item('voting_minimum') && $movie['grade'] != "Onbekend" ? '*' : '' ?></li>
        <?php endforeach; ?>
        </ol>
         <h3>* = Nog niet genoeg stemmen om te winnen</h3>
     </div>
     <?php
	    endif;
	    if(isset($barometer)):
	 ?>
    <div id="barometer">
        <h1 id="h1-bm">Barometer</h1>
        <ol>
        <?php foreach($barometer as $key => $movie): ?>
            <li><?=$key+1?>. 
                <?php echo $movie['grade'] == 'Onbekend' ? 'Nog niet bekend' : $movie['movie_name'].' ('.number_format($movie['grade'], 1).')'?></li>
        <?php endforeach; ?>
        </ol>
    </div>
    <?php 
	    endif;
	endif; 
	?>
</div>