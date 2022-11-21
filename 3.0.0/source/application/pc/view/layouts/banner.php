<?php if(isset($current_nav['image']['file_path'])): ?>
    <div class="min-banner">
        <img src="<?= $current_nav['image']['file_path']; ?>" alt="">
    </div>
<?php else: ?>
    <div class="min-banner">
        <img src="assets/pc/images/banner2.png" alt="">
    </div>
<?php endif; ?>
