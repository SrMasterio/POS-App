<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom d-lg-flex justify-content-lg-between">
                    
    <div>
        <button class="btn btn-default border-0" id="menu-toggle">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="d-flex">

        <div class="p-2">
            <a href="#myProfile" class="ms-2" data-bs-toggle="modal" style="color:inherit;">
                <i class="bi bi-person-circle"></i>
                <?php echo urldecode($_SESSION["admin"]->name_admin) ?>
            </a>
        </div>

        <div class="p-2 mx-2">
            <a href="/logout" class="text-dark">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>

    </div>

</nav>
