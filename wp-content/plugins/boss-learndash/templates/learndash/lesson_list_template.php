<?php
/* Lesson Topis */
$topics = @$lesson_topics[get_the_ID()];                            
$in_progress = false;
if(!empty($topics)) {
    foreach ($topics as $key => $topic) { 
        if(!empty($topic->completed)) $in_progress = true;
    }
}
$lesson_completed = !learndash_is_lesson_notcomplete(get_current_user_id(), array(get_the_ID() => 1 ));
$lesson_status = ($lesson_completed)?'completed':'notcompleted';
?>
<div class="lesson ld-item post-<?php the_ID(); ?> <?php echo (empty($topics))?'no-topics':'has-topics' ?>">
    <h2>
        <a class="<?php echo ($in_progress && $lesson_status == 'notcompleted')?'in-progress':$lesson_status; ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h2>
</div>
