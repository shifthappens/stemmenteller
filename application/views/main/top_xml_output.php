<xml version="1.0">
    <movies>
<?php foreach($top as $movie): ?>
        <movie>
            <name><?php echo $movie['grade'] == 'Onbekend' ? 'Nog niet bekend' : $movie['movie_name'] ?></name>
            <grade><?php echo $movie['grade'] == 'Onbekend' ? '-' : $movie['grade'] ?></grade>
        </movie>
<?php endforeach; ?>
    </movies>
</xml>