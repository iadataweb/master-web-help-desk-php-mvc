-- Crear tabla para registrar roles
CREATE TABLE roles (
    id_role INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name_role VARCHAR(150) NOT NULL,
    description_role TEXT NOT NULL,
    status_active_role TINYINT NOT NULL DEFAULT 0 CHECK (status_active_role IN (0, 1)),
    status_deleted_role TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_role IN (0, 1)),
    date_created_role TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_role TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Crear tabla para registrar modulos
CREATE TABLE modules (
    id_module INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name_module VARCHAR(150) NOT NULL,
    description_module TEXT NOT NULL,
    status_active_module TINYINT NOT NULL DEFAULT 1 CHECK (status_active_module IN (0, 1)),
    status_deleted_module TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_module IN (0, 1)),
    date_created_module TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_module TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Crear tabla para registrar permisos
CREATE TABLE permissions (
    id_permission INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_role_permission INT NOT NULL,
    id_module_permission INT NOT NULL,
    r_read_permission TINYINT NOT NULL DEFAULT 0 CHECK (r_read_permission IN (0, 1)),
    w_write_permission TINYINT NOT NULL DEFAULT 0 CHECK (w_write_permission IN (0, 1)),
    u_update_permission TINYINT NOT NULL DEFAULT 0 CHECK (u_update_permission IN (0, 1)),
    d_delete_permission TINYINT NOT NULL DEFAULT 0 CHECK (d_delete_permission IN (0, 1)),
    date_created_permission TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_permission TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_role_permission) REFERENCES roles(id_role),
    FOREIGN KEY (id_module_permission) REFERENCES modules(id_module)
);

-- Crear tabla para registrar controles
CREATE TABLE controls (
    id_control INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_module_control INT NOT NULL,
    name_control TEXT NOT NULL,
    description_control TEXT NOT NULL,
    status_active_control TINYINT NOT NULL DEFAULT 1 CHECK (status_active_control IN (0, 1)),
    status_deleted_control TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_control IN (0, 1)),
    date_created_control TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_control TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_module_control) REFERENCES modules(id_module)
);

-- Crear tabla para registrar permisos adicionales
CREATE TABLE additional_permissions (
    id_additional_permission INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_role_additional_permission INT NOT NULL,
    id_control_additional_permission INT NOT NULL,
    allow_additional_permission TINYINT NOT NULL DEFAULT 0 CHECK (allow_additional_permission IN (0, 1)),
    date_created_additional_permission TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_additional_permission TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_role_additional_permission) REFERENCES roles(id_role),
    FOREIGN KEY (id_control_additional_permission) REFERENCES controls(id_control)
);

-- Crear tabla para registrar usuarios
CREATE TABLE users (
    id_user INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_role_user INT NOT NULL,
    first_names_user VARCHAR(150) NOT NULL,
    last_names_user VARCHAR(150) NOT NULL,
    cell_phone_user VARCHAR(9) NOT NULL,
    email_user VARCHAR(200) NOT NULL UNIQUE,
    password_user VARCHAR(200) NOT NULL,
    token_permission_user TEXT NULL,
    token_expiration_user TEXT NULL,
    status_active_user TINYINT NOT NULL DEFAULT 1 CHECK (status_active_user IN (0, 1)),
    status_deleted_user TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_user IN (0, 1)),
    date_created_user TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_user TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_role_user) REFERENCES roles(id_role)
);

-- Crear tabla para registrar categorías
CREATE TABLE categories (
    id_category INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name_category VARCHAR(100) NOT NULL,
    status_active_category TINYINT NOT NULL DEFAULT 1 CHECK (status_active_category IN (0, 1)),
    status_deleted_category TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_category IN (0, 1)),
    date_created_category TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_category TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Crear tabla para registrar subcategorías
CREATE TABLE subcategories (
    id_subcategory INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_category_subcategory INT NOT NULL,
    name_subcategory VARCHAR(100) NOT NULL,
    status_active_subcategory TINYINT NOT NULL DEFAULT 1 CHECK (status_active_subcategory IN (0, 1)),
    status_deleted_subcategory TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_subcategory IN (0, 1)),
    date_created_subcategory TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_subcategory TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_category_subcategory) REFERENCES categories(id_category)
);

-- Crear tabla para registrar prioridades
CREATE TABLE priorities (
    id_priority INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name_priority VARCHAR(100) NOT NULL,
    status_active_priority TINYINT NOT NULL DEFAULT 1 CHECK (status_active_priority IN (0, 1)),
    status_deleted_priority TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_priority IN (0, 1)),
    date_created_priority TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_priority TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Crear tabla para registrar tickets
CREATE TABLE tickets (
    id_ticket INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_user_ticket INT NOT NULL,
    id_support_assigned_ticket INT NULL,
    id_category_ticket INT NOT NULL,
    id_subcategory_ticket INT NOT NULL,
    id_priority_ticket INT NOT NULL,
    title_ticket TEXT NOT NULL,
    description_ticket TEXT NOT NULL,
    status_open_ticket TINYINT NOT NULL DEFAULT 1 CHECK (status_open_ticket IN (0, 1)),
    status_active_ticket TINYINT NOT NULL DEFAULT 1 CHECK (status_active_ticket IN (0, 1)),
    status_deleted_ticket TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_ticket IN (0, 1)),
    date_created_ticket TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_ticket TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    date_assigned_ticket TIMESTAMP NULL,
    date_closed_ticket TIMESTAMP NULL,
    FOREIGN KEY (id_user_ticket) REFERENCES users(id_user),
    FOREIGN KEY (id_support_assigned_ticket) REFERENCES users(id_user),
    FOREIGN KEY (id_category_ticket) REFERENCES categories(id_category),
    FOREIGN KEY (id_subcategory_ticket) REFERENCES subcategories(id_subcategory),
    FOREIGN KEY (id_priority_ticket) REFERENCES priorities(id_priority)
);

-- Crear tabla para registrar archivos adjuntos del ticket
CREATE TABLE attachments_ticket (
    id_attachment_ticket INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_ticket_attachment_ticket INT NOT NULL,
    route_attachment_ticket VARCHAR(255) NOT NULL,
    name_attachment_ticket TEXT NOT NULL,
    status_open_attachment_ticket TINYINT NOT NULL DEFAULT 1 CHECK (status_open_attachment_ticket IN (0, 1)),
    status_active_attachment_ticket TINYINT NOT NULL DEFAULT 1 CHECK (status_active_attachment_ticket IN (0, 1)),
    status_deleted_attachment_ticket TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_attachment_ticket IN (0, 1)),
    date_created_attachment_ticket TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_attachment_ticket TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ticket_attachment_ticket) REFERENCES tickets(id_ticket)
);

-- Crear tabla para registrar mensajes
CREATE TABLE messages (
    id_message INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_ticket_message INT NOT NULL,
    id_user_message INT NOT NULL,
    content_message TEXT NOT NULL,
    status_active_message TINYINT NOT NULL DEFAULT 1 CHECK (status_active_message IN (0, 1)),
    status_deleted_message TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_message IN (0, 1)),
    date_created_message TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_message TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ticket_message) REFERENCES tickets(id_ticket),
    FOREIGN KEY (id_user_message) REFERENCES users(id_user)
);

-- Crear tabla para registrar archivos adjuntos del mensaje
CREATE TABLE attachments_message (
    id_attachment_message INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_message_attachment_message INT NOT NULL,
    route_attachment_message VARCHAR(255) NOT NULL,
    name_attachment_message TEXT NOT NULL,
    status_open_attachment_message TINYINT NOT NULL DEFAULT 1 CHECK (status_open_attachment_message IN (0, 1)),
    status_active_attachment_message TINYINT NOT NULL DEFAULT 1 CHECK (status_active_attachment_message IN (0, 1)),
    status_deleted_attachment_message TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_attachment_message IN (0, 1)),
    date_created_attachment_message TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_attachment_message TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_message_attachment_message) REFERENCES messages(id_message)
);

-- Crear tabla para registrar notificaciones
CREATE TABLE notifications (
    id_notification INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_ticket_notification INT NOT NULL,
    id_user_notification INT NOT NULL,
    message_notification TEXT NOT NULL,
    status_read_notification TINYINT NOT NULL DEFAULT 0 CHECK (status_read_notification IN (0, 1)),
    status_active_notification TINYINT NOT NULL DEFAULT 1 CHECK (status_active_notification IN (0, 1)),
    status_deleted_notification TINYINT NOT NULL DEFAULT 0 CHECK (status_deleted_notification IN (0, 1)),
    date_created_notification TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_updated_notification TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ticket_notification) REFERENCES tickets(id_ticket),
    FOREIGN KEY (id_user_notification) REFERENCES users(id_user)
);

-- Insertar datos en la tabla 'roles'
INSERT INTO roles (
    id_role, 
    name_role, 
    description_role, 
    status_active_role, 
    status_deleted_role,
    date_created_role) VALUES 
(1, 'Super Administrador', 'Rol de más alto nivel con acceso completo al sistema.', 1, 0, '2024-12-01 12:00:00'),
(2, 'Administrador', 'Rol con altos privilegios operativos, pero sin acceso completo a la configuración crítica del sistema.', 1, 0, '2024-12-01 12:00:00'),
(3, 'Soporte', 'Rol encargado de la atención directa al usuario y la resolución de problemas.', 1, 0, '2024-12-01 12:00:00'),
(4, 'Usuario Final', 'Rol de clientes o empleados que necesitan soporte.', 1, 0, '2024-12-01 12:00:00');

-- Insertar datos en la tabla 'modulos'
INSERT INTO modules (
    id_module, 
    name_module, 
    description_module, 
    status_active_module, 
    status_deleted_module,
    date_created_module) VALUES 
(1, 'Dashboard', 'Vista general del sistema con métricas y gráficos clave.', 1, 0, '2024-12-01 12:00:00'),
(2, 'Usuarios', 'Administración de cuentas de usuario, incluyendo roles y permisos.', 1, 0, '2024-12-01 12:00:00'),
(3, 'Roles', 'Configuración de permisos.', 1, 0, '2024-12-01 12:00:00'),
(4, 'Tickets', 'Gestión avanzada de tickets, incluyendo reasignaciones y cambios de estado.', 1, 0, '2024-12-01 12:00:00'),
(5, 'Categorías', 'Configuración de categorías principales para clasificar tickets.', 1, 0, '2024-12-01 12:00:00'),
(6, 'Subcategorías', 'Subdivisiones dentro de las categorías principales para mayor detalle.', 1, 0, '2024-12-01 12:00:00'),
(7, 'Prioridades', 'Configuración de niveles de prioridad para tickets y su manejo.', 1, 0, '2024-12-01 12:00:00');

-- Insertar datos en la tabla 'permisos'
INSERT INTO permissions (
    id_permission, 
    id_role_permission, 
    id_module_permission, 
    r_read_permission, 
    w_write_permission,
    u_update_permission, 
    d_delete_permission, 
    date_created_permission) VALUES 
(1, 1, 1, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(2, 1, 2, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(3, 1, 3, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(4, 1, 4, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(5, 1, 5, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(6, 1, 6, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(7, 1, 7, 1, 1, 1, 1, '2024-12-01 12:00:00'),

(8, 2, 1, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(9, 2, 2, 0, 0, 0, 0, '2024-12-01 12:00:00'),
(10, 2, 3, 0, 0, 0, 0, '2024-12-01 12:00:00'),
(11, 2, 4, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(12, 2, 5, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(13, 2, 6, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(14, 2, 7, 1, 1, 1, 1, '2024-12-01 12:00:00'),

(15, 3, 1, 1, 1, 1, 1, '2024-12-01 12:00:00'),
(16, 3, 2, 0, 0, 0, 0, '2024-12-01 12:00:00'),
(17, 3, 3, 0, 0, 0, 0, '2024-12-01 12:00:00'),
(18, 3, 4, 1, 0, 0, 0, '2024-12-01 12:00:00'),
(19, 3, 5, 0, 0, 0, 0, '2024-12-01 12:00:00'),
(20, 3, 6, 0, 0, 0, 0, '2024-12-01 12:00:00'),
(21, 3, 7, 0, 0, 0, 0, '2024-12-01 12:00:00');

-- Insertar datos en la tabla 'controles'
INSERT INTO controls (
    id_control, 
    id_module_control, 
    name_control, 
    description_control, 
    status_active_control, 
    status_deleted_control,
    date_created_control) VALUES 
(1, 4, 'Permitir asignar soporte a tickets generados por usuarios finales.', 'Define si el usuario tiene permiso para asignar soporte a los tickets creados por usuarios finales.', 1, 0, '2024-12-01 12:00:00'),
(2, 4, 'Permitir que el usuario sea elegido como soporte en la asignación de tickets.', 'Habilita que el usuario pueda ser seleccionado como responsable de un ticket.', 1, 0, '2024-12-01 12:00:00'),
(3, 4, 'Permitir visualizar únicamente los tickets asignados.', 'Restringe la visibilidad del usuario a los tickets que le han sido asignados. Si está desactivado, el usuario puede ver todos los tickets visibles en el sistema.', 1, 0, '2024-12-01 12:00:00'),
(4, 4, 'Permitir administrar únicamente los tickets asignados.', 'Limita la capacidad de administrar (responder, cerrar, reabrir, etc.) a los tickets asignados al usuario. Si está desactivado, puede administrar todos los tickets visibles.', 1, 0, '2024-12-01 12:00:00'),
(5, 4, 'Permitir enviar mensajes.', 'Habilita la capacidad de enviar mensajes en los tickets que el usuario puede visualizar.', 1, 0, '2024-12-01 12:00:00'),
(6, 4, 'Permitir editar mensajes.', 'Permite modificar mensajes enviados en los tickets visibles para el usuario.', 0, 0, '2024-12-01 12:00:00'),
(7, 4, 'Permitir eliminar mensajes.', 'Autoriza la eliminación de mensajes en los tickets visibles para el usuario.', 0, 0, '2024-12-01 12:00:00'),
(8, 4, 'Permitir cerrar tickets.', 'Habilita la opción de marcar tickets como resueltos o cerrados.', 1, 0, '2024-12-01 12:00:00'),
(9, 4, 'Permitir reabrir tickets.', 'Autoriza la acción de reabrir tickets previamente cerrados.', 1, 0, '2024-12-01 12:00:00');

-- Insertar datos en la tabla 'permisos adicionales'
INSERT INTO additional_permissions (
    id_additional_permission, 
    id_role_additional_permission, 
    id_control_additional_permission, 
    allow_additional_permission, 
    date_created_additional_permission) VALUES 
(1, 1, 1, 1, '2024-12-01 12:00:00'),
(2, 1, 2, 0, '2024-12-01 12:00:00'),
(3, 1, 3, 0, '2024-12-01 12:00:00'),
(4, 1, 4, 0, '2024-12-01 12:00:00'),
(5, 1, 5, 1, '2024-12-01 12:00:00'),
(6, 1, 6, 1, '2024-12-01 12:00:00'),
(7, 1, 7, 1, '2024-12-01 12:00:00'),
(8, 1, 8, 1, '2024-12-01 12:00:00'),
(9, 1, 9, 1, '2024-12-01 12:00:00'),

(10, 2, 1, 1, '2024-12-01 12:00:00'),
(11, 2, 2, 0, '2024-12-01 12:00:00'),
(12, 2, 3, 0, '2024-12-01 12:00:00'),
(13, 2, 4, 0, '2024-12-01 12:00:00'),
(14, 2, 5, 1, '2024-12-01 12:00:00'),
(15, 2, 6, 1, '2024-12-01 12:00:00'),
(16, 2, 7, 1, '2024-12-01 12:00:00'),
(17, 2, 8, 1, '2024-12-01 12:00:00'),
(18, 2, 9, 1, '2024-12-01 12:00:00'),

(19, 3, 1, 0, '2024-12-01 12:00:00'),
(20, 3, 2, 1, '2024-12-01 12:00:00'),
(21, 3, 3, 0, '2024-12-01 12:00:00'),
(22, 3, 4, 1, '2024-12-01 12:00:00'),
(23, 3, 5, 1, '2024-12-01 12:00:00'),
(24, 3, 6, 1, '2024-12-01 12:00:00'),
(25, 3, 7, 1, '2024-12-01 12:00:00'),
(26, 3, 8, 1, '2024-12-01 12:00:00'),
(27, 3, 9, 1, '2024-12-01 12:00:00');

-- Insertar datos en la tabla 'usuarios'
INSERT INTO users (
    id_user, 
    id_role_user, 
    first_names_user, 
    last_names_user, 
    cell_phone_user,
    email_user, 
    password_user, 
    status_active_user, 
    status_deleted_user, 
    date_created_user) VALUES 
(1, 1, 'Carlos Kirito', 'Injante', '111111111', 'carlos.kirito@example.com', '$2y$10$ZTsNuxjSBK6j.xrFLA49pepFGtNylTEJIVNR8h9GKqPGO9kxCSdoe', 1, 0, '2024-12-01 12:00:00'),
(2, 2, 'Ana Sakura', 'Sánchez', '111111111', 'ana.sakura@example.com', '$2y$10$ZTsNuxjSBK6j.xrFLA49pepFGtNylTEJIVNR8h9GKqPGO9kxCSdoe', 1, 0, '2024-12-01 12:00:00'),
(3, 3, 'Luis Saitama', 'García', '111111111', 'luis.saitama@example.com', '$2y$10$ZTsNuxjSBK6j.xrFLA49pepFGtNylTEJIVNR8h9GKqPGO9kxCSdoe', 1, 0, '2024-12-01 12:00:00'),
(4, 3, 'Pedro Goku', 'Torres', '111111111', 'pedro.goku@example.com', '$2y$10$ZTsNuxjSBK6j.xrFLA49pepFGtNylTEJIVNR8h9GKqPGO9kxCSdoe', 1, 0, '2024-12-01 12:00:00'),
(5, 4, 'Miguel Luffy', 'Flores', '111111111', 'miguel.luffy@example.com', '$2y$10$ZTsNuxjSBK6j.xrFLA49pepFGtNylTEJIVNR8h9GKqPGO9kxCSdoe', 1, 0, '2024-12-01 12:00:00'),
(6, 4, 'María Hinata', 'Pérez', '111111111', 'maria.hinata@example.com', '$2y$10$ZTsNuxjSBK6j.xrFLA49pepFGtNylTEJIVNR8h9GKqPGO9kxCSdoe', 1, 0, '2024-12-01 12:00:00');

-- Insertar datos en la tabla 'categorías'
INSERT INTO categories (
    id_category, 
    name_category, 
    status_active_category, 
    status_deleted_category, 
    date_created_category) VALUES 
(1, 'Hardware', 1, 0, '2024-12-01 12:00:00'),
(2, 'Software', 1, 0, '2024-12-01 12:00:00');

-- Insertar datos en la tabla 'subcategorías'
INSERT INTO subcategories (
    id_subcategory, 
    id_category_subcategory, 
    name_subcategory, 
    status_active_subcategory, 
    status_deleted_subcategory,
    date_created_subcategory) VALUES 
(1, 1, 'Teclado', 1, 0, '2024-12-01 12:00:00'),
(2, 1, 'Monitor', 1, 0, '2024-12-01 12:00:00'),
(3, 1, 'Mouse', 1, 0, '2024-12-01 12:00:00'),
(4, 1, 'Impresora', 1, 0, '2024-12-01 12:00:00'),
(5, 1, 'Placa Madre', 1, 0, '2024-12-01 12:00:00'),
(6, 1, 'Disco Duro', 1, 0, '2024-12-01 12:00:00'),
(7, 1, 'Memoria RAM', 1, 0, '2024-12-01 12:00:00'),
(8, 1, 'Procesador', 1, 0, '2024-12-01 12:00:00'),
(9, 1, 'Tarjeta Gráfica', 1, 0, '2024-12-01 12:00:00'),
(10, 1, 'Fuente de Poder', 1, 0, '2024-12-01 12:00:00'),
(11, 1, 'Parlantes', 1, 0, '2024-12-01 12:00:00'),
(12, 1, 'Audífonos', 1, 0, '2024-12-01 12:00:00'),
(13, 1, 'Webcam', 1, 0, '2024-12-01 12:00:00'),
(14, 1, 'Micrófono', 1, 0, '2024-12-01 12:00:00'),
(15, 1, 'Wifi', 1, 0, '2024-12-01 12:00:00'),

(16, 2, 'Sistema Operativo', 1, 0, '2024-12-01 12:00:00'),
(17, 2, 'Office', 1, 0, '2024-12-01 12:00:00'),
(18, 2, 'Antivirus', 1, 0, '2024-12-01 12:00:00'),
(19, 2, 'Edición de Video', 1, 0, '2024-12-01 12:00:00'),
(20, 2, 'Diseño Gráfico', 1, 0, '2024-12-01 12:00:00');

-- Insertar datos en la tabla 'prioridades'
INSERT INTO priorities (
    id_priority, 
    name_priority, 
    status_active_priority, 
    status_deleted_priority, 
    date_created_priority) VALUES 
(1, 'Bajo', 1, 0, '2024-12-01 12:00:00'),
(2, 'Medio', 1, 0, '2024-12-01 12:00:00'),
(3, 'Alto', 1, 0, '2024-12-01 12:00:00');

-- Insertar datos en la tabla 'tickets'
INSERT INTO tickets (
    id_ticket, 
    id_user_ticket, 
    id_support_assigned_ticket, 
    id_category_ticket, 
    id_subcategory_ticket, 
    id_priority_ticket, 
    title_ticket, 
    description_ticket, 
    status_open_ticket, 
    date_created_ticket,
    date_updated_ticket,
    date_assigned_ticket, 
    date_closed_ticket) VALUES 
(1, 5, 3, 1, 1, 2, 'Teclado no responde', 'Mi teclado no quiere funcionar, ni reiniciando la compu. ¿Podrían ayudarme a revisarlo, porfa?', 0, '2024-12-06 10:05:00', '2024-12-06 10:05:00', '2024-12-06 11:30:00', '2024-12-06 12:20:00'),
(2, 6, 4, 1, 2, 3, 'Monitor con pantalla parpadeante', 'El monitor está parpadeando a cada rato, no puedo trabajar así. Creo que es la conexión o algo más grave. ¿Me dan una mano?', 0, '2024-12-07 09:14:00', '2024-12-07 09:14:00', '2024-12-07 09:20:00', '2024-12-07 10:10:00'),
(3, 5, 4, 1, 15, 3, 'Problemas de conectividad Wi-Fi', 'La señal de Wi-Fi se va y viene, no sé si es el router o la compu. ¿Podrían revisar, por favor?', 0, '2024-12-21 09:53:00', '2024-12-21 09:53:00', '2024-12-21 10:17:00', '2024-12-21 11:22:00'),
(4, 6, NULL, 2, 17, 1, 'Actualización de Office necesaria', 'Necesito actualizar mi Office para que no me falle en las presentaciones. ¿Alguien puede echarme una mano con eso?', 1, '2024-12-23 09:36:00', '2024-12-23 09:36:00', NULL, NULL);

-- Insertar datos en la tabla 'mensajes'
INSERT INTO messages (
    id_message, 
    id_ticket_message, 
    id_user_message, 
    content_message, 
    date_created_message, 
    date_updated_message) VALUES 
(1, 1, 3, 'Hemos recibido tu reporte sobre el teclado que no responde. Estamos trabajando en ello y pronto te daremos una actualización.', '2024-12-06 11:45:00', '2024-12-06 11:45:00'),
(2, 1, 3, 'El teclado defectuoso ha sido reemplazado y ahora funciona correctamente.', '2024-12-06 12:18:00', '2024-12-06 12:18:00'),
(3, 2, 4, 'Gracias por informarnos sobre el problema con tu monitor. Estamos verificando la conexión y pronto te daremos una solución.', '2024-12-07 09:38:00', '2024-12-07 09:38:00'),
(4, 2, 4, 'El cable de conexión estaba suelto. Hemos ajustado la conexión y el monitor ya no parpadea.', '2024-12-07 10:08:00', '2024-12-07 10:08:00'),
(5, 3, 4, 'Entendido, estamos revisando los problemas de conectividad Wi-Fi. Te mantendremos informado con los resultados.', '2024-12-21 10:27:00', '2024-12-21 10:27:00'),
(6, 3, 4, 'Hemos reiniciado el router y actualizado los controladores de red en tu equipo. La conexión Wi-Fi ahora es estable.', '2024-12-21 11:20:00', '2024-12-21 11:20:00');