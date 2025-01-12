<script src="<?= assets(); ?>/static/js/initTheme.js"></script>
<script src="<?= assets(); ?>/static/js/components/dark.js"></script>
<script src="<?= assets(); ?>/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= assets(); ?>/js/app.js"></script>
<script src="<?= assets(); ?>/extensions/sweetalert2/sweetalert2.min.js"></script>
<script src="<?= assets(); ?>/extensions/jquery/jquery.min.js"></script>
<script src="<?= assets(); ?>/js/show_message.js"></script>
<script src="<?= assets(); ?>/js/notifications.js"></script>

<?php
if (isset($data['script']) && !empty($data['script'])) {
    if (is_array($data['script'])) {
        foreach ($data['script'] as $js_file) {
            $script_path = assets() . $js_file;
            echo "<script src=\"$script_path\"></script>";
        }
    } else {
        $script_path = assets() . $data['script'];
        echo "<script src=\"$script_path\"></script>";
    }
}
?>

<?php if (isset($data['page_functions_js']) && !empty($data['page_functions_js'])) { ?>
    <script src="<?= assets(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
<?php } ?>