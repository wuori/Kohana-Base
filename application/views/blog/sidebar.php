			<? if(count($categories)): ?>
			<!-- View by Category -->
			<h4 id="cats_tab">View by Category</h4>
			<script type="text/javascript">
				swfobject.embedSWF("/public/assets/swf/tab.swf", "cats_tab", "280", "50", "9.0.0","/public/assets/swf/expressinstall.swf", {this_color:"d60c8c",this_title:"View by Category"}, {wmode:"transparent", menu:"false"});
			</script>
			<ul class="post_listing sans">
			<? foreach($categories as $cat): ?>
				<li>
					<h4><a href="/blog/category/<?=$cat['ID'];?>/<?=url::title($cat['name']);?>"><?=$cat['name'];?> <sup>(<?=$cat['post_count'];?>)</sup></a></h4>
				</li>
			<? endforeach; ?>
			</ul>
			<? endif; // count(cats) ?>

			<? if(count($months)): ?> 			
			<!-- View by Archive -->
			<h4 id="archive_tab">Archive</h4>
			<script type="text/javascript">
				swfobject.embedSWF("/public/assets/swf/tab.swf", "archive_tab", "280", "50", "9.0.0","/public/assets/swf/expressinstall.swf", {this_color:"ffc425",this_title:"Archive"}, {wmode:"transparent", menu:"false"});
			</script>
			<select name="months" class="gogogo" rel="/blog/archive/">
				<option>Browse by month...</option>
			<?	foreach($months as $month): ?>
				<option value="<?=date('m',strtotime($month['posted'])) ?>/<?=date('Y',strtotime($month['posted']))?>"><?=date('F Y',strtotime($month['posted'])) ?> (<?=$month['total_posts'] ?> posts)</option>
			<? endforeach; ?>
			</select>
			<? endif; ?>
			
			<? if(count($flickr_photos)): ?>
			<!-- Flickr Photos -->
			<h4 id="flickr_tab">Photo Gallery</h4>
			<script type="text/javascript">
				swfobject.embedSWF("/public/assets/swf/tab.swf", "flickr_tab", "280", "50", "9.0.0","/public/assets/swf/expressinstall.swf", {this_color:"c2cd23",this_title:"Photo Gallery"}, {wmode:"transparent", menu:"false"});
			</script>
			<ul class="flickr_sets">
			<? 
				foreach($flickr_photos as $photo):
					$src = 'http://farm'.$photo['farm'].'.static.flickr.com/'.$photo['server'].'/'.$photo['primary'].'_'.$photo['secret'].'_s.jpg';
					$link = '/out/to/?u=http://www.flickr.com/photos/onlyinoldtown/sets/' . $photo['id'] . '/';
			?>
				<li><a href="<?=$link;?>"><img src="<?=$src;?>" /></a><span><a href="<?=$link;?>"><?=$photo['title'];?></p><small><?=$photo['photos'];?> photos</small></span></a></li>
			<? endforeach; ?>			
			</ul>			
			<? endif; ?>
