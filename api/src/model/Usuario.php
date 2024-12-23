<?php

class Usuario
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function getAll()
    {
        $usuarios = $this->pdo->query("SELECT * FROM usuario");
        return $usuarios->fetchAll();
    }


    public function getById($id)
    {
        $query = $this->pdo->prepare("SELECT * FROM usuario WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch();
    }

    // Obtener usuarios por permiso (0 = admin, 1 = profesor, 2 = voluntario, 3 = médico)
    public function getByPermission($permission)
    {
        $query = $this->pdo->prepare("SELECT * FROM usuario WHERE permission = :permission");
        $query->execute(['permission' => $permission]);
        return $query->fetchAll();
    }


    public function create($username, $hashpassword, $permission)
    {
        $query = $this->pdo->prepare("
            INSERT INTO usuario (username, hash_password, permission)
            VALUES (:username, :hashpassword, :permission)
        ");
        $query->execute([
            'username' => $username,
            'hashpassword' => $hashpassword,
            'permission' => $permission
        ]);
        return $query;
    }


    public function update($id, $username, $hashpassword, $permission)
    {
        $query = $this->pdo->prepare("
            UPDATE usuario
            SET username = :username, hash_password = :hashpassword, permission = :permission
            WHERE id = :id
        ");
        $query->execute([
            'id' => $id,
            'username' => $username,
            'hashpassword' => $hashpassword,
            'permission' => $permission
        ]);
        return $query;
    }


    public function delete($id)
    {
        $query = $this->pdo->prepare("DELETE FROM usuario WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query;
    }
}
