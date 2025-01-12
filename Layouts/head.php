<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= base_url(); ?>">
    <title>Help Desk</title>
    <link rel="icon" href="<?= assets(); ?>/img/logo/logo_img.ico">
    <link rel="stylesheet" href="<?= assets(); ?>/css/app.css">
    <link rel="stylesheet" href="<?= assets(); ?>/css/app-dark.css">
    <link rel="stylesheet" href="<?= assets(); ?>/extensions/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= assets(); ?>/css/extra-component-sweetalert.css">

    <?php
    if (isset($data['css']) && !empty($data['css'])) {
        if (is_array($data['css'])) {
            foreach ($data['css'] as $css_file) {
                $css_path = assets() . $css_file;
                echo "<link rel=\"stylesheet\" href=\"$css_path\">";
            }
        } else {
            $css_path = assets() . $data['css'];
            echo "<link rel=\"stylesheet\" href=\"$css_path\">";
        }
    }
    ?>

    <link rel="stylesheet" href="<?= assets(); ?>/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="<?= assets(); ?>/css/table-datatable-jquery.css">
 

</head>