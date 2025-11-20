<?php include __DIR__ . '/../header.php'; ?>

    <h1><?= $article->getName() ?></h1>

    <?php if (!empty($isAdmin) && $isAdmin): ?>
        <p>
            <a href="/myproject/article/<?= $article->getId() ?>/edit">Редактировать статью</a> |
            <a href="/myproject/articles/<?= $article->getId() ?>/delete">Удалить статью</a>
        </p>
    <?php endif; ?>
    <p><strong>Автор:</strong> <?= $article->getAuthor()->getNickname() ?></p>
    <p><?= $article->getText() ?></p>

    <hr>

    <h2>Комментарии</h2>

    <?php foreach ($article->getComments() as $comment): ?>
        <div id="comment<?= $comment->getId() ?>" style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
            <p><strong><?= htmlspecialchars($comment->getAuthor()->getNickname()) ?></strong> (<?= $comment->getCreatedAt() ?>)</p>
            <p><?= htmlspecialchars($comment->getText()) ?></p>

            <?php if (!empty($isAdmin) && $isAdmin): ?>
                <p>
                    <a href="/myproject/comments/<?= $comment->getId() ?>/edit">Редактировать</a> |
                    <a href="/myproject/comments/<?= $comment->getId() ?>/delete">Удалить</a>
                </p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <hr>

    <h3>Добавить комментарий</h3>
    <form method="POST" action="/myproject/articles/<?= $article->getId() ?>/comments">
        <div>
            <label for="text">Текст комментария:</label><br>
            <textarea id="text" name="text" rows="5" cols="50" required></textarea>
        </div>
        <div>
            <button type="submit">Отправить комментарий</button>
        </div>
    </form>

<?php include __DIR__ . '/../footer.php'; ?>



