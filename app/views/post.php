<?php require 'templates/header.php' ?>

<h1>Posts:</h1>
<?php foreach($posts as $post) : ?>
    <p><?= $post->title ?></p>
<?php endforeach ?>

<?php require 'templates/footer.php' ?>