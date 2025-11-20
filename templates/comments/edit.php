<?php include __DIR__ . '/../header.php'; ?>

    <h1>Редактирование комментария</h1>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $comment->getId() ?>">

        <div>
            <label for="text">Текст комментария:</label><br>
            <textarea id="text" name="text" rows="5" cols="50" required><?= htmlspecialchars($comment->getText()) ?></textarea>
        </div>

        <div>
            <button type="submit">Сохранить изменения</button>
        </div>
    </form>

<?php include __DIR__ . '/../footer.php'; ?>
