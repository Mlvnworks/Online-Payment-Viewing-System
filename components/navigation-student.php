<?php
function navigationStudent($active_page, $title){
    return '<nav class="navbar navbar-expand-lg bg-body-tertiary" style="z-index:1000000000; position:abslute; width:100%; top: 0;background-color:var(--custom-secondary) !important;">
                <div class="container-fluid">
                    <a class="navbar-brand text-light" href="#">Online Viewing of Payment | '.$title.'</a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup" style="margin-left:50px">
                        <div class="navbar-nav">
                            <a class="nav-link '.(($active_page == "dashboard") ? ("text-light") : ("text-secondary")).'" aria-current="page" href="./?c=dashboard">Dashboard</a>
                            <a class="nav-link text-danger ms-lg-5 " aria-current="page" href="./?logout-student">Log out</a>
                        </div>
                    </div>
                </div>
            </nav>';
}

