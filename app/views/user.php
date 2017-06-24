<?php require 'templates/header.php' ?>

<h1>Welcome user</h1>
<?php foreach($users as $user) : ?>
    <p><?= $user->first_name ?></p>
<?php endforeach ?>

<?php require 'templates/footer.php' ?>