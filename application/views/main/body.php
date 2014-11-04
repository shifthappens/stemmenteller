<h1>Stemmen tot nu toe</h1>
<ol>
<?php foreach($top as $movie): ?>
    <li><?php echo $movie['grade'] == 'Onbekend' ? 'Nog niet bekend' : $movie['movie_name'].' ('.round($movie['grade'], 1).')'?></li>
<?php endforeach; ?>
</ol>