	<div id="content" class="blog">
		
		<!-- Begin Left Column -->
		<div class="left">
			<h2><span><a href="/blog/feed" class="rss_rt">RSS Feed</a></span>Only in Old Town Blog: <?=$sub_title;?></h2>
			<!-- Begin Blog Posts -->
			<? if(count($posts)): ?>
			<? 
				$i=0;
				foreach($posts as $row): 
					// Init Blog Post Data
					$post_link = '/blog/post/'.$row->post_ID.'/'.studiobanks::slug($row->title);
					$author_link = '/blog/author/'.$row->contributor.'/'.studiobanks::slug($row->author_name);
					$iamge_folder = ($i>0 || $only_small_images) ? 'thumbs/' : '';
					$image_src = Kohana::config('oot.content_path').'blog/'.$iamge_folder.$row->ID.'.jpg';
					$image_size_class = ($i>0 || $only_small_images) ? 'small' : 'big';
					$image_orit_class = ($row->orientation=='width') ? '' : ' tall';
					$body = $row->body.PHP_EOL.PHP_EOL.$row->body_extended;
			?>
			<div class="post">
				<h3><a href="<?=$post_link;?>"><?=$row->title;?></a></h3>
				<small class="byline">Posted <?=date('F jS, Y',strtotime($row->posted));?> by <a href="<?=$author_link;?>"><?=$row->author_name;?></a></small>
				<? if($row->image=='1'): ?><a href="<?=$post_link;?>"><img class="<?=$image_size_class.$image_orit_class;?>" src="<?=$image_src;?>" alt="<?=$row->title;?>" /></a><? endif; ?>
				<? if(count($images)): ?>
					<div class="extra_images" id="gallery">
					<? 
						// Build images for gallery
						$p=0;
						foreach($images as $i):
					?>
							<a rel="facebox" title="<?=$i->caption;?>" href="<?=Kohana::config('oot.content_path').'blog/extras/'.$i->ID.'.jpg';?>" class="<?=($p>0)?'hidden':'';?>">
								<img src="<?=Kohana::config('oot.content_path').'blog/extras/thumbs/'.$i->ID.'.jpg';?>" alt="<?=$i->caption;?>" />
								<? if($p==0){ ?><small>View More Photos</small><? }; ?>
							</a>
					<? 
						$p++;
						endforeach; 
					?>
					</div>
				<? endif; // count(images) ?>
				<? echo text::auto_p($body); ?>
				<ul>
					<li>Filed Under: <a href="/blog/category/<?=$row->category;?>/<?=studiobanks::slug($row->cat_name);?>"><?=$row->cat_name;?></a></li>
                    <li class="rt"><a href="<?=$post_link;?>#review_form_holder">Post a Comment</a></li>
                    <li class="rt"><a class="comments" href="<?=$post_link;?>#comments" class="comment_count"><?=$row->comment_count;?> Comments</a></li>
				</ul>
			</div>
			<? 
				$i++;
				endforeach; //foreach(post) 
			?>
			<? endif; //count(posts) ?>
			<?=$related_events;?>
			<?=$related_locations;?>
			<?=$comments_section; ?>
		</div>
		<!-- End Left Column -->
		<!-- Begin Right Column -->
		<div class="right">
			<?=$sidebar;?>
		</div>
		<!-- End Right Column -->
	</div>