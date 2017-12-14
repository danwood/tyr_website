# tyr_website
Website for Tomorrow Youth Repertory



On the deployed website whenever we update the database, it rebuilds the cached .html files from the .php files so that the pages are served statically.  Maybe not such a big deal for a low-volume website but it's kind of cool that way.


Fields to add:

ParentEventID INTEGER
SimilarEventID INTEGER
SimilarImageFilename TEXT
SimilarImageSourceURL TEXT
SimilarImageAttribution TEXT
Season	INTEGER


I can have an additional $type that is:
	combination audition show + ensemble camp
	Show Series (for grouping; goes away after auditions)



	Maybe I don't need any linkage between show series and shows.  Just announce them after the auditions are over? or just don't give audition details.  But I'll set it anyhow.



Quarter = 1 winter, 2 spring, 3 summer, 4 fall.  That is for when the show is in later-this-year state.