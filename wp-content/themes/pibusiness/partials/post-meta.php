<?php
$id = uniqid();
$available = isset($authorMeta) && isset($authorMeta['is_author_available']) ? (boolean)$authorMeta['is_author_available'][0] : true;
?>
<div class="blog-meta px-4">
    <div class="row">
        <div class="col-xl-6">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <div class="row">
                        <?php if (isset($avatarUrl) && isset($authorMeta) && !empty($avatarUrl)) : ?>
                            <div class="col-2 px-0">
                                <div class="author-avatar">
                                    <?php if ($available): ?>
                                        <a href="<?= isset($authorPageUrl) ? $authorPageUrl : null ?>">
                                            <img src="<?= $avatarUrl ?>"
                                                 alt="<?= $authorMeta['first_name'] . ' ' . $authorMeta['last_name'] ?>"
                                                 class="img img-fluid rounded-circle">
                                        </a>
                                    <?php else: ?>
                                        <img src="<?= $avatarUrl ?>"
                                             alt="<?= $authorMeta['first_name'] . ' ' . $authorMeta['last_name'] ?>"
                                             class="img img-fluid rounded-circle">
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="col-10">
                            <?php if (isset($authorMeta) && isset($authorMeta['first_name'][0])) : ?>
                                <div class="blog-author">
                                    <?php if ($available): ?>
                                        <a href="<?= isset($authorPageUrl) ? $authorPageUrl : null ?>"
                                           class="text-white">
                                            <?= $authorMeta['first_name'][0] ?> <?= $authorMeta['last_name'][0] ?>
                                        </a>
                                    <?php else: ?>
                                        <?= $authorMeta['first_name'][0] ?> <?= $authorMeta['last_name'][0] ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="meta-description text-white">
                                <div class="post-date">
                                    <?php the_date() ?>
                                </div>
                                <div class="reading-time">
                                    <?= get_field('reading_time') ? get_field('reading_time') . ' min read' : null ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="author-social-media text-white">
                        <div class='social-media-<?= $id ?> social-media' data-id='<?= $id ?>'>
                            <social-sharing url="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>"
                                            inline-template>
                                <div>
                                    <span style="vertical-align: top;">Share</span>
                                    <network network="facebook" class="ml-2">
                                        <i class="fab fa-facebook-square fa-2x mr-2 social-media-icon"></i>
                                    </network>
                                    <network network="linkedin">
                                        <i class="fab fa-linkedin fa-2x mr-2 social-media-icon"></i>
                                    </network>
                                    <network network="twitter">
                                        <i class="fab fa-twitter-square fa-2x social-media-icon"></i>
                                    </network>
                                </div>
                            </social-sharing>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
