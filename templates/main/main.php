<?php include __DIR__ . '/../header.php'; ?>

<?php if (!empty($isAdmin) && $isAdmin): ?>
    <p><a href="/myproject/articles/add">Создать статью</a></p>
<?php endif; ?>

<?php foreach ($articles as $article): ?>
    <h2><a href="/myproject/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h2>
    <p><?= $article->getText() ?></p>

    <?php if (!empty($isAdmin) && $isAdmin): ?>
        <p>
            <a href="/myproject/article/<?= $article->getId() ?>/edit">Редактировать</a> |
            <a href="/myproject/articles/<?= $article->getId() ?>/delete">Удалить</a>
        </p>
    <?php endif; ?>

    <hr>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>


