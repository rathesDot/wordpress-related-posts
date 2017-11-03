<?php

/**
 * @param $count
 * @param string $sort
 *
 * @return array
 */
function rsRelatedPosts($count, $sort = 'rand')
{
    // Check if post has got minimum one category set
    if (!$categories = get_the_category()) {
        return [];
    }

    // get an array with just the IDs of the categories
    $categories = array_reduce($categories, function ($v, $w) {
        $v[] = $w->term_id;

        return $v;
    });

    // get the power set of the categories
    $powerSet = [[]];

    foreach ($categories as $id) {
        foreach ($powerSet as $powerSetElement) {
            if (!empty(array_merge([$id], $powerSetElement))) {
                array_push($powerSet, array_merge([$id], $powerSetElement));
            }
        }
    }
    // remove the empty array from the power set
    array_splice($powerSet, 0, 1);

    // the posts array
    $resultPostArray = [];

    // iterator for the loop
    $i = count($powerSet) - 1;

    // init the array of posts which are already in $resultPostArray
    // already filled with id of recent post
    $excludePostIds = [get_the_ID()];

    // start the loop and let it run until $resultPostArray has reached
    // limit or every combinations of the category power set tried
    while (count($resultPostArray) < $count && !empty($powerSet)) {
        // the WP_Query
        $query = new WP_Query([
            'category__and' => $powerSet[$i],
            'orderby' => $sort,
            'post__not_in' => $excludePostIds,
            'posts_per_page' => $count,
        ]);

        $posts = $query->get_posts();

        // remove the combination from power set
        array_splice($powerSet, $i, 1);

        // update iterator
        --$i;

        // Loop the query_posts and add ones which are not already in the
        // $resultPostArray
        foreach ($posts as $post) {
            if (count($resultPostArray) >= $count) {
                break;
            }

            $resultPostArray[] = $post;
            $excludePostIds[] = $post->ID;
        }
    }

    return $resultPostArray;
}
