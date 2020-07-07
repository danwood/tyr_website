<?php
require_once('_functions.php');
require_once('_classes.php');
require_once('_globals.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
$base='';
$root='';
$title='Tomorrow Youth Rep Staff';
$description='Read about the staff behind the scenes at Tomorrow Youth Repertory';
include('_head.php');
?>
	<style>

.bio { font-size:80%; }

figure { position:relative; }
figcaption { font-size:60%; }
.thumbnail {
	width:76px;
	}

.person {
	font-variant:small-caps;
	font-weight:bold;
}
.title {
	font-style:italic;
	color:gray;
}

@media only screen and (min-width:36em)
{
	.rotated { width:100%; position:absolute; padding:2px 0; text-align:left; bottom:0; left:100%; -webkit-transform: rotate(-90deg); -webkit-transform-origin:1% 0%;}
}
@media only screen and (min-width:48em)
{
	.bio { width:33.33%; }
	.row { clear:left; }
}

	</style>
</head>
<body id="page-staff" class="orange-block">
	<div class="clearfix outside-sticky-footer">
		<!-- Specify grid system. All boxes must be clearfix. Specify layout direction. -->
		<div class="contain-sticky-footer fullwidth">
			<div class="clearfix">
				<!-- Nested groups of boxes inside; must outdent boxes since they indent for gutters -->
				<div class="before-sticky-footer">

<?php
$fullHeader = FALSE;
include('_header.php'); ?>
					<main>
						<section id="staff" class="clearfix capped-width">
							<div class="inlinebox">
								<h2>Tomorrow Youth Rep Staff</h2>


								<div class="clearfix outdented">
									<div class="inlinebox bio">
										<p class="desc"><img alt="Tyler Null" class="thumbnail floated-tight" src="img/staff-tyler.jpg" /><span class="person">Tyler Null</span> <span class="title">(Executive Director / Instructor)</span> has been teaching theater since 2010. Tyler’s own journey into theater and performing arts began in childhood after-school programs, and he is grateful and excited to be able to pass this along. Tyler has been on all sides of the theater world, serving at various times as an actor, a producer, a director, a writer, a designer, a stage manager, a puppeteer, a scenic builder, a lighting technician, and pretty much everything except for a marketer (which is why he is so especially grateful that he knows other people that are good at that particular field). A firm believer in the value of teamwork and community, Tyler seeks to instill in TYR an appreciation for the all of the contributors that come together to make a single experience on the stage.
										</p>
										<p>
											When not working with the next generation, Tyler still actively moonlights as an actor, as a musician, and as a writer. He can also be found dabbling in the stand-up comedy world from time-to-time. His personal favorite credits include his Voter’s Bloc Theater piece Spencer Blackhart for Mayor and the film Refinery Surveyor Black. He also for obvious reasons has a particularly soft spots for Snow White, Little Red Cries Wolf, Robin & Marian, and Sherlock Holmes and the Mystery of the Missing Mystery, which were written for and performed by TYR.

										</p>
										<p  class="desc">When not working with the next generation, Tyler still actively moonlights as an actor, as a musician, and as a writer. He can also be found dabbling in the stand-up comedy world from time-to-time. His personal favorite credits include his Voter’s Bloc Theater piece <i>Spencer Blackhart for Mayor</i> and the film <i>Refinery Surveyor Black</i>. He also for obvious reasons has a particularly soft spot for <i>Snow White</i> and for <i>Sherlock Holmes and the Mystery of the Missing Mystery</i>, which were developed for and performed by TYR.</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><img alt="Jordan Best" class="thumbnail floated-tight" src="img/staff-jordan.jpg" /><span class="person">Jordan Best</span> <span class="title">(Development Director / Instructor)</span> has a Master of Music Degree in Vocal Performance from CCM in Cincinnati, one of the country's top music conservatories, and a Bachelor of Music Degree, also in Vocal Performance, from DePaul University in Chicago, IL.  She has performed extensively in opera and musical theater throughout the Bay Area and US as well as in France and Italy. Ms. Best has a background in ballet, tap, Stanislavsky and Meisner method acting training and has performed in numerous concerts, recitals and benefits.  She has taught privately since 2006 and has a private vocal studio which includes both children and adults. She has worked as a voice teacher, musical director, music teacher and choreographer throughout the Bay Area since 2007 and is currently co-producer of 142 Throckmorton Theater's <i>Little Throck</i> Program and director of their high school Accapella group <i>Throckapella</i>.</p>

										<p class="desc"><img alt="Mallory Penney" class="thumbnail floated-tight" src="img/staff-mallory.jpg" /><span class="person">Mallory Penney</span> <span class="title">(Program Coordinator / Instructor)</span> has been involved in theater since she was six years old and has never looked back. From acting to stage managing to directing, Mallory has always felt at home working with young actors exploring the wonders theater can offer us. While attending school, Mallory founded and ran a theater program at Earhart Elementary school in Alameda. She is a graduate of UC Berkeley with a degree in Theater and Performance Studies. Mallory currently works as a teaching artist with companies such as Berkeley Repertory School of Theatre and Throckmorton Theatre. 
										</p>
									</div>

									<div class="inlinebox bio">



										<p class="desc"><img alt="Cienna Johnson" class="thumbnail floated-tight" src="img/staff-cienna.jpg" /><span class="person">Cienna Johnson</span> <span class="title">(Instructor)</span> graduated from San Diego State University in 2018 with a BA in Theatre Performance and a minor in Communications.  Cienna has been involved with TYR since she was 13 and has loved seeing the program flourish.  Recent credits with TYR include The Addams Family, Les Miserables, Beauty and the Beast, Little Red Cries Wolf, Little Shop of Horrors, Alice in Wonderland, and Hamlet.  Cienna is always looking forward to sharing the experience of storytelling with creative, young artists.</p>

									</div>

									<div class="inlinebox bio">
										<p class="desc"><img alt="Rob Cheifetz" class="thumbnail floated-tight" src="img/staff-rob.jpg" /><span class="person">Rob Cheifetz</span> <span class="title">(Instructor)</span> has been a director with TYR since our wild productions of Narnia and Les Misérables in Summer 2013.  A Bay Area native, Rob teaches voice and woodwinds as a private instructor and substitute teaches in public schools.  He graduated from UC Berkeley with a bachelor's degree in music composition and performance.  During his time at Cal he was mentored by Marika Kuzma in vocal ensemble conducting and by Myra Melford in a wide range of approaches to ensemble improvisation.  He has performed in pit bands for tons of musicals at numerous Bay Area stages.  Rob has an extensive history of touring bands, including afrobeat ensemble Lagos Roots, funk-pop-party crew Wallpaper with the prodigious Ricky Reed, and the local rock band Add Moss.  Over the last 7 years, the now-defunct Foundry in West Berkeley hosted Rob as a resident artist where he wrote, directed, and produced his own improvisational musical (or "improvsical") and a variety of other performance art pieces.   Rob is absolutely jazzed to be a part of this wonderful TYR community.
										</p>
									</div>


									<div class="inlinebox bio row">
										<p class="desc"><img alt="Leah Gardner" class="thumbnail floated-tight" src="img/staff-leah.jpg" /><span class="person">Leah Gardner</span> <span class="title">(Instructor)</span> is thrilled to be a part of the teaching team for Tomorrow Youth Repertory. Previous credits with TYR include <i>Little Mermaid</i>, <i>Honk</i>, <i>Addams Family Musical</i>, <i>Midsummer Night’s Dream</i>, <i>Snow White</i>, <i>Rumors</i>, <i>Willy Wonka and the Chocolate Factory</i>, <i>Hansel and Gretel</i>, <i>Aladdin</i>, <i>Into the Woods</i>, <i>Cinderella</i>, <i>Seussical</i>, <i>High School Musical</i>, <i>Alice in Wonderland</i> and <i>Wizard of Oz</i>. In addition to TYR, Leah is a physical comedy and circus skills instructor for Oakland based Circus of Smiles. An undeniable clown, Leah has circled the globe performing with the internationally renowned physical comedy troupe, Pi. Leah is currently the director in residence for an immersive show called The Speakeasy SF. Leah has worked professionally as a director, stage manager and house manager with companies including: The 5th Avenue Musical Theatre, Boxcar Theatre, Teatro ZinZanni, Shakespeare Santa Cruz, Cal Shakes, The Mark Taper Forum, BrickaBrack, 42nd Street Moon, Cabrillo Stage and The Studio Theatre. A native of the Atomic City, Leah transplanted to the West Coast in 2000. After graduating from the University of California at Santa Cruz, where she earned dual degrees in Politics and Theatre Arts, she attended the Clown Conservatory in San Francisco.</p>

										<p class="desc"><!--<img alt="______" class="thumbnail floated-tight" src="img/staff-will.jpg" />--><span class="person">Danny Botello</span> <span class="title">(Instructor)</span> loves to sing and help facilitate creative spaces for young minds. For TYR, he has created stages, teaches singing and dancing, and plays D&D and imagination games with students of all ages. This wizard otter also enjoys tutoring Maths of all levels, plus Physics, Chemistry and Statistics.</p>


									</div>





									<div class="inlinebox bio">
										<p class="desc"><img alt="Kara Perrino" class="thumbnail floated-tight" src="img/staff-kara.jpg" /><span class="person">Kara Perrino</span> <span class="title">(Facility Manager / Instructor)</span>  is fairly new to California, having only recently moved from Charlottesville, VA to the west coast in the summer of 2017. She has had a love for theater since an early age, dabbling in theatrical roles that range from directing, costuming, set design, lights, sound, and of course...acting! She attended the College of Charleston for undergrad, graduating in 2013 with a Bachelors in Sociology and Astronomy focusing on social sciences and childhood development. She kept her love of theater as a hobby throughout her college years and discovered TYR when she moved to the bay. When she’s not directing for TYR she works behind the scenes with the company to ensure our spaces, shows, and supplies are all in order. A lover of costumes, props, and the treasures that help bring theater to life she strives to help create a magical experience for each show. Once a week she also hosts TYR’s recent Safe Space meetup for our LGBTQ students and allies, helping to ensure that we are a place where we hope everyone can feel heard, seen, and supported for who they uniquely are.  When not working with TYR Kara works as an emotional and social behavior technician, helping young individuals find their unique language to relate to the world. Kara believes that we all have a voice, and our ability to communicate, relate, and connect is the greatest strength we have to share as a community of people. She knows that anyone can harness their potential as long as we have the right tools. When she is not working with kids she spends her time developing her own voice and art as a practicer of singing, dance, tactile arts, or acrobatics.




										</p>
									</div>

									<div class="inlinebox bio">
										<p class="desc"><img alt="Rob Williamson" class="thumbnail floated-tight" src="img/staff-robw.jpg" /><span class="person">Rob Williamson</span> <span class="title">(Instructor)</span> is a California native, born at Travis Air Force Base.  Throughout his childhood and youth, he moved with his family and traveled around much of the United States coasts and Europe. Rob's love of theater began in his Maryland high school and continued through much of his time in college. He worked with the Davis Shakespeare Ensemble and was a founding member of Common House Productions, serving for a time as their Production Manager. He currently works full time as a youth director in Vacaville, but this doesn't leave him much time to perform, so he is thrilled that he received the opportunity to work with Tomorrow Youth Repertory to ensure that the love of theater gets carried down to the new generation!</p>

										<p class="desc"><img alt="Angel Adedokun" class="thumbnail floated-tight" src="img/staff-angel-a.jpg" /><span class="person">Angel Adedokun</span> <span class="title">(Instructor)</span> is a bilingual vocalist, songwriter, dancer, and choreographer. She has worked with the Latin company MundoBeat Entertainment and was featured as lead singer of Indianapolis Salsa band Grupo Bembe. In 2015, Angel moved from Indianapolis to California and has since jumped into musical theatre and teaching. Her stage credits include Hairspray (Lil Inez) with Footlite Musicals, SILENCE! The Musical (Ardelia Mapp), Jesus Christ Superstar (Peter, Dance Captain), and Hedwig & the Angry Inch (Choreography) with Ray of Light Theatre, Iron Shoes (Second Girl) with Shotgun Players, and Troop Beverly Heels with Peaches Christ Productions. Angel is currently working on her new solo album for more information you can go to <a href="http://Hellosoulangel.com">Hellosoulangel.com</a>.</p>
									</div>

									<div class="inlinebox bio row">
										<p class="desc"><img alt="Tania Johnson" class="thumbnail floated-tight" src="img/staff-tania.jpg" /><span class="person">Tania Johnson</span> <span class="title">(Instructor)</span> loves helping young people develop their artistic voices. She is happy to return to TYR after music directing productions of Be More Chill, Fiddler On The Roof, and Little Shop of Horrors. Tania is recipient of the 2014 Theatre Bay Area Award for Outstanding Music Direction for her work on Always...Patsy Cline! at Altarena Playhouse. Recent music direction credits include Christmas in Oz with East Bay Children's Theatre and Ragtime andCabaret at Contra Costa Civic Theatre. As an actor, she has performed with SF Playhouse, 42nd Street Moon, and TheatreWorks. Tania is an artist in residence in the musical theatre department at Ruth Asawa School of the Arts and teaches in the musical theatre classes at St. Joseph's High.</p>
									</div>


									<div class="inlinebox bio">
										<p class="desc"><img alt="Niki Jew" class="thumbnail floated-tight" src="img/_________.jpg" /><span class="person">Niki Jew</span> <span class="title">(Instructor)</span> is an Alameda native who grew up performing in the Bay Area. While studying at UCLA, she was heavily involved in HOOLIGAN Theatre Company, both on stage and behind the scenes as a member of creative teams and the development department. Niki began her journey with TYR performing in Footloose back in 2012, and is thrilled to be back as an instructor. She is so excited for this opportunity to share the joys of theatre with others and give back to a community that has given her so much.</p>
									</div>


									<div class="inlinebox bio">
										<p class="desc"><img alt="Lachelle Morris" class="thumbnail floated-tight" src="img/staff-lachelle.jpg" /><span class="person">Lachelle Morris</span> <span class="title">(Instructor)</span> is a new director to Tomorrow Youth Repertory this year but has had years of experience in acting, singing and dancing. As a child, she had years of participation in Bay Area Shakespeare camps and church choirs, and in high school, starred in productions such as RENT, West Side Story (Anita) and Seussical: The Musical (Amayzing Mayzie). As a volunteer missionary in Ecuador, she also led free musical theater workshops in the communities she served for the youth. Lachelle is also a teacher at Encinal Jr. Sr. High School in Alameda, CA. During her free time, she loves going on long walks with her dog, Iggy, playing basketball, meditating and playing video games.</p>
									</div>


									<div class="inlinebox bio row">
										<p class="desc"><img alt="Katy Mlodzik" class="thumbnail floated-tight" src="img/staff-katy.jpg" /><span class="person">Katy Mlodzik</span> <span class="title">(Instructor)</span> is a teaching artist, choreographer, and performer born and raised in the Bay Area. She graduated from UC Santa Cruz in 2019 with a Major in Theater Arts and a Minor in Dance. A newcomer to TYR, she is thrilled to be a part of the team and knows she has found a home in teaching the arts. She is so excited to be working in the field she has loved since she was a kid, and also works as a director and stage manager with theaters around the Bay Area. She is looking forward to working in more technical aspects of theater, having had experience with lighting, sound and costume design in college. She would also love to explore the drag scene and do more work as a pit musician (flute and trumpet) for shows in the area as well. She cannot be more happy with the community of artists she now gets to work with and looks forward to many more shows with TYR!</p>
									</div>


									<div class="inlinebox bio">
										<p class="desc"><img alt="Ali Watson" class="thumbnail floated-tight" src="img/staff-ali.jpg" /><span class="person">Ali Watson</span> <span class="title">(Instructor)</span> is new to the west, just moving to California in the summer of 2018 from the east coast. Ali has been involved with theater and film for almost half her life. Her background ranges from stage acting, film acting, singing, instrumental music, and the fine arts. In her down time, as a lover of song, Ali spends most of her time singing karaoke and projecting to the heavens. She also enjoys painting and working on music she has herself created! She has enjoyed working with young actors, and strives to guide their unique experience and complexity of taking a walk in someone else’s shoes with character and fun!</p>
									</div>





									<div class="inlinebox bio">
										<p class="desc"><span class="person">Pam Arneson</span> <span class="title">(Administrator)</span> is a native of Alameda's West End.  She has 3 kids who all have enjoyed performing on stage.  Pam has preferred to stay off stage, but has been involved in the backstage activities for many years. For 7 years, she co-produced Circus for Arts in the Schools which raised money for arts education in the Alameda public schools.  She continues to stay involved in volunteer opportunities with schools and other non-profits. If you have any questions regarding TYR programs, contact Pam at <a href="mailto:programs@tomorrowyouthrep.org">programs@tomorrowyouthrep.org</a>.</p>

										<p class="desc"><span class="person">Dan Wood</span> <span class="title">(Webmaster)</span> built and runs the TYR website with the aid of sophisticated space-age technologies that make sure the website content never goes stale. While not helping TYR, Dan is the proud father of two now grown-up (gulp!) kids who were prolific actors in TYR's early years, the landlord of several backyard <a href="http://sweethomealameda.com">honey</a>-yielding beehives, and a professional software engineer.</p>
									</div>
								</div>
								<div class="clearfix outdented">
									<div class="inlinebox">
										<p>
											<img class="snapshot" style="max-width:100%;"
											src="img/ajt1.jpg"
											alt="Tyler Null, Amy Marie Haven, and Jordan Best of Tomorrow Youth Repertory"
											onmouseover="this.src='img/ajt2.jpg';"
											onmouseout="this.src='img/ajt1.jpg';" />
										</p>
										<p style="text-align:center">Tomorrow Youth Rep founders Tyler Null, Amy Marie Haven, and Jordan Best</p>
									</div>
								</div>
							</div>
						</section>
					</main>
				</div><!-- end before-sticky-footer -->
			</div><!-- end clearfix -->
		</div><!-- end contain-sticky-footer -->
<?php include('_footer.php'); ?>
	</div>
<?php $includePinterest = FALSE; include('_body.end.php'); ?>
</body>
</html>


