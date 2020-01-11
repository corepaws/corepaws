<?php
$sblk = get_field('show_blocks');
global $logo;
if (!isset($logo)) {
    $logo = get_field('logo', 'option');
}
if (is_array($sblk) && in_array('tes', $sblk)) : testimonials_block(); endif;
if (is_array($sblk) && in_array('buc', $sblk)) : two_buckets(); endif;
if (is_array($sblk) && in_array('pel', $sblk)) : pet_line(); endif;
?>
</main>

<footer>
    <div class="center-col">
        <div id="footer-left">
            <!-- Footer left logo -->
            <?php if ($logo) : ?>

                <a href="<?php echo URL; ?>" id="footer-logo">
                    <img alt="<?php echo get_bloginfo('title'); ?>" src="<?php echo $logo['sizes']['thumbnail']; ?>"/>
                </a>
            <?php else : ?>
                <h1 id="footer-title">
                    <?php echo get_bloginfo('title'); ?>
                </h1>
            <?php endif; ?>
            <!-- Footer left content -->
        </div>
        <div id="footer-center">
            <!-- Footer middle content -->

            <!-- Footer copyright -->
            <p class="copyright">&copy; <?php echo date('Y') . ' ' . get_bloginfo('title'); ?>. All rights reserved.</p>
        </div>
        <div id="footer-right">
            <!-- Footer right content -->
            <?php soclinks(); ?>
        </div>
        <div id="tablet-footer">
            <!-- Footer tablet content -->
        </div>
    </div>
</footer>

<script>
    var url = '<?php echo URL; ?>';
    var theme = '<?php echo THEME; ?>';
</script>
<?php wp_footer(); ?>

<div id="videobox" class="video-lightbox"></div>

</body>
</html>