<xml version="1.0">
<lists>
    <list id="publieksprijs">
        <movies>
        <?php foreach($top as $rank => $movie): ?>
                <movie rank="<?=$rank+1?>">
                    <name><?php echo $movie['grade'] == 'Onbekend' ? 'Nog niet bekend' : $movie['movie_name'] ?></name>
                    <grade><?php echo $movie['grade'] == 'Onbekend' ? '-' : number_format($movie['grade'], 1) ?></grade>
                </movie>
        <?php endforeach; ?>
        </movies>
    </list>
    <list id="barometer">
        <movies>
        <?php foreach($barometer as $rank => $movie): ?>
                <movie rank="<?=$rank+1?>">
                    <name><?php echo $movie['grade'] == 'Onbekend' ? 'Nog niet bekend' : $movie['movie_name'] ?></name>
                    <grade><?php echo $movie['grade'] == 'Onbekend' ? '-' : number_format($movie['grade'], 1) ?></grade>
                </movie>
        <?php endforeach; ?>
        </movies>
    </list>
</lists>

</xml>
