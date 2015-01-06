
function rsRelatedPosts($count, $sort = "rand"){

	// Check if post has got minimum one catgegory set
	if ( ! $cat = get_the_category() ) {
		return;
	}

	// Get the ID's of the categories
	// use array_reduce to get an array with just the
	// the ids of the categories
	$catIDs = array_reduce($cat,
		function($v, $w) {
			$v[] = $w->term_id;
			return $v;
		}
	);

	/*
	 * Start WP_Query s with the conditions that it has to match
	 * as much categories as possible. In a loop the search is
	 * starts with all categories matching and the one fewer category
	 * is matching and so on until every single categories has been checked
	 * The loop is stopped if $count posts are retrieved
	 *
	 * Another condition is that the given post is not in the list
	 * Last condition is the sort
	 */

	// get the power set of the categories
	$idPowerSet = array(array());
	foreach ($catIDs as $element) {
  		foreach($idPowerSet as $combination) {
  			if(!empty(array_merge(array($element), $combination))){
	    		array_push($idPowerSet, array_merge(array($element), $combination));
	    	}
    	}
	}
	// remove the empty array from the power set
	array_splice($idPowerSet, 0,1);

	// the posts array
	$resultPostArray = array();

	// iterator for the loop
	$i = count($idPowerSet) - 1;

	// init the array of posts which are already in $resultPostArray
	// already filled with id of recent post
	$excludePostIds = array(get_the_ID());

	// start the loop and let it run until $resultPostArray has reached
	// limit or every combinations of the category power set tried
	while (count($resultPostArray) < $count && !empty($idPowerSet)) {

		// the WP_Query
		$query = new WP_Query(
			array(
				'category__and' => $idPowerSet[$i],
				'orderby' => $sort,
				'post__not_in' => $excludePostIds,
				'posts_per_page' => $count
			)
		);

		$posts = $query->get_posts();

		// remove from combination set
		array_splice($idPowerSet, $i, 1);

		// iterator changed
		$i--;

		// Loop the query_posts and add ones which are not already in the
		// $resultPostArray
		foreach ($posts as $post) {
			if (count($resultPostArray) < $count) {
				$resultPostArray[] = $post;
				$excludePostIds[] = $post->ID;
			} else {
				break;
			}
		}

	}

	return $resultPostArray;
}
