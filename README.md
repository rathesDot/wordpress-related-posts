Wordpress-RelatedPosts
======================

A simple script to show related posts in a wordpress theme. No plugin, just a function.

- URL to Post: http://web-und-die-welt.de/2015/01/wordpress-aehnliches-beitraege-anzeigen-ohne-plugin/

##Install & Configuration
To use this function just copy and paste the code from functions.php into the functions.php file of your theme. That's all.
## Usage
Within the loop just call the function `rsRelatedPosts($count, $sort)` where `$count` is the number of related posts you want to have and `$sort` is how the post should be selected. `$sort` has to be one of the orderby-parameters of WP_Query (See Wordpress Codex: http://codex.wordpress.org/Class_Reference/WP_Query)
