Related Posts by Category for WordPress
======================

In the `functions.php` you will find a function that returns an array of related posts of the currenty post. It uses the categories of the current post to collect all posts that have the as much same categories set as possible.

> Note: This German [blog post](http://web-und-die-welt.de/2015/01/wordpress-aehnliches-beitraege-anzeigen-ohne-plugin/) explains how the idea was born.

> Another note: I'm not working with Wordpress anymore so I won't develop this function further. But if you spot any mistakes, feel free fix it and send a PR.

## Installation

This is just a function and does not need any installation. Just copy and paste this function into your theme's `functions.php` file.

## Usage

Within the loop call the function `rsRelatedPosts($count, $sort)` where `$count` is the amount of related posts you want to have and `$sort` is how the post should be selected.

`$sort` has to be one of the orderby-parameters of WP_Query (See [Wordpress Codex](http://codex.wordpress.org/Class_Reference/WP_Query))