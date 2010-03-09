<?

class Blog_model extends Model {

    
	function __construct()
    {
        // Call the Model constructor
		parent::__construct();
    }
    
    function get_total($qualifiers=false,$values=false)
    {
		$query_qualifiers = '';
		if(is_array($qualifiers)):
			for($i=0;$i<count($qualifiers);$i++):
				$query_qualifiers .= $qualifiers[$i]." = '".$values[$i]."' AND "; 
			endfor;
		endif;
		$query = $this->db->query("SELECT COUNT(ID) as total FROM tbox_blog WHERE ".$query_qualifiers." tbox_blog.active='1' ");
        $row = $query->result_array(FALSE);
    	return $row[0]['total'];
    }
    
    function get_posts($limit=20,$offset=0,$qualifiers=false,$values=false,$override=false)
    {
		
		$query_qualifiers='';
		if(is_array($qualifiers)):
			for($i=0;$i<count($qualifiers);$i++):
				$query_qualifiers .= $qualifiers[$i]." = '".$values[$i]."' AND "; 
			endfor;
		endif;
		$active = '';
		if(!$override) $active = "AND tbox_blog.active='1'";
		
		$query = "
			SELECT 
				tbox_blog.ID as post_ID, COUNT(tbox_blog_comments.ID) as comment_count, tbox_blog.*, tbox_blog_categories.name as cat_name, tbox_blog_contributors.name as author_name
			FROM
				tbox_blog
			LEFT JOIN
				tbox_blog_categories ON tbox_blog_categories.ID = tbox_blog.category 
			LEFT JOIN
				tbox_blog_contributors ON tbox_blog_contributors.ID = tbox_blog.contributor
			LEFT JOIN
				tbox_blog_comments ON tbox_blog_comments.item = tbox_blog.ID
			WHERE
				".$query_qualifiers." 1=1 {$active} 
			GROUP BY
				tbox_blog.ID
			ORDER BY 
				tbox_blog.posted DESC
			LIMIT {$offset},{$limit}
		";
		$query = $this->db->query($query);
        return $query->result_array();
    }
	
    function get_comments($limit=20,$offset=0,$table=false,$item_id=false)
    {
		$query = "
			SELECT 
				{$table}.*, tbox_users.username, tbox_users.social_network_id as social_network_id, 'facebook' as social_network_type
			FROM
				{$table}
			LEFT JOIN
				tbox_users ON tbox_users.ID = {$table}.user
			WHERE 
				{$table}.item = '{$item_id}'
			ORDER BY 
				{$table}.posted DESC
			LIMIT {$offset},{$limit}
		";
		$query = $this->db->query($query);
        return $query->result_array(FALSE);
    }
	
	function get_post_images($post_ID=false)
	{
		$query = "SELECT * FROM tbox_blog_images WHERE blog = '".$post_ID."' ORDER BY sort_order ASC";
		$query = $this->db->query($query);
        return $query->result_array();
	}
	
	function get_months()
	{
		$query = "
			SELECT 
				posted, COUNT(ID) as total_posts 
			FROM 
				tbox_blog
			WHERE
				active='1'
			GROUP BY
				MONTH(posted)
			ORDER BY 
				posted DESC			
		";
		$query = $this->db->query($query);
        return $query->result_array(FALSE);
	}
	
    function get_categories()
    {
		$query = "
			SELECT 
				tbox_blog_categories.ID, tbox_blog_categories.name, COUNT(tbox_blog.ID) as post_count
			FROM
				tbox_blog
			LEFT JOIN
				tbox_blog_categories ON tbox_blog_categories.ID = tbox_blog.category 
			WHERE
				active='1'
			GROUP BY
				tbox_blog_categories.name
			ORDER BY 
				tbox_blog_categories.name			
		";
		$query = $this->db->query($query);
        return $query->result_array(FALSE);
    }
	
    function get_blog_roll()
    {
		$area = ($this->current_area===0) ? '' : "WHERE metacity = '".$this->current_area."' OR metacity = '0'";
		
		$query = $this->db->query("
			SELECT 
				*
			FROM
				tbox_blog_roll
			".$area."
			ORDER BY 
				sort_order			
		");
        return $query->result_array();
    }
	
	function get_contributors($qualifiers=false,$values=false)
	{
		
		if(is_array($qualifiers)):
			for($i=0;$i<count($qualifiers);$i++):
				$query_qualifiers .= $qualifiers[$i]." = '".$values[$i]."' AND "; 
			endfor;
		endif;
		
		$query = $this->db->query("
			SELECT 
				tbox_blog_contributors.ID, signature, tbox_team.ID as team_ID, CONCAT(first_name,' ',last_name) as contributor_name, tbox_team.image, tbox_team_positions.name as pos_name, tbox_team_companies.name as co_name, COUNT(tbox_blog.ID) as post_count
			FROM
				tbox_blog
			LEFT JOIN
				tbox_blog_contributors ON tbox_blog_contributors.ID = tbox_blog.contributor 
			LEFT JOIN
				tbox_team ON tbox_team.ID = tbox_blog_contributors.team_member
			LEFT JOIN
				tbox_team_positions on tbox_team_positions.ID = tbox_team.position
			LEFT JOIN
				tbox_team_companies on tbox_team_companies.ID = tbox_team.company
			WHERE
				".$query_qualifiers." tbox_blog.active='1'
			GROUP BY
				tbox_blog_contributors.ID
			ORDER BY 
				post_count DESC			
		");
		
        return $query->result_array();
	}
	
    function get_related_locations($ID='')
    {
   		$query = $this->db->query("
			SELECT 
				tbox_locations.ID, tbox_locations.category, tbox_locations.name
			FROM
				tbox_blog_locations
			LEFT JOIN
				tbox_locations ON tbox_locations.ID = tbox_blog_locations.location
			WHERE
				tbox_blog_locations.blog='".$ID."' AND tbox_locations.active='1'
			ORDER BY 
				tbox_locations.name
		");
        	return $query->result_array();
    }
	
    function get_related_events($ID,$limit=4)
    {
		
		$query = "
			SELECT 
				tbox_events.ID, tbox_events.name, tbox_events.starts			
			FROM
				tbox_blog_events
			LEFT JOIN
				tbox_events ON tbox_events.ID = tbox_blog_events.event
			WHERE
				tbox_blog_events.blog = '".$ID."' AND tbox_events.starts >= NOW()
			ORDER BY 
				tbox_events.starts ASC
			LIMIT ".$limit."
		";

		$query = $this->db->query($query);
        return $query->result_array();
    }
	
}

?>