<?php

namespace MyProject\Models\Articles;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Models\Comments\Comment;
use MyProject\Services\Db;

class Article extends ActiveRecordEntity
{
    protected $name;
    protected $text;
    protected $authorId;
    protected $createdAt;

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    /**
     * @return Comment[]
     */
    public function getComments(): array
    {
        $db = Db::getInstance();
        return $db->query(
            'SELECT * FROM `' . Comment::getTableName() . '` WHERE article_id = :article_id ORDER BY created_at DESC',
            [':article_id' => $this->id],
            Comment::class
        );
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }
}
