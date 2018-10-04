<div class="row-page">
    <div class="shop-left-profile">
        <h3>
            <i class="fa  fa-bars" aria-hidden="true"></i>
            <strong>
                <?php echo 'Category'; ?>
            </strong>
        </h3>
        <ul class="list-unstyled">
            <?php foreach($categories as $category) { ?>
            <a href="<?php echo $category['href']; ?>">
                <li>
                    <?php echo $category['name']; ?>
                </li>
            </a>
            <?php } ?>
        </ul>
    </div>
</div>