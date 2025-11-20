<?php

namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Models\Articles\Article;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Users\User;

class ArticlesController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    private function getCurrentUser(): ?User
    {
        return User::getById(1);
    }

    public function view(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
            'isAdmin' => ($this->getCurrentUser() !== null) && $this->getCurrentUser()->isAdmin(),
        ]);
    }

    public function add(): void
    {
        $currentUser = $this->getCurrentUser();

        if ($currentUser === null || !$currentUser->isAdmin()) {
            $this->view->renderHtml('errors/403.php', [], 403);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $text = trim($_POST['text'] ?? '');

            $errors = [];
            if ($name === '') {
                $errors[] = 'Введите название статьи';
            }
            if ($text === '') {
                $errors[] = 'Введите текст статьи';
            }

            if (!empty($errors)) {
                $this->view->renderHtml('articles/edit.php', [
                    'article' => null,
                    'errors' => $errors,
                ]);
                return;
            }

            $article = new Article();
            $article->setName($name);
            $article->setText($text);
            $article->setAuthorId($currentUser->getId());
            $article->save();

            header('Location: /myproject/articles/' . $article->getId());
            exit();
        }

        $this->view->renderHtml('articles/edit.php', [
            'article' => null,
            'errors' => [],
        ]);
    }

    public function edit(int $articleId): void
    {
        /** @var Article $article */
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $currentUser = $this->getCurrentUser();
        if ($currentUser === null || !$currentUser->isAdmin()) {
            $this->view->renderHtml('errors/403.php', [], 403);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $article->setName($_POST['name']);
            $article->setText($_POST['text']);
            $article->save();

            // Перенаправляем на страницу просмотра статьи после сохранения
            header('Location: /myproject/articles/' . $articleId);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', [
            'article' => $article
        ]);
    }

    public function delete(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $currentUser = $this->getCurrentUser();
        if ($currentUser === null || !$currentUser->isAdmin()) {
            $this->view->renderHtml('errors/403.php', [], 403);
            return;
        }

        // Удаляем комментарии статьи (если нет ON DELETE CASCADE)
        Comment::deleteByArticleId($articleId);

        // Удаляем саму статью
        $article->delete();

        header('Location: /myproject/');
        exit();
    }
}



