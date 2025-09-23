<?php
// Arquivo: app/models/UserModel.php
// Descrição: Este arquivo contém a classe UserModel para interagir com a tabela 'usuarios' no banco de dados, 
//com métodos para criação de contas, verificação de códigos, carregamento de dados do usuário e atualização de perfil.

require_once __DIR__ . '/../configs/database.php';

class UserModel
{
    private $db;
    private $table = "usuarios";

    /**
     * Construtor da classe UserModel.
     * Inicializa a conexão com o banco de dados.
     */
    public function __construct()
    {
        $this->db = getConnection();
    }

    /**
     * Método para criar uma nova conta de usuário.
     * @param string $name Nome do usuário.
     * @param string $email Email do usuário.
     * @param string $password Senha do usuário.
     * @param bool $active Status ativo da conta (padrão true).
     * @return string|false Retorna o código de verificação em sucesso ou false em falha.
     */
    public function createUserAccountModel($name, $email, $password, $active = true)
    {
        try {
            if ($this->emailExistsModel($email)) {
                error_log("Erro ao criar conta: Email já registrado ($email)");
                return false;
            }
            $token_api = bin2hex(random_bytes(32));
            $codigo_verificacao = $this->generateVerificationCode();
            $codigo_expiracao = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $stmt = $this->db->prepare("INSERT INTO usuarios 
                (nome, email, senha, token_api, codigo_verificacao, codigo_expiracao, ativo, email_verificado)  
                VALUES (?,?,?,?,?,?,?,?)");

            $success = $stmt->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $token_api,
                $codigo_verificacao,
                $codigo_expiracao,
                $active,
                false
            ]);

            return $success ? $codigo_verificacao : false;
        } catch (PDOException $e) {
            error_log("Erro ao criar conta: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Método para carregar dados do usuário pelo ID.
     * @param int $id ID do usuário.
     * @return array|false Retorna um array com dados do usuário ou false se não encontrado.
     */
    public function loadUserDataModel($id)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                error_log("Erro: ID de usuário inválido ($id)");
                return false;
            }
            $stmt = $this->db->prepare("SELECT nome, email, criado_em, atualizado_em, email_verificado, token_api 
                                        FROM usuarios WHERE id = ? AND ativo = TRUE");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                error_log("Nenhum usuário encontrado para ID $id ou usuário inativo");
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao carregar dados do usuário ID $id: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Método para atualizar os dados do usuário.
     * @param int $id ID do usuário.
     * @param string $nome Novo nome do usuário.
     * @param string $email Novo email do usuário.
     * @return bool Retorna true em sucesso, false em falha.
     */
    public function updateUserModel($id, $nome, $email)
    {
        try {
            if (!is_numeric($id) || $id <= 0) {
                error_log("Erro ao atualizar usuário: ID inválido ($id)");
                return false;
            }

            // Verificar se o email já existe para outro usuário
            $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
            $stmt->execute([$email, $id]);
            if ($stmt->fetch()) {
                error_log("Erro ao atualizar usuário: Email já registrado ($email)");
                return false;
            }

            $stmt = $this->db->prepare("UPDATE usuarios 
                                        SET nome = ?, email = ?, atualizado_em = NOW()
                                        WHERE id = ? AND ativo = TRUE");
            $success = $stmt->execute([$nome, $email, $id]);

            if ($success) {
                error_log("Usuário ID $id atualizado com sucesso");
                return true;
            } else {
                error_log("Erro ao atualizar usuário: Nenhum registro atualizado para ID $id");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao atualizar usuário ID $id: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Método privado para gerar um código de verificação único de 6 dígitos.
     * @return string Retorna o código gerado.
     */
    private function generateVerificationCode()
    {
        do {
            $code = sprintf('%06d', random_int(0, 999999));
            $exists = $this->verificationCodeExists($code);
        } while ($exists);

        return $code;
    }

    /**
     * Método privado para verificar se um código de verificação já existe.
     * @param string $code Código de verificação.
     * @return bool Retorna true se o código existir, false caso contrário.
     */
    private function verificationCodeExists($code)
    {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE codigo_verificacao = ?");
        $stmt->execute([$code]);
        return $stmt->fetch() !== false;
    }

    /**
     * Método para verificar se um email já existe na tabela.
     * @param string $email Email a verificar.
     * @return bool Retorna true se o email existir, false caso contrário.
     */
    public function emailExistsModel($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    /**
     * Método para obter o usuário pelo ID, incluindo ID, nome e email.
     * @param int $id ID do usuário.
     * @return array|false Retorna um array com 'id', 'nome' e 'email' ou false se não encontrado.
     */
    public function getUserById($id)
    {
        $query = "SELECT id, nome, email FROM " . $this->table . " WHERE id = :id AND ativo = TRUE";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Método para obter o nome do usuário pelo email.
     * @param string $email Email do usuário.
     * @return array|false Retorna um array com 'nome' ou false se não encontrado.
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT nome FROM usuarios WHERE email = ? AND ativo = TRUE");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Método para verificar o código de verificação.
     * @param string $email Email do usuário.
     * @param string $code Código de verificação.
     * @return array|false Retorna um array com 'id' ou false se inválido.
     */
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

    /**
     * Método para ativar a conta do usuário.
     * @param int $userId ID do usuário.
     * @return bool Retorna true em sucesso, false em falha.
     */
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
            error_log("Erro ao ativar usuário: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Método para verificar se o email foi verificado.
     * @param string $email Email do usuário.
     * @return bool Retorna true se verificado, false caso contrário.
     */
    public function isEmailVerifiedModel($email)
    {
        $stmt = $this->db->prepare("SELECT email_verificado FROM usuarios WHERE email = ? AND ativo = TRUE");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (bool)$result['email_verificado'] : false;
    }

    /**
     * Método para reenviar o código de verificação.
     * @param string $email Email do usuário.
     * @return string|false Retorna o novo código em sucesso ou false em falha.
     */
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
?>