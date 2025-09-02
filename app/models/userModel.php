<?php
require_once __DIR__ . '/../configs/database.php';

class UserModel
{
    private $db;
    private $table = "usuarios";

    public function __construct()
    {
        $this->db = getConnection();
    }


    // Funcao para criar conta de usuarios
    public function createUserAccountModel($name, $email, $password, $active = false)
    {
        try {
            $token_api = bin2hex(random_bytes(32));
            $token_verificacao = bin2hex(random_bytes(32));
            $token_expiracao = date('Y-m-d H:i:s', strtotime('+24 hours'));

            $stmt = $this->db->prepare("INSERT INTO usuarios (nome, email, senha, token_api, token_verificacao, token_expiracao, ativo, email_verificado)  
             VALUES (?,?,?,?,?,?,?,?)");

            return $stmt->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $token_api,
                $token_verificacao,
                $token_expiracao,
                $active,
                false
            ]) ? $token_verificacao : false;
        } catch (PDOException $e) {
            error_log("Erro ao criar conta: " . $e->getMessage());
            return false;
        }
    }

    // Funcao para verificar se o emai existe
    public function emailExistsModel($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    public function getUserById($id)
    {
        $query = "SELECT id, nome, email FROM " . $this->table . " WHERE id = :id AND ativo = TRUE";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Verificar token de verificacao
    public function verifiedTokenModel($token)
    {
        try {
            $stmt = $this->db->prepare("SELECT id FROM usuarios 
                                       WHERE token_verificacao = ? 
                                       AND token_expiracao > NOW() 
                                       AND email_verificado = FALSE");
            $stmt->execute([$token]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao verificar token: " . $e->getMessage());
            return false;
        }
    }

    // Ativar conta do usuario depois de verificar
    public function activeUsersModel($userId)
    {
        try {
            $stmt = $this->db->prepare("UPDATE usuarios 
                                       SET email_verificado = TRUE, 
                                           ativo = TRUE,
                                           token_verificacao = NULL,
                                           token_expiracao = NULL
                                       WHERE id = ?");
            return $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Erro ao ativar usuarios: " . $e->getMessage());
            return false;
        }
    }

    // Verificar se email foi confirmado
    public function isEmailVerifiedModel($email)
    {
        $stmt = $this->db->prepare("SELECT email_verificado FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (bool)$result['email_verificado'] : false;
    }
}
