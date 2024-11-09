<?php

declare(strict_types=1);

namespace Core\Libraries;

use Dibi\Connection;

class DatabaseManager
{

    private Connection $db;

    public function __construct()
    {
        $config = config('database');
        $this->db = new Connection([
            'driver' => $config['driver'],
            'database' => $config['name'],
            'host' => $config['host'],
            'username' => $config['username'],
            'password' => $config['password'],
            'port' => $config['port'],
        ]);
        $this->initializeTables();
    }


    private function initializeTables(): void
    {
        // Users table
        /*$this->db->query('
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username VARCHAR(255) UNIQUE NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ');*/
    }

    // User Methods
    public function getUsers(int $limit = 10, int $offset = 0): array
    {
        return $this->db->query('
            SELECT * FROM users 
            LIMIT ? OFFSET ?
        ', $limit, $offset)->fetchAll();
    }

    public function getUserByUsername(string $username): ?array
    {
        return $this->db->query('
            SELECT * FROM users 
            WHERE username = ?
        ', $username)->fetch()?->toArray();
    }

    public function getUserById(int $id): ?array
    {
        return $this->db->query('
            SELECT * FROM users 
            WHERE id = ?
        ', $id)->fetch()?->toArray();
    }

    public function getUserByEmail(string $email): ?array
    {
        return $this->db->query('
            SELECT * FROM users 
            WHERE email = ?
        ', $email)->fetch()?->toArray();
    }

    public function createUser(array $data): int
    {
        $this->db->query(
            '
            INSERT INTO users',
            [
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => $data['role']
            ]
        );

        return $this->db->getInsertId();
    }

    public function updateUser(int $id, array $data): void
    {
        $this->db->query(
            '
            UPDATE users SET',
            [
                'username' => $data['username'],
                'email' => $data['email'],
                'role' => $data['role'],
                'updated_at' => new \DateTime()
            ],
            'WHERE id = ?',
            $id
        );
    }

    public function deleteUser(int $id): void
    {
        $this->db->query('DELETE FROM users WHERE id = ?', $id);
    }
}
