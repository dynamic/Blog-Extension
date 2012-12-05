<div id="SideBar">
	
	<div class="SideBarBox">
		<div class="header">Subscribe</div>
	    <div class="box">
	   		<ul>
				<li>
					<a href="{$Link}rss/"><img src="blog/images/feed-icon-14x14.png"></a>
					<a href="{$Link}rss/">Subscribe via RSS</a>
				</li>
			</ul>
	    </div>
	</div>
	
	<% if FeaturedNews %>
	<div class="SideBarBox">
		<div class="header">Featured</div>
	    <div class="box">
			<ul>
	        	<% loop FeaturedNews %>
	        	<li><a href="$Link">$MenuTitle</a></li>
	        	<% end_loop %>
	        </ul>
		</div>
	</div>
	<% end_if %>
	
	<% if TagsList %>
	<div class="SideBarBox">
		<div class="header">Categories</div>
	    <div class="box">
	    	<ul>
	        	<% loop TagsList %>
	            	<li><a href="$Link">$Tag</a> ($Count)</li>
	            <% end_loop %>
	        </ul>
	    </div>
	</div>
	<% end_if %>
	
	<%if NewsArchive %>
	<div class="SideBarBox">
		<div class="header">Categories</div>
	    <div class="box">
	    	<ul>
			<% loop NewsArchive.GroupedBy(MonthCreated) %>
					<% loop Children %>
						<% if First %>
							<li>
								<a href="home/date/{$Date.Format(Y)}/{$Date.Format(m)}">
									$MonthCreated
								</a> 
								({$Children.TotalItems})
							</li>
						<% end_if %>
					<% end_loop %>
			<% end_loop %>
			</ul>
	    </div>
	</div>
	<% end_if %>
	
</div>