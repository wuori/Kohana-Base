	<div id="content" class="blog">
		
		<!-- Begin Left Column -->
		<div class="left">
			<h2><span><a href="/blog/feed" class="rss_rt">RSS Feed</a></span>Only in Old Town Blog: <?=$sub_title;?></h2>
			<!-- Begin Blog Posts -->
			<? if(count($posts)): ?>
			<? 
				$i=0;
				foreach($posts as $row): 
					$post_link = '/blog/post/'.$row->post_ID.'/'.url::title($row->title);
					$author_link = '/blog/author/'.$row->contributor.'/'.url::title($row->author_name);
					$iamge_folder = ($i>0 || $only_small_images) ? 'thumbs/' : '';
					$image_src = Kohana::config('oot.content_path').'blog/'.$iamge_folder.$row->ID.'.jpg';
					$image_size_class = ($i>0 || $only_small_images) ? 'small' : 'big';
					$image_orit_class = ($row->orientation=='width') ? '' : ' tall';
					$body = $row->body;
			?>
			<div class="post">
				<h3><a href="<?=$post_link;?>"><?=$row->title;?></a></h3>
				<small class="byline">Posted <?=date('F jS, Y',strtotime($row->posted));?> by <a href="<?=$author_link;?>"><?=$row->author_name;?></a></small>
				<? if($row->image=='1'): ?><a href="<?=$post_link;?>"><img class="<?=$image_size_class.$image_orit_class;?>" src="<?=$image_src;?>" alt="<?=$row->title;?>" /></a><? endif; ?>
				<? foreach(studiobanks::split_paragraphs($body) as $p): ?>
				<p><?=$p;?></p>
				<? endforeach; ?>
				<ul>
					<li>Filed Under: <a href="/blog/category/<?=$row->category;?>/<?=url::title($row->cat_name);?>"><?=$row->cat_name;?></a></li>
                    <li class="rt"><a href="<?=$post_link;?>#review_form_holder">Post a Comment</a></li>
                    <li class="rt"><a class="comments" href="<?=$post_link;?>#comments" class="comment_count"><?=$row->comment_count;?> Comments</a></li>
				</ul>
			</div>
			<? 
				$i++;
				endforeach; //foreach(post) 
			?>
        	<ul class="pagination">
        		<?=$pagination;?>
        	</ul>
			<? endif; //count(features) ?>
			
		
		</div>
		<!-- End Left Column -->
		<!-- Begin Right Column -->
		<div class="right">
			<?=$sidebar;?>
		</div>
		<!-- End Right Column -->
	</div>