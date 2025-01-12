<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <span role="button" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul id="content-dropdown-notifications-ajax" class="navbar-nav ms-auto mb-lg-0"></ul>
                
                <div class="mb-lg-0">
                    <div class="user-profile d-flex">
                        <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600"><?= $_SESSION['user_data']['first_names_user']; ?></h6>
                            <p class="mb-0 text-sm text-gray-600"><?= $_SESSION['user_data']['name_role']; ?></p>
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="<?= assets(); ?>/jpg/1.jpg">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>
</header>