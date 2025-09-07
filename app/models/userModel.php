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
            $codigo_verificacao = $this->generateVerificationCode();
            $codigo_expiracao = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $stmt = $this->db->prepare("INSERT INTO usuarios 
                (nome, email, senha, token_api, codigo_verificacao, codigo_expiracao, ativo, email_verificado)  
                VALUES (?,?,?,?,?,?,?,?)");

            return $stmt->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $token_api,
                $codigo_verificacao,
                $codigo_expiracao,
                $active,
                false
            ]) ? $codigo_verificacao : false;
        } catch (PDOException $e) {
            error_log("Erro ao criar conta: " . $e->getMessage());
            return false;
        }
    }
   public function loadUserDataModel($id)
{
    $stmt = $this->db->prepare("SELECT nome, email FROM usuarios WHERE id = ? AND ativo = TRUE");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // funcao Gerar código de verificação  de 6 dígitos
    private function generateVerificationCode()
    {
        do {
            $code = sprintf('%06d', random_int(0, 999999));
            $exists = $this->verificationCodeExists($code);
        } while ($exists);

        return $code;
    }

    // Verificar se código  existe
    private function verificationCodeExists($code)
    {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE codigo_verificacao = ?");
        $stmt->execute([$code]);
        return $stmt->fetch() !== false;
    }

    // Funcao para verificar se o email existe
    public function emailExistsModel($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }
    // Funcao para obeter o usario pelo id
    public function getUserById($id)
    {
        $query = "SELECT id, nome, email FROM " . $this->table . " WHERE id = :id AND ativo = TRUE";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    // Funcao para obter o email do usuario
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT nome FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // funcao para Verificar código de verificaao
    public function verifyCodeModel($email, $code)
    {
        try {
            $stmt = $this->db->prepare("SELECT id FROM usuarios 
                                       WHERE email = ? 
                                       AND codigo_verificacao = ?
                                       AND codigo_expiracao > NOW() 
                                       AND email_verificado = FALSE");
            $stmt->execute([$email, $code]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao verificar código: " . $e->getMessage());
            return false;
        }
    }

    // funcao Ativar conta do usuario depois de verificar
    public function activeUsersModel($userId)
    {
        try {
            $stmt = $this->db->prepare("UPDATE usuarios 
                                       SET email_verificado = TRUE, 
                                           ativo = TRUE,
                                           codigo_verificacao = NULL,
                                           codigo_expiracao = NULL
                                       WHERE id = ?");
            return $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Erro ao ativar usuarios: " . $e->getMessage());
            return false;
        }
    }

    // funcao para Verificar se email foi confirmado
    public function isEmailVerifiedModel($email)
    {
        $stmt = $this->db->prepare("SELECT email_verificado FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (bool)$result['email_verificado'] : false;
    }

    //funcao  Reenviar código de verificação
    public function resendVerificationCodeModel($email)
    {
        try {
            $codigo_verificacao = $this->generateVerificationCode();
            $codigo_expiracao = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $stmt = $this->db->prepare("UPDATE usuarios 
                                       SET codigo_verificacao = ?, 
                                           codigo_expiracao = ?
                                       WHERE email = ? AND email_verificado = FALSE");

            return $stmt->execute([$codigo_verificacao, $codigo_expiracao, $email]) ? $codigo_verificacao : false;
        } catch (PDOException $e) {
            error_log("Erro ao reenviar código: " . $e->getMessage());
            return false;
        }
    }
}
