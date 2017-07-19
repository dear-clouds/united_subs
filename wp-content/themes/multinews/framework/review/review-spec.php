<?php
$review_mb = new MomizatMB_MetaBox(array
(
    'id' => 'mom_reviews_meta',
    'title' => __('Review', 'framework'),
    'template' => MOM_FW . '/review/review-metaboxes.php',
    'mode' => MOMIZATMB_MODE_EXTRACT,
    'prefix' => '_mom_',
    'types' => array('post'),
));