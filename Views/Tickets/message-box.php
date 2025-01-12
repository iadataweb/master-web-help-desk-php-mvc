<?php 
    if (!empty($data['messages']) && is_array($data['messages'])) { 
        foreach ($data['messages'] as $message) {
?>

<div class="card">
    <div class="card-header fw-bolder d-flex justify-content-between">
        <span><?= $message['first_names_user'] ?></span>
        <span><?= $message['date_created_message'] ?></span>
    </div>
    <div class="card-body">
        <p class="card-text"><?= $message['content_message'] ?></p>
        
        <?php
            $id_message = $message['id_message'];
            $filtered_attachments = array_filter($data['attachments_message'], function($attachment) use ($id_message) {
                return $attachment['id_message_attachment_message'] == $id_message;
            });
            if (!empty($filtered_attachments)) {
        ?>

        <ul class="list-group">

            <?php foreach ($filtered_attachments as $attachment) { ?>
            
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="text-truncate"><?= $attachment['name_attachment_message'] ?></span>
                <a href="<?= base_url().'/'.$attachment['route_attachment_message'] ?>" target="_blank">
                    <span class="badge bg-primary rounded-pill">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </a>
            </li>

            <?php } ?>

        </ul>

        <?php } ?>

    </div>
</div>

<?php }} ?>