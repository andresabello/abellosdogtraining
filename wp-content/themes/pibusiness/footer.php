<footer class="footer bg-dark text-white">
    <div class="lower-footer py-2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <p class="text-white m-0">
                        &copy; <?php bloginfo('name'); ?>, <?= date('Y'); ?>. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

</div>
<script type="text/javascript">
    var clickTos = document.querySelectorAll('.click-to');
    for (var click of clickTos) {
        var el = document.getElementById(click.dataset.id)

        click.addEventListener("click", function (evt) {
            window.scroll({
                top: el.getBoundingClientRect().top + window.scrollY,
                behavior: 'smooth'
            });
        });
    }
</script>
<?php wp_footer(); ?>
</body>
</html>