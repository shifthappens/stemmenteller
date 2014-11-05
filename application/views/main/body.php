<!-- <div style="width: 1366px; height: 768px; border: 2px solid red; position: absolute; top: 0; left: 0;"></div> -->
<div class="container">
    <div id="publieksprijs">
        <h1 id="h1-pp">Tussenstand Publieksprijs</h1>
        <ol>
        <?php foreach($top as $movie): ?>
            <li><?php echo $movie['grade'] == 'Onbekend' ? 'Nog niet bekend' : $movie['movie_name'].' <strong>('.number_format($movie['grade'], 1).')</strong>'?>
                <?= $movie['totalvotes'] < $this->config->item('voting_minimum') && $movie['grade'] != "Onbekend" ? '*' : '' ?></li>
        <?php endforeach; ?>
        </ol>
        <h3>* = Nog niet genoeg stemmen om te winnen</h3>
    </div>
    <br /><br />
    <div id="barometer">
        <h1 id="h1-bm">Barometer</h1>
        <ol>
        <?php foreach($barometer as $movie): ?>
            <li><?php echo $movie['grade'] == 'Onbekend' ? 'Nog niet bekend' : $movie['movie_name'].' ('.number_format($movie['grade'], 1).')'?></li>
        <?php endforeach; ?>
        </ol>
    </div>
</div>