<li class="nav-item dropdown me-3">
    <a id="js-btn-notification" class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-display="static"
        aria-expanded="false">
        <i class='bi bi-bell bi-sub fs-4'></i>
        <span class="badge badge-notification bg-danger"><?= $data['count_unread_notifications'] ?></span>
    </a>
    <ul class="dropdown-menu dropdown-center  dropdown-menu-sm-end notification-dropdown"
        aria-labelledby="dropdownMenuButton">
        <li class="dropdown-header">
            <h6>Notificaciones</h6>
        </li>

        <?php if (!empty($data['unread_notifications'])) { ?>
        <?php foreach ($data['unread_notifications'] as $unread_notification) { ?>

        <li class="dropdown-item notification-item">
            <a class="d-flex align-items-center" href="<?= base_url(); ?>/tickets/ticket_details/<?= $unread_notification['id_ticket_notification'] ?>" target="_blank">
                <div class="position-relative">
                    <div class="notification-icon d-flex justify-content-center align-items-center bg-primary">
                        <i class="bi bi-info-circle d-flex justify-content-center align-items-center"></i>
                    </div>
                    <span
                        class="position-absolute top-100 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </div>
                <div class="notification-text ms-4">
                    <p class="notification-title font-bold">Actualización sobre su ticket N° <?= $unread_notification['id_ticket_notification'] ?></p>
                    <p class="notification-subtitle font-thin text-sm"><?= $unread_notification['message_notification'] ?></p>
                    <p class="notification-subtitle font-thin text-sm"><?= $unread_notification['date_created_notification'] ?></p>
                </div>
            </a>
        </li>

        <?php } } else { ?>

        <li class="dropdown-item notification-item">
            <span class="d-flex align-items-center">
                <div class="notification-icon d-flex justify-content-center align-items-center bg-primary">
                    <i class="bi bi-info-circle d-flex justify-content-center align-items-center"></i>
                </div>
                <div class="notification-text ms-4">
                    <p class="notification-title font-bold">No hay nuevas notificaciones</p>
                    <p class="notification-subtitle font-thin text-sm">Actualmente no tienes notificaciones no leídas.</p>
                </div>
            </span>
        </li>

        <?php } ?>

        <li>
            <p class="text-center py-2 mb-0"><a href="<?= base_url(); ?>/notifications">Ver todas las notificaciones anteriores</a>
            </p>
        </li>

    </ul>
</li>