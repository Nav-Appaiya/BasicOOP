<?php
/*
Copyright (c) 2013, Jeff Steinport

All rights reserved.

Licensed under the BSD 2-Clause License:
http://opensource.org/licenses/BSD-2-Clause
*/

//Requires tmhOAuth: https://github.com/themattharris/tmhOAuth
include 'tmhOAuth.php';
include 'tmhUtilities.php';

$newurls = array();
$feed = 'http://feeds.feedburner.com/tweakers';
$feed_to_array = (array) new SimpleXmlElement(file_get_contents($feed),LIBXML_NOCDATA);

//array of html entities that php's html_entity_decode doesn't replace
$replacements = array(
    '&ndash;' => '-',
    '&rsquo;' => '\'',
);

//the file we're saving bitly URLs to for a history of posts to avoid duplication of tweets
$filename = "urls.txt";
$urls = json_decode(file_get_contents($filename));
echo "<pre>";
print_r($urls);

foreach($feed_to_array as $feed_to_array['channel']['item']) {
		if ($post2->link){ //make sure we're grabbing a post and not other feed data
			$tag = "";

			foreach($post2->category as $category) { //create an array of the tags assigned to the post
				$tag[] = $category;
			}

			unset($tag[0]); //remove the generic tag that my wordpress site adds to all posts

			//randomly choose two tags to create hashtags
			$arraynum = count($tag);
			$rand = mt_rand(1,$arraynum);
			$rand2 = mt_rand(1,$arraynum);

			$hashtag = "#".str_replace(" ","",$tag[$rand]); //make sure there are no spaces in the hashtag

			//make sure second tag isn't the same as the first
			if ($rand2 = $rand) {
				$rand2++;
				if(!$tag[$rand2]) {
					$hashtag .= " #GENERICHASHTAG"; //if it is the same, just add a generic hashtag
				} else {
					$hashtag2 = str_replace(" ","",$tag[$rand2]);
		                        $hashtag .= " #$hashtag2"; //otherwise append second hashtag to first
				}
			}

			$title = trim(htmlentities($post2->title, ENT_QUOTES, "UTF-8")); //get rid of the UTF-8 oddities from the title
			$title = substr($title,0,20)."... "; //shorten the title to 20 characters
			$shurl = $post2->link; //get the blog post's URL (a feedburner URL)
			$blink = trim(bitly_shorten($shurl)); //turn into a bitly URL
			$chkurl = check_bitly($blink); //see if we've already posted this URL to twitter
			
                        if ($chkurl == 1) {
				echo "exists!<br>"; //if so, move on to next RSS feed entry
			} else {
				$desc = trim(substr(strip_tags($post2->description),0,strpos($post2->description,' ',75)))."..."; //trim the tweet's description after 75 characters to the closest word ending, add elipses
				$tweet = "$title $desc $blink $hashtag"; //compose tweet
				if(strlen($tweet) > 140) {
					$tweet = "$title $desc $blink"; //if the tweet is more than 140 characters, remove the hashtags to shorten it
				}
				$tweet = html_entity_decode($tweet); //remove the html entities
				$tweet = str_replace(array_keys($replacements), $replacements, $tweet); //remove the remaining html entities manually
				tweet($tweet); //tweet it!
				echo "Tweeted: $tweet<br>";
				echo strlen($tweet)."<br>";
			}
		}
	}
}

//write our new array of bitly URLS to file; this will keep a short history of URLS from the feed so that we don't duplicate posts
$fh = fopen($filename,"w+");
print_r($newurls);
$newurls = json_encode($newurls);
fwrite($fh, $newurls);
fclose($fh);

function bitly_shorten($url,$format='txt') {
	$buser = "zzz";
	$bapi = "zzz";

	$connectURL = 'http://api.bit.ly/v3/shorten?login='.$buser.'&apiKey='.$bapi.'&uri='.urlencode($url).'&format='.$format;
	return file_get_contents($connectURL);
}

function check_bitly($url) {
	global $urls;
	global $newurls;
	if (in_array($url, $urls)) {
		$newurls[] .= $url;
		$chkurl = 1;
		return $chkurl;
	} else {
		$newurls[] .= $url;
		$chkurl = 0;
		return $chkurl;
	}
}

function tweet($tweet) {
	//see tmhOAuth documentation
	$tmhOAuth = new tmhOAuth(array(
		'consumer_key' => 'zzz',
		'consumer_secret' => 'zzz',
		'user_token' => 'zzz',
		'user_secret' => 'zzz',
	));

	$response = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update'), array('status' => $tweet));

	if ($code == 200) {
		tmhUtilities::pr(json_decode($tmhOAuth->response['response']));
	} else {
		tmhUtilities::pr($tmhOAuth->response['response']);
	}
}

?>