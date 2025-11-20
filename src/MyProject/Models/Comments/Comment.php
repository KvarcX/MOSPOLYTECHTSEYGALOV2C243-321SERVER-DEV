<?php

namespace MyProject\Models\Comments;

use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Models\Articles\Article;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{
    protected $authorId;
    protected $articleId;
    protected $text;
    protected $createdAt;

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public function getArticle(): Article
    {
        return Article::getById($this->articleId);
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public static function deleteByArticleId(int $articleId): void
    {
        $db = Db::getInstance();
        $db->query(
            'DELETE FROM `' . static::getTableName() . '` WHERE article_id = :article_id',
            [':article_id' => $articleId]
        );
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}
