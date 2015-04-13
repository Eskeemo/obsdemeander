<!-- create a classic, sticky side-navigation -->
<div class="outerbox">
	<ul class="innerbox side-nav">
		<h4><?php $parent_title = get_the_title($post->post_parent); echo $parent_title; ?></h4>
		<?php eskeemo_sub_nav_excerpt(); ?>
		<?php eskeemo_sub_nav(); ?>
	</ul>
</div>