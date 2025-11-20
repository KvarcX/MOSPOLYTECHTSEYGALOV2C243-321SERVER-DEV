<?php

namespace MyProject\Controllers;

use MyProject\View\View;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;

class MainController
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

    public function main(): void
    {
        $articles = Article::findAll();

        $this->view->renderHtml('main/main.php', [
            'title' => 'Мой блог',
            'articles' => $articles ?? [],
            'isAdmin' => ($this->getCurrentUser() !== null) && $this->getCurrentUser()->isAdmin(),
        ]);
    }

    public function sayHello(string $name): void
    {
        $this->view->renderHtml('main/hello.php', [
            'title' => 'Страница приветствия',
            'name' => $name
        ]);
    }

    public function aboutMe(): void
    {
        $this->view->renderHtml('main/about.php', [
            'title' => 'Обо мне',
            'content' => 'Привет! Я веб-разработчик, который любит создавать интересные проекты.'
        ]);
    }

    public function sayBye(string $name): void
    {
        $this->view->renderHtml('main/bye.php', [
            'title' => 'Прощание',
            'name' => $name
        ]);
    }
}


