<?php include __DIR__ . '/../header.php'; ?>

    <h1><?= !empty($article) ? 'Редактирование статьи' : 'Создание статьи' ?></h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <?php if (!empty($article)): ?>
            <input type="hidden" name="id" value="<?= $article->getId() ?>">
        <?php endif; ?>

        <div>
            <label for="name">Название статьи:</label><br>
            <input
                type="text"
                id="name"
                name="name"
                value="<?= !empty($article) ? htmlspecialchars($article->getName()) : '' ?>"
                required
            >
        </div>

        <div>
            <label for="text">Текст статьи:</label><br>
            <textarea id="text" name="text" rows="10" cols="50" required><?= !empty($article) ? htmlspecialchars($article->getText()) : '' ?></textarea>
        </div>

        <div>
            <button type="submit"><?= !empty($article) ? 'Сохранить изменения' : 'Создать статью' ?></button>
        </div>
    </form>

<?php include __DIR__ . '/../footer.php'; ?>
