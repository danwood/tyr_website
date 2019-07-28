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
										<p class="desc"><img alt="Tyler Null" class="thumbnail floated-tight" src="img/staff-tyler.jpg" /><span class="person">Tyler Null</span> <span class="title">(Managing Director / Instructor)</span> has been teaching theater since 2010. Tyler’s own journey into theater and performing arts began in childhood after-school programs, and he is grateful and excited to be able to pass this along. Tyler has been on all sides of the theater world, serving at various times as an actor, a producer, a director, a writer, a designer, a stage manager, a puppeteer, a scenic builder, a lighting technician, and pretty much everything except for a marketer (which is why he is <b>so</b> especially grateful that he knows other people that are good at that particular field).  A firm believer in the value of teamwork and community, Tyler seeks to instill in TYR an appreciation for the all of the contributors that come together to make a single experience on the stage. 
										</p>
										<p  class="desc">When not working with the next generation, Tyler still actively moonlights as an actor, as a musician, and as a writer. He can also be found dabbling in the stand-up comedy world from time-to-time. His personal favorite credits include his Voter’s Bloc Theater piece <i>Spencer Blackhart for Mayor</i> and the film <i>Refinery Surveyor Black</i>. He also for obvious reasons has a particularly soft spot for <i>Snow White</i> and for <i>Sherlock Holmes and the Mystery of the Missing Mystery</i>, which were developed for and performed by TYR.
</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><img alt="Jordan Best" class="thumbnail floated-tight" src="img/staff-jordan.jpg" /><span class="person">Jordan Best</span> <span class="title">(Development Director / Instructor)</span> has a Master of Music Degree in Vocal Performance from CCM in Cincinnati, one of the country's top music conservatories, and a Bachelor of Music Degree, also in Vocal Performance, from DePaul University in Chicago, IL.  She has performed extensively in opera and musical theater throughout the Bay Area and US as well as in France and Italy. Ms. Best has a background in ballet, tap, Stanislavsky and Meisner method acting training and has performed in numerous concerts, recitals and benefits.  She has taught privately since 2006 and has a private vocal studio which includes both children and adults. She has worked as a voice teacher, musical director, music teacher and choreographer throughout the Bay Area since 2007 and is currently co-producer of 142 Throckmorton Theater's <i>Little Throck</i> Program and director of their high school Accapella group <i>Throckapella</i>.</p>


										

									</div>

									<div class="inlinebox bio">
										<p class="desc"><!--<img alt="Miyuki Bierlein" class="thumbnail floated-tight" src="img/staff-miyuki.jpg" />--><span class="person">Miyuki Bierlein</span> <span class="title">(Production Manager)</span> has had over ten years of experience working in the Bay Area theater scene as an artistic collaborator. She enjoys combining her intimate knowledge of the technical world of theater and her savvy as a small business owner to help create the magic we put on the TYR stage! Miyuki loves creating and facilitating spaces for creative collaboration; please email her at <a href="mailto:miyuki@tomorrowyouthrep.org">miyuki@tomorrowyouthrep.org</a> if you have a skill you'd like to contribute to our behind-the-scenes hustle and bustle. 											
										</p>

										<p class="desc"><img alt="Mallory Penney" class="thumbnail floated-tight" src="img/staff-mallory.jpg" /><span class="person">Mallory Penney</span> <span class="title">(Instructor)</span> has been involved in theater since she was six years old and has never looked back. From acting to stage managing to directing, Mallory has always felt at home working with young actors exploring the wonders theater can offer us. While attending school, Mallory founded and ran a theater program at Earhart Elementary school in Alameda. She is a graduate of UC Berkeley with a degree in Theater and Performance Studies. Mallory currently works as a teaching artist with companies such as Berkeley Repertory School of Theatre and Throckmorton Theatre. 
										</p>
									</div>

									<div class="inlinebox bio row">



										<p class="desc"><img alt="Cienna Johnson" class="thumbnail floated-tight" src="img/staff-cienna.jpg" /><span class="person">Cienna Johnson</span> <span class="title">(Instructor)</span>  graduated from San Diego State University in 2018 with a degree in Theatre Performance and a minor in Communications.  Her most recent work in college includes Julius Caesar and Octavius in an all-female production of Julius Caesar, Nemasani in Anon(ymous), and Teresa de la Rosa in Anna in the Tropics.  Cienna has been immersed in theatre since the age of 13.  She was a youth actor and intern for many TYR productions, and is ecstatic to be back as an instructor.  Cienna is looking forward to sharing the experience of storytelling with creative young artists.</p>

										<p class="desc"><!--<img alt="______" class="thumbnail floated-tight" src="img/staff-will.jpg" />--><span class="person">Danny Botello</span> <span class="title">(Instructor)</span> is excited to be back once again this summer with TYR, after having taught the "Hamilton" class the past two years. A performer with extensive dance, music, and circus art experience, Danny is happy to be working with so many enthusiastic and talented students.</p>


									</div>


									<div class="inlinebox bio">
										<p class="desc"><img alt="Leah Gardner" class="thumbnail floated-tight" src="img/staff-leah.jpg" /><span class="person">Leah Gardner</span> <span class="title">(Instructor)</span> is thrilled to be a part of the teaching team for Tomorrow Youth Repertory. Previous credits with TYR include <i>Little Mermaid</i>, <i>Honk</i>, <i>Addams Family Musical</i>, <i>Midsummer Night’s Dream</i>, <i>Snow White</i>, <i>Rumors</i>, <i>Willy Wonka and the Chocolate Factory</i>, <i>Hansel and Gretel</i>, <i>Aladdin</i>, <i>Into the Woods</i>, <i>Cinderella</i>, <i>Seussical</i>, <i>High School Musical</i>, <i>Alice in Wonderland</i> and <i>Wizard of Oz</i>. In addition to TYR, Leah is a physical comedy and circus skills instructor for Oakland based Circus of Smiles. An undeniable clown, Leah has circled the globe performing with the internationally renowned physical comedy troupe, Pi. Leah is currently the director in residence for an immersive show called The Speakeasy SF. Leah has worked professionally as a director, stage manager and house manager with companies including: The 5th Avenue Musical Theatre, Boxcar Theatre, Teatro ZinZanni, Shakespeare Santa Cruz, Cal Shakes, The Mark Taper Forum, BrickaBrack, 42nd Street Moon, Cabrillo Stage and The Studio Theatre. A native of the Atomic City, Leah transplanted to the West Coast in 2000. After graduating from the University of California at Santa Cruz, where she earned dual degrees in Politics and Theatre Arts, she attended the Clown Conservatory in San Francisco.</p>
									</div>

									<div class="inlinebox bio">
										<p class="desc"><img alt="David Moore" class="thumbnail floated-tight" src="img/staff-rob.jpg" /><span class="person">Rob Cheifetz</span> <span class="title">(Instructor)</span> has been a director with TYR since our wild productions of Narnia and Les Misérables in Summer 2013.  A Bay Area native, Rob teaches voice and woodwinds as a private instructor and substitute teaches in public schools.  He graduated from UC Berkeley with a bachelor's degree in music composition and performance.  During his time at Cal he was mentored by Marika Kuzma in vocal ensemble conducting and by Myra Melford in a wide range of approaches to ensemble improvisation.  He has performed in pit bands for tons of musicals at numerous Bay Area stages.  Rob has an extensive history of touring bands, including afrobeat ensemble Lagos Roots, funk-pop-party crew Wallpaper with the prodigious Ricky Reed, and the local rock band Add Moss.  Over the last 7 years, the now-defunct Foundry in West Berkeley hosted Rob as a resident artist where he wrote, directed, and produced his own improvisational musical (or "improvsical") and a variety of other performance art pieces.   Rob is absolutely jazzed to be a part of this wonderful TYR community.
										</p>
									</div>

									<div class="inlinebox bio row">



									</div>

									<!--
									<div class="inlinebox bio">
										<p class="desc"><img alt="Daniel Savio" class="thumbnail floated-tight" src="img/staff-daniel.jpg" /><span class="person">Daniel Savio</span> <span class="title">(Instructor)</span> started his professional theater career in 2006, playing keyboards for the Tony Award-winning San Francisco Mime Troupe, a company with which he is again performing in 2015. He recently was co-composer/lyricist of the play FSM (2014, Stagebridge Senior Theater). Daniel has also composed the scores of four musicals for young audiences at Stagebridge. Since 2008 he has been a musical director of children's theater in the East Bay and Marin. Daniel has a BA in Music from the University of California at Santa Cruz and currently studies with Bay Area composer Michael Kaulkin.</p>
									</div>

									-->

									<div class="inlinebox bio row">
										<p class="desc"><img alt="David Moore" class="thumbnail floated-tight" src="img/staff-david.jpg" /><span class="person">David Moore</span> <span class="title">(Instructor)</span> is a Bay Area performer and educator who has been with TYR since 2014. A Resident Artist of the San Francisco Shakespeare Festival, David has performed with many regional and local theaters, including SF Shakes, Colorado Shakespeare Festival, Crowded Fire Theater, Marin Shakespeare Company, Word for Word, Just Theater, and Marin Theatre Company.  David teaches with SF Shakes, Tomorrow Youth Repertory, and Oregon Shakespeare Festival.  As an educator of K-12 students, David has led Shakespeare workshops up and down the West Coast and has co-directed both musicals and traditional plays, including <i>Much Ado About Nothing</i>, <i>The Winter's Tale</i>, and TYR productions of <i>Beauty and the Beast</i>, <i>Alice in Wonderland</i>, and <i>Aladdin</i>. He earned a BA in Theater and Performance Studies from UC Berkeley.
										</p>
									</div>



									<div class="inlinebox bio">
										<p class="desc"><img alt="Kara Perrino" class="thumbnail floated-tight" src="img/staff-kara.jpg" /><span class="person">Kara Perrino</span> <span class="title">(Instructor)</span> is new to California, having only recently moved from Charlottesville, VA to the west coast in the summer of 2017. She has had a love for theater since an early age, dabbling in theatrical roles that range from directing, set design, costuming, lights/sound, and of course...acting! She attended the College of Charleston for undergrad, graduating in 2013 with a Bachelors in Sociology and Astronomy, and kept her love of theater as a hobby throughout her college years. A jack of all trades, she has spent most of the past several years teaching, running local coffee shops, toy stores, or playrooms and working on display work for local businesses. She is so excited to be a part of this amazing program as she settles into her new home in the Bay Area.




										</p>
									</div>

									<div class="inlinebox bio">
										<p class="desc"><img alt="Rob Williamson" class="thumbnail floated-tight" src="img/staff-robw.jpg" /><span class="person">Rob Williamson</span> <span class="title">(Instructor)</span> is a California native, born at Travis Air Force Base.  Throughout his childhood and youth, he moved with his family and traveled around much of the United States coasts and Europe. Rob's love of theater began in his Maryland high school and continued through much of his time in college. He worked with the Davis Shakespeare Ensemble and was a founding member of Common House Productions, serving for a time as their Production Manager. He currently works full time as a youth director in Vacaville, but this doesn't leave him much time to perform, so he is thrilled that he received the opportunity to work with Tomorrow Youth Repertory to ensure that the love of theater gets carried down to the new generation!</p>
									</div>

									<div class="inlinebox bio row">
										<p class="desc"><img alt="Angel Adedokun" class="thumbnail floated-tight" src="img/staff-angel-a.jpg" /><span class="person">Angel Adedokun</span> <span class="title">(Instructor)</span> is a bilingual vocalist, songwriter, dancer, and choreographer. She has worked with the Latin company MundoBeat Entertainment and was featured as lead singer of Indianapolis Salsa band Grupo Bembe. In 2015, Angel moved from Indianapolis to California and has since jumped into musical theatre and teaching. Her stage credits include Hairspray (Lil Inez) with Footlite Musicals, SILENCE! The Musical (Ardelia Mapp), Jesus Christ Superstar (Peter, Dance Captain), and Hedwig & the Angry Inch (Choreography) with Ray of Light Theatre,  Iron Shoes (Second Girl) with Shotgun Players, and Troop Beverly Heels with Peaches Christ Productions. For more information please visit <a href="Angelnicole.us">Angelnicole.us</a>.</p>
									</div>



									<div class="inlinebox bio">
										

										<p class="desc"><span class="person">Gabby Smith</span> <span class="title">(Instructor)</span> is very excited to be a part of the TYR teaching staff. She has been able to try her hand in many aspects of theater, including performing, set building, costume design, stage management, sound, and assisting in staging and choreography. Having been a performer and intern in many past TYR shows, she is thrilled to continue working with this wonderful group. She is currently attending Azusa Pacific University for a major in Theater Arts and minor in Entrepreneurship.</p>

									</div>






									<div class="inlinebox bio">
										<p class="desc"><span class="person">Pam Arneson</span> <span class="title">(Administrator)</span> is a native of Alameda's West End.  She has 3 daughters who all enjoy performing in musical theater.  Two of them continue to be involved in TYR programs.   It seems that Pam has always been involved in producing fundraising events.  For 7 years, she co-produced Circus for Arts in the Schools, and continues to help produce gala events for the Medical Clown Project. If you have any questions regarding TYR programs, contact Pam at <a href="programs@tomorrowyouthrep.org">programs@tomorrowyouthrep.org</a>.</p>

										<p class="desc"><span class="person">Dan Wood</span> <span class="title">(Webmaster)</span> built and runs the TYR website with the aid of sophisticated space-age technologies that make sure the website content never goes stale. While not helping TYR, Dan is the proud father of two actors from past TYR productions, the landlord of several backyard <a href="http://sweethomealameda.com">honey</a>-yielding beehives, and a professional software engineer.</p>
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


