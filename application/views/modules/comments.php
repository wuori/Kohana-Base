
			<? $cname = ($comment_name) ? $comment_name : 'Comment'; ?>
			<div id="comments">
				<h2 class="sub"><span><a href="#review_form_holder" rel="review_form_holder">Post a <?=$cname;?></a></span> <?=count($comments);?> <?=$cname;?>s</h2>              
				<? if(count($comments)>0 && !isset($show_form_only)){  ?>
            	<ul class="comments">
              	<? foreach($comments as $comment): ?>  
                    <li>
                        <div class="container">
	                        <div>
	                        <? if($comment['social_network_type']=='1'): ?>
	                        	<a class="comment_avatar"><fb:profile-pic uid="<?=$comment['social_network_id'];?>" size="square" facebook-logo="true" linked="true"></fb:profile-pic></a>
	                        <? else: ?>
	                        	<a class="comment_avatar"></a>
	                        <? endif; ?>
	                        <?= text::auto_p(html::specialchars($comment['comment'])); ?>
	                        <?
	                            $name = ($comment['social_network_type']=='1') ?'<a href="http://www.facebook.com/profile.php?id='.$comment['social_network_id'].'" target="_blank">'.$comment['username'].'</a>' : '<span>'.$comment['username'].'</span>';
	                        ?>
	                            <h4>Posted <?=studiobanks::ago(strtotime($comment['posted']));?> by <?=$name;?><small><a href="#" class="flagit" rel="<?=$comment_type.'|'.$comment['ID'];?>">Flag for Review</a></small></h4>
	                        </div>
                        </div>
                    </li>
                <?
                    endforeach;
                ?>
            </ul>
            <? }else{ ?>
            <p class="no_results">No <?=strtolower($cname);?>s have been added yet.</p>
            <? }; ?> 
			<div id="review_form_holder" class="form">
				<h4>Post a Comment:</h4>
				<div class="opener"></div>
				<form name="form" class="review_form" action="#" id="review_form">
					<div class="row">
					<div class="floated" id="fbauthor" rel="<?=Kohana::config('oot.facebook_api_key');?>">
						<div class="row fancy">
							<label for="name">Name*</label>		
							<input name="name" type="textbox" class="textbox" id="name" />
						</div>    
						<div class="row fancy">
							<label for="email">Email*</label>		
							<input name="email" type="textbox" class="textbox" id="email" />
						</div>  
					</div>
					<div class="floated" id="fbconnect">
						<small>Enter your Name and Email to the left, or sign-in using your Facebook account:</small>
						<a href="#" id="fbloginimage" onclick="FB.Connect.requireSession(authUser); return false;" ><img id="fb_login_image" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_large_long.gif" alt="Connect"/></a>
					</div>
					</div>
					<div class="row">
						<textarea class="textarea limit" rel="500" cols="40" rows="5" name="comment" id="comment" /></textarea>
					</div>
					<div class="row">
						<a href="#" class="btn fs"><span>Submit</span></a>
					</div>
					<input type="hidden" name="val" id="val" value="<?=$comment_item_id;?>" />
					<input type="hidden" name="type" id="type" value="<?=$comment_type;?>" />
				</form>
				<div class="closer"></div>
			</div>
        </div>
        <script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>  
        