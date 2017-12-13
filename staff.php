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
										<p class="desc"><img alt="Tyler Null" class="thumbnail floated-tight" src="img/staff-tyler.jpg" /><span class="person">Tyler Null</span> <span class="title">(Managing Director / Instructor)</span> graduated from UC Berkeley in 2006, where he studied History, Film Studies, and Theatre, and served as the Technical Director and as a Producer for Barestage Productions. Upon graduating, Tyler began working furiously full-time in the Bay Area Theatre scene, serving as an actor, director, stage manager, lighting designer, and occasional playwright. At the same time, Tyler has also written, directed, or edited over 40 short films, commercials, or promo videos, and has served as a comedy writer (most notably for Nonsense News). Tyler has also occasionally moonlighted as a comedian and solo performer, most memorably in his well-received satirical 2011 piece (”Spencer Blackhart For Mayor”) for Voters Bloc Theatre. Tyler began teaching in 2010, directing children's theater in the East Bay and teaching tech &amp; acting at Stanford summer programs. Realizing how much he loves working with kids, Tyler decided to make teaching his primary focus in 2011.</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><img alt="Jordan Best" class="thumbnail floated-tight" src="img/staff-jordan.jpg" /><span class="person">Jordan Best</span> <span class="title">(Development Director / Instructor)</span> has a Master of Music Degree in Vocal Performance from CCM in Cincinnati, one of the country's top music conservatories, and a Bachelor of Music Degree, also in Vocal Performance, from DePaul University in Chicago, IL.  She has performed extensively in opera and musical theater throughout the Bay Area and US as well as in France and Italy. Ms. Best has a background in ballet, tap, Stanislavsky and Meisner method acting training and has performed in numerous concerts, recitals and benefits.  She has taught privately since 2006 and has a private vocal studio which includes both children and adults. She has worked as a voice teacher, musical director, music teacher and choreographer throughout the Bay Area since 2007 and is currently co-producer of 142 Throckmorton Theater's <i>Little Throck</i> Program and director of their high school Accapella group <i>Throckapella</i>.</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><img alt="Tim Silva" class="thumbnail floated-tight" src="img/staff-tim.jpg" />East Bay native <span class="person">Tim Silva</span> <span class="title">(Instructor)</span> is an active performer, teacher, and collaborator in a wide range of settings.  Since completing degrees in composition and vocal music education, Tim has recorded with some of the Bay Area’s most elite chamber choruses (AVE, Volti, SF Choral Artists) as well on the debut albums of Briget Boyle and Nick Hours.  This summer, he made his debut with Chalice Consort and also sang with the Russian National Orchestra in Volti’s Festival Chorus.  He performs regularly with several independent artists as a drummer/vocalist/multi-instrumentalist, and also is one-third of the folk-pop trio Iron Henry.  He teaches group classes, and private lessons; general music, choral music, music theory, and vocal technique; preschoolers, senior citizens, and everything in between.  In his second season with TYR, Tim looks forward to developing young, enthusiastic performers!</p>
									</div>
									<div class="inlinebox bio row">
										<p class="desc"><img alt="Leah Gardner" class="thumbnail floated-tight" src="img/staff-leah.jpg" /><span class="person">Leah Gardner</span> <span class="title">(Instructor)</span> is thrilled to be a part of the teaching team for Tomorrow Youth Repertory. Previous credits with TYR include Seussical. High School Musical, Alice in Wonderland and Wizard of Oz. In addition to TYR, Leah is a physical comedy and circus skills instructor for Oakland based Circus of Smiles. An undeniable clown, Leah has circled the globe performing with the internationally renowned physical comedy troupe, Pi. Leah has worked professionally as a director, stage manager and house manager with companies including: The 5th Avenue Musical Theatre, Boxcar Theatre, Teatro ZinZanni, Shakespeare Santa Cruz, Cal Shakes, The Mark Taper Forum, BrickaBrack, 42nd Street Moon, Cabrillo Stage and The Studio Theatre. A native of the Atomic City, Leah transplanted to the West Coast in 2000.  After graduating from the University of California at Santa Cruz, where she earned dual degrees in Politics and Theatre Arts, she attended the Clown Conservatory in San Francisco.</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><!--<img alt="Will Norman" class="thumbnail floated-tight" src="img/staff-will.jpg" />--><span class="person">Will Norman</span> <span class="title">(Instructor)</span> is a veteran multi-instrumentalist who is in his 3rd year teaching with TYR. He can be found playing in any number of bands, or arranging kids in “shells” and teaching them to “cheat out” while fending off the “Sherlock” kids who discovered he was ticklish.</p>

										<p class="desc"><!--<img alt="Andrea Duffey" class="thumbnail floated-tight" src="img/staff-andrea.jpg" />--><span class="person">Andrea Duffey</span> <span class="title">(Instructor)</span> is a new instructor at TYR. She went to Saint Mary's College of California for a split-major in Studio Art and Theatre and Performing Arts. She has performed in many plays and musicals in the past. In her spare time she designs jewelry and creates art.</p>

										<p class="desc"><img alt="Mallory Penney" class="thumbnail floated-tight" src="img/staff-mallory.jpg" /><span class="person">Mallory Penney</span> <span class="title">(Instructor)</span> is in her second year of teaching with Tomorrow Youth Repertory after having started and run her own acting program at Earhart Elementary.</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><img alt="Caitlin Gardner" class="thumbnail floated-tight" src="img/staff-caitlin.jpg" /><span class="person">Caitlin Gardner</span> <span class="title">(Instructor)</span> has been directing with Tomorrow Youth Repertory since 2013. She comes from a background in Early Childhood Development and Performance Arts with years of training and study at California State University East Bay. She was nominated for an Irene Ryan acting scholarship in December 2013 for her performance as Alice in Alice in Wonderland at Cal State East Bay, and was one of the original cast members in The Boxcar Theater of San Francisco's latest 1920's immersive performance, The Speakeasy. As a director, Caitlin strives to spark an actor's power to overcome many of the inhibitions and insecurities that come along with live performance. Her goal as an artist and director is to support each actor in connecting with their audience and to facilitate performances that, not only, will evoke emotion in viewers but also help the actors discover truth and confidence in themselves.</p>
									</div>
									<div class="inlinebox bio row">
										<p class="desc"><img alt="TonyaMarie" class="thumbnail floated-tight" src="img/staff-tonya.jpg" /><span class="person">TonyaMarie</span> <span class="title">(Rental Manager/Costume Designer)</span> has a Masters degree in Fine Art and Design, Sculpture, with additional studies in costume and fashion. She has been the wearer-of-all-hats running her own freelance artistry business Gypsy Cat Studios, since its beginnings in Ohio in 2007. She has costumed thousands of children in her 8 years in the Bay Area as well as worked in designing and creating sets, props, mascots and her own sculptural work for gallery exhibition. She has also taught many art and costume related classes to children. She has created costumes for or taught kids through Bay Area Children’s Theater, Tomorrow Youth Repertory, Alameda Musical Children’s Theater, Girls Inc., The Sewing Room Fashion Show, Start Up Arts, and Marin Horizons Theater Program.
										</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><!--<img alt="Melanie O’Reilly" class="thumbnail floated-tight" src="img/staff-melanie.jpg" />--><span class="person">Melanie O’Reilly</span> <span class="title">(Instructor)</span> is an experienced vocal teacher and musician, with too many tours and groups under her belt to name. She is glad to work with such fun and talented students.</p>

										<p class="desc"><img alt="Rebecca Gilbert" class="thumbnail floated-tight" src="img/staff-reba.jpg" /><span class="person">Rebecca (Reba) Gilbert</span> <span class="title">(Instructor)</span> is a Bay Area dancer and choreographer currently a member of Ahdanco Dance Company. She began dance at 11, did a whole lot of ballet, lyrical, jazz, pointe and even hip hop and then discovered modern dance at 15, where she fell in love with bare feet and the freedom of emotion through dance. She went to Mills College and got her BA in dance and has danced around with many different companies since.</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><img alt="Daniel Savio" class="thumbnail floated-tight" src="img/staff-daniel.jpg" /><span class="person">Daniel Savio</span> <span class="title">(Instructor)</span> started his professional theater career in 2006, playing keyboards for the Tony Award-winning San Francisco Mime Troupe, a company with which he is again performing in 2015. He recently was co-composer/lyricist of the play FSM (2014, Stagebridge Senior Theater). Daniel has also composed the scores of four musicals for young audiences at Stagebridge. Since 2008 he has been a musical director of children's theater in the East Bay and Marin. Daniel has a BA in Music from the University of California at Santa Cruz and currently studies with Bay Area composer Michael Kaulkin.</p>
									</div>
									<div class="inlinebox bio row">
										<p class="desc"><img alt="David Moore" class="thumbnail floated-tight" src="img/staff-david.jpg" /><span class="person">David Moore</span> <span class="title">(Instructor)</span> is a Bay Area performer and educator who has been with TYR since 2014. A Resident Artist of the San Francisco Shakespeare Festival, David has performed with many regional and local theaters, including SF Shakes, Colorado Shakespeare Festival, Crowded Fire Theater, Marin Shakespeare Company, Word for Word, Just Theater, and Marin Theatre Company.  David teaches with SF Shakes, Tomorrow Youth Repertory, and Oregon Shakespeare Festival.  As an educator of K-12 students, David has led Shakespeare workshops up and down the West Coast and has co-directed both musicals and traditional plays, including <i>Much Ado About Nothing</i>, <i>The Winter's Tale</i>, and TYR productions of <i>Beauty and the Beast</i>, <i>Alice in Wonderland</i>, and <i>Aladdin</i>. He earned a BA in Theater and Performance Studies from UC Berkeley.
										</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><img alt="David Moore" class="thumbnail floated-tight" src="img/staff-rob.jpg" /><span class="person">Rob Cheifetz</span> <span class="title">(Instructor)</span> has been a director with TYR since our wild productions of Narnia and Les Misérables in Summer 2013.  A Bay Area native, Rob teaches voice and woodwinds as a private instructor and substitute teaches in public schools.  He graduated from UC Berkeley with a bachelor's degree in music composition and performance.  During his time at Cal he was mentored by Marika Kuzma in vocal ensemble conducting and by Myra Melford in a wide range of approaches to ensemble improvisation.  He has performed in pit bands for tons of musicals at numerous Bay Area stages.  Rob has an extensive history of touring bands, including afrobeat ensemble Lagos Roots, funk-pop-party crew Wallpaper with the prodigious Ricky Reed, and the local rock band Add Moss.  Over the last 7 years, the now-defunct Foundry in West Berkeley hosted Rob as a resident artist where he wrote, directed, and produced his own improvisational musical (or "improvsical") and a variety of other performance art pieces.   Rob is absolutely jazzed to be a part of this wonderful TYR community.
										</p>
									</div>
									<div class="inlinebox bio">
										<p class="desc"><img alt="David Moore" class="thumbnail floated-tight" src="img/staff-tania.jpg" /><span class="person">Tania Johnson</span> <span class="title">(Music Director)</span> is happy to be making her Tomorrow Youth Repertory debut. A recipient of the 2014 Theatre Bay Area Award for Outstanding Music Direction for her work on <i>Always…Patsy Cline!</i> at Altarena Playhouse, Tania loves using all aspects of her musical and theatrical training to help young people develop their artistic voices. She is active in the musical theatre classes at Alameda High and St. Joseph's High. Most recently she was music director at Coastal Repertory in Half Moon Bay. At Berkeley Playhouse, Tania was conductor for <i>Peter Pan</i> as well as music director for many Conservatory productions. Other recent music director projects include the Altarena, Redwood High School, Youth Musical Theatre Company and Bay Area Children's Theatre. As an actor, Tania has performed with many companies including SF Playhouse, 42nd Street Moon, and TheatreWorks. Tania holds a B.A. in music from U.C Berkeley where she was founding music director of BareStage.
										</p>
									</div>

									<div class="inlinebox bio row">
										<p class="desc"><!--<img alt="Pam Arneson" class="thumbnail floated-tight" src="img/staff-pam.jpg" />--><span class="person">Pam Arneson</span> <span class="title">(Administrator)</span> is a native of Alameda's West End.  She has 3 daughters who all enjoy performing in musical theater.  Two of them continue to be involved in TYR programs.   It seems that Pam has always been involved in producing fundraising events.  For 7 years, she co-produced Circus for Arts in the Schools, and continues to help produce gala events for the Medical Clown Project. If you have any questions regarding TYR programs, contact Pam at <a href="programs@tomorrowyouthrep.org">programs@tomorrowyouthrep.org</a>.</p>
									</div>
									<div class="inlinebox bio">
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


