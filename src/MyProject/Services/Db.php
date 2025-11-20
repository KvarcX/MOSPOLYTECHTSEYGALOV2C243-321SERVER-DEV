<?php

namespace MyProject\Services;

class Db
{
    private static $instance;
    private $pdo;

    private function __construct()
    {
        $dbOptions = (require __DIR__ . '/../../settings.php')['db'];

        $this->pdo = new \PDO(
            'mysql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']
        );

        $this->pdo->exec('SET NAMES UTF8');
    }

    // Метод для получения единственного экземпляра класса (паттерн Singleton)
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function query(string $sql, array $params = [], ?string $className = null): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        // Метод fetchAll() - это метод объекта PDOStatement, который получает все строки результата запроса и возвращает их в виде массива.
        // Здесь мы явно указываем режим FETCH_ASSOC, чтобы получить только ассоциативные ключи (без числовых индексов).
        $data = $sth->fetchAll(\PDO::FETCH_ASSOC);

        // Если имя класса не указано, возвращаем обычные ассоциативные массивы (обратная совместимость)
        if ($className === null) {
            return $data;
        }

        // Создаем массив для хранения объектов
        $objects = [];

        // Проходим по каждой строке данных из базы данных
        foreach ($data as $row) {
            // Создаем новый объект указанного класса (например, Article или User)
            $object = new $className();

            // Заполняем свойства объекта данными из строки базы данных
            foreach ($row as $column => $value) {
                $object->$column = $value;  // Присваиваем значение свойству объекта
            }

            // Добавляем созданный объект в массив объектов
            $objects[] = $object;
        }

        // Возвращаем массив созданных объектов вместо ассоциативных массивов
        return $objects;
    }

    /**
     * Возвращает ID последней вставленной записи
     */
    public function getLastInsertId(): int
    {
        return (int)$this->pdo->lastInsertId();
    }
}


