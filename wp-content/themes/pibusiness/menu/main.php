<?php
$options = get_option('general_settings');
$logoId = $options['pi_logo_value'];
$mobileLogoId = $options['pi_mobile_logo_value'];
$phone = $options['pi_number'];
?>
<div class="nav-wrapper"
     :class="{'sticky': isMenuSticky && !isMobile}"
     id="main-menu"
     :data-ismobile="isMobile"
     data-hovering="off">

    <div class="container">
        <div class="nav-container" ref="header" id="nav-container">
            <nav class="navbar navbar-expand-lg navbar-dark d-block">
                <div class="d-xl-none d-inline-block w-100">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-xl-8 pr-lg-3 pr-0">
                            <a class="navbar-brand mobile-brand" href="<?= get_home_url(); ?>">
                                Abello's Dog Training
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-4">
                            <a href="tel:<?= $phone ?? null ?>" class="float-none float-md-right mt-2 font-weight-bold phone">
                                <?= $phone ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overlay" ref="menu" :style="{
                            top: overlayTopPosition + 'px',
                        }">

                    <div class="navbar-collapse pi-menu"
                         v-show="isMenuActive" :style="{
                                    right: overlayRightPosition + '%'
                                }">
                        <ul class="navbar-nav mr-auto py-2">
                            <li class="mr-4 d-none d-xl-inline-block">
                                <a class="navbar-brand" href="<?= get_home_url(); ?>">
                                    <!--                                    --><? //= wp_get_attachment_image($logoId, 'full', false, ['class' => 'img img-fluid']); ?>
                                    Abello's Dog Training
                                </a>
                            </li>
                            <?php foreach ($menu as $item): ?>
                                <?php
                                set_query_var('item', $item);
                                set_query_var('depth', 0);
                                get_template_part('menu/item');
                                ?>
                            <?php endforeach; ?>
                        </ul>
                        <div class="d-none d-xl-inline-block">
                            <a href="tel:<?= $phone ?? null ?>" class="font-weight-bold phone">
                                Call Now &nbsp;<?= $phone ?>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>