<?php 
    require 'Libraries/vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

	function base_url()
	{
		return BASE_URL;
	}
    function assets()
    {
        return BASE_URL."/Assets";
    }
    function modal_permissions($data)
    {
        $view_modal = "Views/Roles/permissions.php";
        require_once $view_modal;        
    }
    function modal_additional_permissions($data)
    {
        $view_modal = "Views/Roles/additional-permissions.php";
        require_once $view_modal;        
    }
    function generate_html(string $name_folder, string $name_archive, $data)
    {
        $view_content = "Views/{$name_folder}/{$name_archive}.php";
        require_once $view_content;        
    }

    function send_ticket_notification($user_email, $subject, $message) {
        //CARGAR VARIABLES DEL ARCHIVO .ENV
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $emailUser = $_ENV['EMAIL_USERNAMER'];
        $emailPassword = $_ENV['EMAIL_PASSWORDR'];
    
        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $emailUser;
            $mail->Password = $emailPassword;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->setFrom($emailUser, 'Soporte Técnico');
            $mail->addAddress($user_email);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Error sending email: " . $mail->ErrorInfo);
            return false;
        }
    }

    function notify_ticket($id_ticket, $status) {
        require_once ("Models/TicketsModel.php");
        $object = new TicketsModel();
        $ticket_data = $object->show_specific_ticket($id_ticket);
        $user_email = $ticket_data['email_user'];
        $subject = "Actualización sobre su ticket: {$ticket_data['id_ticket']}";
        $notification_message = "";
        $email_message = "";

        $styles = "
            <style>
                .main {
                    font-family: Arial, sans-serif;
                    background-color: #d9eafc;
                    margin: 0;
                    padding: 20px;
                }
                .container {
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    margin: 20px auto;
                    max-width: 600px;
                }
                .header {
                    background-color: #002958;
                    color: #ffffff;
                    text-align: center;
                    padding: 10px 0;
                    border-radius: 8px 8px 0 0;
                }
                .header h1 {
                    margin: 0;
                    font-size: 18px;
                }
                .content {
                    color: #333333;
                    line-height: 1.6;
                }
                .content p {
                    margin: 10px 0;
                }
                .footer {
                    text-align: center;
                    font-size: 12px;
                    color: #666666;
                    margin-top: 20px;
                }
            </style>
        ";

        $header = "<div class='header'><h1>Soporte Técnico</h1></div>";
        $footer = "<div class='footer'>© 2025 [Nombre de la Empresa] - [Número RUC]</div>";
    
        switch ($status) {
            case 'opened':
                $notification_message = "Su ticket se creó con éxito.";
                $email_message = "<p>Estimado usuario,</p>
                                    <p>Su ticket con código <strong>{$ticket_data['id_ticket']}</strong> ha sido creado exitosamente.</p>
                                    <p><strong>Asunto:</strong> {$ticket_data['title_ticket']}</p>
                                    <p><strong>Categoría:</strong> {$ticket_data['name_category']}</p>
                                    <p><strong>Subcategoría:</strong> {$ticket_data['name_subcategory']}</p>
                                    <p>Gracias por comunicarse con nosotros.</p>";
                break;
            case 'assigned':
                $notification_message = "Se le ha asignado soporte técnico a su ticket.";
                $email_message = "<p>Estimado usuario,</p>
                                    <p>Su ticket con código <strong>{$ticket_data['id_ticket']}</strong> ha sido asignado a nuestro equipo técnico.</p>
                                    <p><strong>El responsable asignado es:</strong> {$ticket_data['support_name']}.</p>";
                break;
            case 'new_message':
                $notification_message = "Tiene un nuevo mensaje en su ticket.";
                $email_message = "<p>Estimado usuario,</p>
                                    <p>Hay un nuevo mensaje en su ticket con código <strong>{$ticket_data['id_ticket']}</strong>.</p>
                                    <p>Mensaje: {$ticket_data['message']}</p>";
                break;
            case 'closed':
                $notification_message = "Su ticket ha sido cerrado.";
                $email_message = "<p>Estimado usuario,</p>
                                    <p>Su ticket con código <strong>{$ticket_data['id_ticket']}</strong> ha sido cerrado.</p>
                                    <p>Gracias por confiar en nosotros.</p>";
                break;
            case 'reopened':
                $notification_message = "Su ticket ha sido reabierto.";
                $email_message = "<p>Estimado usuario,</p>
                                    <p>Su ticket con código <strong>{$ticket_data['id_ticket']}</strong> ha sido reabierto.</p>
                                    <p>Un agente de soporte se pondrá en contacto con usted pronto para continuar con el seguimiento.</p>";
                break;
        }

        $email_message_html = "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                {$styles}
            </head>
            <body>
                <div class='main'>
                    <div class='container'>
                        {$header}
                        <div class='content'>
                            {$email_message}
                        </div>
                        {$footer}
                    </div>
                </div>
            </body>
            </html>
        ";

        $user_id = $ticket_data['id_user_ticket'];
        create_ticket_notification($id_ticket, $user_id, $notification_message);
    
        return send_ticket_notification($user_email, $subject, $email_message_html);
    }

    function create_ticket_notification($id_ticket, $user_id, $notification_message){
        require_once ("Models/NotificationsModel.php");
        $object = new NotificationsModel();
        $object->insert_notification($id_ticket, $user_id, $notification_message);
    }

    function check_permissions(int $id_module){
        require_once ("Models/PermissionsModel.php");
        $object_permissions = new PermissionsModel();
        if(!empty($_SESSION['user_data'])){
            $id_role = $_SESSION['user_data']['id_role'];
            $data_permissions = $object_permissions->extract_permissions($id_role);
            $permissions = '';
            $permissions_modules = '';
            if(count($data_permissions) > 0 ){
                $permissions = $data_permissions;
                $permissions_modules = isset($data_permissions[$id_module]) ? $data_permissions[$id_module] : "";
            }
            $_SESSION['permissions'] = $permissions;
            $_SESSION['module_permissions'] = $permissions_modules;
        }
    }

    function check_additional_permissions(int $id_module){
        require_once ("Models/AdditionalPermissionsModel.php");
        $object_additional_permissions = new AdditionalPermissionsModel();
        if(!empty($_SESSION['user_data'])){
            $id_role = $_SESSION['user_data']['id_role'];
            $data_additional_permissions = $object_additional_permissions->extract_additional_permissions($id_role, $id_module);
            $_SESSION['additional_permissions_module'] = $data_additional_permissions;
        }
    }

    function session_user(int $id_user){
        require_once ("Models/LoginModel.php");
        $obj_login = new LoginModel();
        $request = $obj_login->session_login($id_user);
        $_SESSION['user_data'] = $request;
        return $request;
    }
    
    function check_user_status(int $id_user){
        require_once ("Models/UsersModel.php");
        $object = new UsersModel();
        $request = $object->get_user_status($id_user);
        $_SESSION['status_active_user'] = $request['status_active_user'];
        return;
    }
    
    function upload_attachments_ticket($files, $id_ticket){
        require_once ("Models/TicketsModel.php");
        $object = new TicketsModel();

        // Crear una carpeta con el id del ticket
        $upload_dir = 'Assets/uploads/attachments_ticket/' . $id_ticket . '/';

        // Verificar si la carpeta existe, si no, crearla
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($files['name'] as $key => $file_name) {
            
            // Limpiar el nombre del archivo
            $file_name = preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $file_name);

            $file_tmp_name = $files['tmp_name'][$key];
            $file_type = $files['type'][$key];
            $file_size = $files['size'][$key];

            // Generar un código único para renombrar el archivo
            $prefix = "TI_";
            $unique_code = uniqid($prefix, true);
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // Obtener la extensión del archivo
            $new_file_name = $unique_code . '.' . $file_extension; // Renombrar el archivo con el código único y la extensión original

            // Definir la ruta de destino
            $uploaded_file_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp_name, $uploaded_file_path)) {
                // Insertar el archivo en la base de datos asociándolo al ticket
                $object->insert_attachment_ticket($id_ticket, $uploaded_file_path, $file_name);
            }
        }
    }

    function upload_attachments_message($files, $id_message){
        require_once ("Models/TicketsModel.php");
        $object = new TicketsModel();

        $upload_dir = 'Assets/uploads/attachments_message/' . $id_message . '/';

        // Verificar si la carpeta existe, si no, crearla
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        foreach ($files['name'] as $key => $file_name) {

            // Limpiar el nombre del archivo
            $file_name = preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $file_name);
            
            $file_tmp_name = $files['tmp_name'][$key];
            $file_type = $files['type'][$key];
            $file_size = $files['size'][$key];

            // Generar un código único para renombrar el archivo
            $prefix = "ME_";
            $unique_code = uniqid($prefix, true);
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION); // Obtener la extensión del archivo
            $new_file_name = $unique_code . '.' . $file_extension; // Renombrar el archivo con el código único y la extensión original

            // Definir la ruta de destino
            $uploaded_file_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp_name, $uploaded_file_path)) {
                $object->insert_attachment_message($id_message, $uploaded_file_path, $file_name);
            }
        }
    }

    function delete_file(string $route_complete){
        unlink($route_complete);
    }
?>