<?php

$posts_st = new MomizatMB_MetaBox(array
(
    'id' => 'mom_posts_extra',
    'title' => __('Posts Extra', 'framework'),
    'template' => MOM_FW . '/metaboxes/momizat-class/posts-st.php',
    'types' => array('post')
)
);