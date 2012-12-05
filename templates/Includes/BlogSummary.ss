<div class="blogSummary">
	<h4 class="postTitle"><a href="$Link" title="<% _t('VIEWFULL', 'View full post titled -') %> '$Title'">$MenuTitle</a></h4>
	<p class="authorDate">Posted <% if Author %>by $Author.XML <% end_if %><% _t('POSTEDON', 'on') %> $Date.NiceUS <!--| <a href="$Link#PageComments_holder" title="View Comments Posted">$Comments.Count <% _t('COMMENTS', 'Comments') %></a>--></p>
	
	
	<% if BlogHolder.ShowFullEntry %>
		$Content
	<% else %> 
		<p>
			<% if Image %><img src="$Image.CroppedImage(80,80).URL" class="left"><% end_if %>
			$Content.FirstParagraph(text)
		</p>
	<% end_if %>
	
	<p class="blogVitals"><!--<a href="$Link#PageComments_holder" class="comments" title="View Comments for this post">$Comments.Count comments</a> |--> <a href="$Link" class="readmore" title="Read Full Post">Read the full post</a></p>
	
	<% if TagsCollection %>
		<p class="tags">
			Tags:
			<% loop TagsCollection %>
				<a href="$Link" title="View all posts tagged '$Tag'" rel="tag">$Tag</a><% if not Last %>,<% end_if %>
			<% end_loop %>
		</p>
	<% end_if %>
	
</div>
