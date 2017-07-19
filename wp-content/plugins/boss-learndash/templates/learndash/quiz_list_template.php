<?php
$quiz_status = (learndash_is_quiz_notcomplete(get_current_user_id(), array(get_the_ID() => 1 )))? 'notcompleted':'completed';
?>
<div class="quiz ld-item post-<?php the_ID(); ?>">
    <h2>
        <a class="<?php echo $quiz_status; ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
</div>