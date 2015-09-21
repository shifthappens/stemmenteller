<div id="loginbox">
    <h2>Log in om door te gaan</h2>
    <form action="admin/login" method="post">
        <input type="text" name="username" placeholder="Gebruikersnaam..." />
        <input type="password" name="password" placeholder="Wachtwoord..." />
        <button id="btn-login" class="btn btn-danger" type="submit">Inloggen</button>
    </form>
    <br />
    <?php if(isset($message)): ?>
    <div class="alert alert-<?=$message['type']?>" role="alert"><?=$message['text']?></div>
    <?php endif; ?>
</div>