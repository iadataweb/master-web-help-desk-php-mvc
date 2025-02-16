<?php 
class AccountModel extends Mysql
{
    private $int_id_user;
    private $str_first_names_user;
    private $str_last_names_user;
    private $str_email_user;
    private $int_cell_phone_user;

    private $str_current_password;
    private $str_hashed_password;

    public function __construct()
    {
        parent::__construct();
    }

    public function update_personal_data(int $id_user, string $first_names_user, string $last_names_user, string $email_user, int $cell_phone_user)
    {
        // Sanitizar nombres para evitar XSS y SQL Injection
        $this->int_id_user = $id_user;
        $this->str_first_names_user = htmlspecialchars($first_names_user, ENT_QUOTES, 'UTF-8');
        $this->str_last_names_user = htmlspecialchars($last_names_user, ENT_QUOTES, 'UTF-8');
        $this->str_email_user = htmlspecialchars($email_user, ENT_QUOTES, 'UTF-8');
        $this->int_cell_phone_user = $cell_phone_user;

        // Consulta con parámetro para evitar SQL Injection para evitar SQL Injection
        $sql = "UPDATE users SET first_names_user = ?, last_names_user = ?, cell_phone_user = ?, email_user = ? WHERE id_user = ?";
        $data = [
            $this->str_first_names_user,
            $this->str_last_names_user,
            $this->int_cell_phone_user,
            $this->str_email_user,
            $this->int_id_user
        ];

        return $this->update($sql, $data);
    }

    public function validate_password(int $id_user, string $current_password)
    {
        if ($id_user <= 0 || empty($current_password)) {
            return false;
        }

        $sql = "SELECT id_user, password_user FROM users WHERE id_user = ?";
        $data = [$id_user]; // Pasamos los parámetros correctamente

        $request = $this->select($sql, $data); // Ejecutar con parámetros

        if (!$request) {
            return false; // Usuario no encontrado
        }

        return password_verify($current_password, $request['password_user']) ? $request : false;
    }

    public function update_password(int $id_user, string $hashed_password)
    {
        if ($id_user <= 0 || empty($hashed_password)) {
            return false;
        }

        $sql = "UPDATE users SET password_user = ? WHERE id_user = ?";
        $data = [$hashed_password, $id_user];

        return $this->update($sql, $data);
    }
}
?>
