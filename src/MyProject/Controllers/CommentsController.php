<?php

namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Models\Comments\Comment;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;

class CommentsController
{
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    private function getCurrentUser(): ?User
    {
        // TODO: заменить на получение текущего авторизованного пользователя
        return User::getById(1);
    }

    public function add(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = new Comment();
            // TODO: здесь позже нужно будет подставлять ID текущего авторизованного пользователя
            $comment->setAuthorId(1); // Пока используем первого пользователя как автора комментария
            $comment->setArticleId($articleId);
            $comment->setText($_POST['text']);
            $comment->save();

            // Перенаправляем на страницу статьи с якорем к комментарию
            header('Location: /myproject/articles/' . $articleId . '#comment' . $comment->getId());
            exit();
        }

        // Если GET запрос, перенаправляем на страницу статьи
        header('Location: /myproject/articles/' . $articleId);
        exit();
    }

    public function edit(int $commentId): void
    {
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment->setText($_POST['text']);
            $comment->save();

            // Перенаправляем на страницу статьи с якорем к комментарию
            header('Location: /myproject/articles/' . $comment->getArticleId() . '#comment' . $commentId);
            exit();
        }

        $this->view->renderHtml('comments/edit.php', [
            'comment' => $comment
        ]);
    }

    public function delete(int $commentId): void
    {
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $currentUser = $this->getCurrentUser();
        if ($currentUser === null || !$currentUser->isAdmin()) {
            $this->view->renderHtml('errors/403.php', [], 403);
            return;
        }

        $articleId = $comment->getArticleId();

        $comment->delete();

        header('Location: /myproject/articles/' . $articleId);
        exit();
    }
}
