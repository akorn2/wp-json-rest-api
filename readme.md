
#WP JSON REST API by Alex Rodriguez (@arod2634)
Implements a basic RESTful JSON API for viewing WP Posts via HTTP GET requests to the base "/api/" endpoint. This plugin is written to be highly modular and allow for easy extension. Please feel free to use this code as a boiler plate for your own custom JSON APIs. Most of the error handling has already been written for you ;-)

## API Endpoints
### "/api/blog/listing"
Display all posts
### "/api/blog/detail/?postID=<POST_ID>"
Display all post information for a specifc post
### "/api/page/listing"
Display all pages
### "/api/page/detail/?postID=<POST_ID>"
Display just the page information for a specifc page
##Sample JSON Output
	
	{
	    status: 200,
	    error: null,
	    data: [
			{
				id: 1241,
				title: "Sticky Post",
				content: "This is a sticky post. There are a few things to verify: The sticky post should be distinctly recognizable in some way in comparison to normal posts. You can style the .sticky class if you are using the post_class() function to generate your post classes, which is a best practice. They should show at the very top of the blog index page, even though they could be several posts back chronologically. They should still show up again in their chronologically correct postion in time, but without the sticky indicator. If you have a plugin or widget that lists popular posts or comments, make sure that this sticky post is not always at the top of those lists unless it really is popular. ",					excerpt: "",
				date: "2013-01-07",
				time: "07:07:21",
				featured_image: "<img width="300" height="372" src="http://demo.local/wp-content/uploads/2013/03/featured-image-vertical-300x372.jpg" class="attachment-post-thumbnail wp-post-image" alt="Horizontal Featured Image" />"
			}
	      ]
	}