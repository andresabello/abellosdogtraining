<?php
$backgroundUrl = get_the_post_thumbnail_url(get_the_ID());
$hasParent = wp_get_post_parent_id(get_the_ID());
$headerCta = html_entity_decode(get_post_meta(get_the_ID(), 'header_cta', true));
$headerCtaToggle = get_field('page_cta_toggle', get_the_ID());
$mobileXPosition = get_field('page_cta_mobile_x_positioning', get_the_ID());

if (!empty($backgroundUrl)) : ?>
    <div class="featured-section"
         style="background-image: url(<?= $backgroundUrl ?>);
                 background-size: cover;
                 background-position-y: center;
                 background-position-x: <?= isset($mobileXPosition) ? $mobileXPosition : 'left' ?>;
                 background-repeat: no-repeat;">
        <?php if (!isset($headerCtaToggle) || $headerCtaToggle) : ?>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="cta white-font">
                            <?= $headerCta ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php endif;

if ($hasParent && !empty($headerCta) && empty($backgroundUrl)) : ?>
    <div class="primary-section section child-featured-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="cta white-font">
                        <?= $headerCta ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
