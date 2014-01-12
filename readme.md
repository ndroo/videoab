Video-AB
Video AB works much like a YouTube embed, however it has the added benefit of allowing you to use a single Embed URL to AB test various videos to determine which results in higher engagement.

Intended usage:
1 Create an embed
2 Add at least two videos to the embed (if there is 1, you're not doing much of an AB test)
3 Get the Embed URL and insert it on the website you want the video to show
4 If your website has some expected outcome (such as a signup or purchase), when the user completes that action, do an ajax call to the Success URL that is associated with that Embed. This will ensure you close the loop on which video encourages the greater majority of your desired outcome.

Future Enhancements / todo:
* There is currently no caching. At least the we should cache the details of the Embed and its associated videos so popular videos result in high ReadDB CPU / IO
* Currently each Play or Success event results in a single write to the DB, this will not scale. I would like to revise this such that views get inserted into a Redis queue, which are then extracted in bulk and bulk inserted. This will have its own scaling issues, but should perform significantly better.
* Stats should be periodically summarized and display functions should extract the results from the summarized versions rather than calculating them from the raw stats on each page load.
* Style the admin UI
* There is currently no security preventing users from modifying or viewing each others Embeds or Videos
