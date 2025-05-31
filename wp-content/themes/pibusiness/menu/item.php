<?php $currentUrl = str_replace('https://' . $_SERVER['HTTP_HOST'], '', $item->url); ?>

<li class="nav-item nav-item-<?= $depth ?>" data-id="<?= $item->ID ?>" data-hovering="false"
    data-flyout="<?= $item->flyout ?>" :class="{'hover-item': !isMobile}" data-level="<?= $depth ?>"
    data-url="<?= $item->url ?>">
    <?php if (isset($item->image) && $item->image): ?>
        <img src="<?= $item->image ?>" alt="<?= $item->title ?>" class="img-fluid img mt-20p">
    <?php endif; ?>
    <div class="toggle-wrapper">
        <div>
            <a href="<?= $item->url !== '' ? $item->url : '/' ?>"
               class="nav-link <?= 'nav-link-' . $depth ?> <?= $currentUrl === $_SERVER['REQUEST_URI'] ? 'active' : null ?>"
               id="<?= $item->title === 'Contact Us' ? 'menu-contact-link' : null ?>">
                <?php if (isset($item->iconHtml) && $item->iconHtml !== ''): ?>
                    <span class="nav-icon">
                        <?= $item->iconHtml; ?>
                    </span>
                <?php endif; ?>
                <?= $item->title; ?>
                <?php if ((isset($item->children) && count($item->children))): ?>
                    <div class="dropdown-toggle-icon float-right" data-id="<?= $item->ID ?>">
                        <i class="far fa-angle-down" aria-hidden="true"></i>
                    </div>
                    <i class="fas fa-caret-down <?= $depth > 0 ? 'float-right mt-2' : null ?>" v-if="!isMobile"></i>
                <?php endif; ?>
            </a>
            <?php if ($item->title === 'Contact Us'): ?>
                <a class='btn btn-secondary btn-phone ml-2' id="menu-contact-btn"
                   href='/contact' style="margin-top: -10px;">
                    <i class='fa fa-phone' style='font-size: 18px;' aria-hidden='true'></i>&nbsp;<?= $phone ?>
                </a>
            <?php endif; ?>
        </div>
        <?php if (($item->full_width === '_blank' && !wp_is_mobile()) && isset($item->children) && count($item->children)): ?>
            <div class="sub-menu full-width-sub-menu container" v-if="!isMobile"
                 id="sub-menu-<?= $item->ID ?>" data-full="true"
                 data-from="<?= isset($item->from_item) ? $item->from_item : 'false' ?>">
                <div class="row px-4">
                    <?php $depth++; ?>
                    <?php foreach ($item->children as $child) : ?>
                        <div :class="itemColumns(<?= $item->columnSize ?>)" :key="<?= $child->ID ?>">
                            <?php if ($child->object !== 'components') : ?>
                                <h5 class="sub-item-title">
                                    <a href="<?= $child->url; ?>" class="text-primary">
                                        <?php if (isset($child->iconHtml) && $child->iconHtml !== ''): ?>
                                            <?= $child->iconHtml; ?>
                                        <?php endif; ?>
                                        <?= $child->title; ?>
                                    </a>
                                </h5>
                                <?php if (isset($item->children) && count($child->children)): ?>
                                    <div class="row">
                                        <?php
                                        $depth++;
                                        foreach ($child->children as $grandChild) : ?>
                                            <div class="<?= $item->from_item && $item->from_item === '_blank' ?
                                                'col-12' :
                                                'col-4' ?>">
                                                <p class="sub-item-title text-primary mb-0">
                                                    <a href="<?= $grandChild->url; ?>" class="text-primary">
                                                        <?php if (isset($grandChild->iconHtml) && $grandChild->iconHtml !== ''): ?>
                                                            <?= $grandChild->iconHtml; ?>
                                                        <?php endif; ?>
                                                        <?= $grandChild->title; ?>
                                                    </a>
                                                </p>
                                                <?php if (isset($grandChild->children) && count($grandChild->children)): ?>
                                                    <?php
                                                    $depth++;
                                                    foreach ($grandChild->children as $greatGrandChild) {
                                                        set_query_var('depth', $depth);
                                                        set_query_var('item', $greatGrandChild);
                                                        get_template_part('menu/full-width');
                                                    }
                                                endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <div>
                                    <?= $child->post_content; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (($item->full_width !== '_blank' || wp_is_mobile()) && (isset($item->children) && count($item->children))): ?>
            <ul class="sub-menu" id="sub-menu-<?= $item->ID ?>" data-id="<?= $item->ID ?>">
                <?php
                $depth++;
                foreach ($item->children as $child) {
                    if ($child->object !== 'components') {
                        set_query_var('item', $child);
                        set_query_var('depth', $depth);
                        get_template_part('menu/item');
                    }
                }
                ?>
            </ul>
        <?php endif; ?>
    </div>
</li>