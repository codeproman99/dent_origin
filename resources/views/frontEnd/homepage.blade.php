@extends('frontEnd.master', ['activePage' => 'homepage', 'titlePage' => __('Homepage')])
@section('content')

		<section id="home" class="video-hero" style="height: 700px; background-image: url({{ asset('frontEnd') }}/images/cover_img_1.jpg);  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
		<div class="overlay"></div>
			<a class="player" data-property="{videoURL:'https://www.youtube.com/watch?v=iGpuQ0ioPrM',containment:'#home', showControls:false, autoPlay:true, loop:true, mute:true, startAt:0, opacity:1, quality:'default'}"></a>
			<div class="display-t text-center">
				<div class="display-tc">
					<div class="container">
						<div class="col-md-12 col-md-offset-0">
							<div class="animate-box">
								<h2>Tieni sotto crontrollo le <b>nuove</b> prime visite del tuo studio dentistico</h2>
								<p>con DentalManager è facile, intuitivo e con gestione automatizzata</p>
								<p><a href="/gallery" class="btn btn-primary btn-lg btn-custom">Acquista</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="colorlib-featured">
			<div class="row animate-box">
				<div class="featured-wrap">
					<div class="owl-carousel">
						<div class="item">
							<div class="col-md-8 col-md-offset-2">
								<div class="featured-entry">
									<img class="img-responsive" src="{{ asset('frontEnd') }}/images/111.png" alt="">
								</div>
							</div>
						</div>
						<div class="item">
							<div class="col-md-8 col-md-offset-2">
								<div class="featured-entry">
									<img class="img-responsive" src="{{ asset('frontEnd') }}/images/222.png" alt="">
								</div>
							</div>
						</div>
						<div class="item">
							<div class="col-md-8 col-md-offset-2">
								<div class="featured-entry">
									<img class="img-responsive" src="{{ asset('frontEnd') }}/images/333.png" alt="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="colorlib-services colorlib-bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-4 text-center animate-box">
						<div class="services">
							<span class="icon">
								<i class="icon-browser"></i>
							</span>
							<div class="desc">
								<h3>Interfaccia semplice</h3>
								<p>Abbiamo ideato un interfaccia semplice per ridurre le complessità di gestione</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 text-center animate-box">
						<div class="services">
							<span class="icon">
								<i class="icon-download"></i>
							</span>
							<div class="desc">
								<h3>Tutto in Cloud</h3>
								<p>Dimenticati dei backup e dormi tranquillo, tutti i tuoi dati sono al sicuro nei nostri datacenter.</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 text-center animate-box">
						<div class="services">
							<span class="icon">
								<i class="icon-layers"></i>
							</span>
							<div class="desc">
								<h3>Pensato per essere rivoluzionario</h3>
								<p>Pensato da dentisti e da esperti di marketing per darti risposte veloci ai tuoi dubbi.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="colorlib-intro">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center colorlib-heading animate-box">
						<h2>Pensato per lo studio dentistico e per le aziende che si occupano di trovarne i clienti.</h2>
						<p>Il nostro gestionale può essere gestito in piena autonomia da ogni studio dentistico, o la sua gestione può essere affidata ad un <b>manager esterno</b> che si occupi di inserire i pazienti nell'agenda del tuo studio dentistico secondo le tue indicazioni, in maniera completamente autonoma e senza accedere ai tuoi dati riservati.</p>
					</div>
				</div>
				{{--<div class="row">
					<div class="col-md-12 animate-box">
						<span class="play"><a href="https://vimeo.com/channels/staffpicks/93951774" class="pulse popup-vimeo"><i class="icon-play3"></i></a></span>
					</div>
				</div>--}}
			</div>
		</div>
		{{--
		<div class="colorlib-work-featured colorlib-bg-white">
			<div class="container">
				<div class="row mobile-wrap">
					<div class="col-md-5 animate-box">
						<div class="mobile-img" style="background-image: url({{ asset('frontEnd') }}/images/mobile-2.jpg);"></div>
					</div>
					<div class="col-md-7 animate-box">
						<div class="desc">
							<h2>Real template creation</h2>
							<div class="features">
								<span class="icon"><i class="icon-lightbulb"></i></span>
								<div class="f-desc">
									<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
								</div>
							</div>
							<div class="features">
								<span class="icon"><i class="icon-circle-compass"></i></span>
								<div class="f-desc">
									<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
								</div>
							</div>
							<div class="features">
								<span class="icon"><i class="icon-beaker"></i></span>
								<div class="f-desc">
									<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
								</div>
							</div>
							<p><a href="#" class="btn btn-primary btn-outline with-arrow">Start collaborating <i class="icon-arrow-right3"></i></a></p>
						</div>
					</div>
				</div>
				<div class="row mobile-wrap">
					<div class="col-md-5 col-md-push-7 animate-box">
						<div class="mobile-img" style="background-image: url({{ asset('frontEnd') }}/images/mobile-1.jpg);"></div>
					</div>
					<div class="col-md-7 col-md-pull-5 animate-box">
						<div class="desc">
							<h2>Finish template creation</h2>
							<div class="features">
								<span class="icon"><i class="icon-lightbulb"></i></span>
								<div class="f-desc">
									<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
								</div>
							</div>
							<div class="features">
								<span class="icon"><i class="icon-circle-compass"></i></span>
								<div class="f-desc">
									<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
								</div>
							</div>
							<div class="features">
								<span class="icon"><i class="icon-beaker"></i></span>
								<div class="f-desc">
									<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
								</div>
							</div>
							<p><a href="#" class="btn btn-primary btn-outline with-arrow">Start collaborating <i class="icon-arrow-right3"></i></a></p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="colorlib-counter" class="colorlib-counters" style="background-image: url({{ asset('frontEnd') }}/images/cover_img_1.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-4 col-sm-4 text-center animate-box">
							<div class="counter-entry">
								<span class="icon"><i class="flaticon-ribbon"></i></span>
								<div class="desc">
									<span class="colorlib-counter js-counter" data-from="0" data-to="1500" data-speed="5000" data-refresh-interval="50"></span>
									<span class="colorlib-counter-label">Of customers are satisfied with our professional support</span>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 text-center animate-box">
							<div class="counter-entry">
								<span class="icon"><i class="flaticon-church"></i></span>
								<div class="desc">
									<span class="colorlib-counter js-counter" data-from="0" data-to="500" data-speed="5000" data-refresh-interval="50"></span>
									<span class="colorlib-counter-label">Amazing preset options to be mixed and combined</span>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 text-center animate-box">
							<div class="counter-entry">
								<span class="icon"><i class="flaticon-dove"></i></span>
								<div class="desc">
									<span class="colorlib-counter js-counter" data-from="0" data-to="1200" data-speed="5000" data-refresh-interval="50"></span>
									<span class="colorlib-counter-label">Average response time on live chat support channel</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="colorlib-blog">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center colorlib-heading animate-box">
						<h2>News from our Blog</h2>
						<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 animate-box">
						<article>
							<h2>Building the Mention Sales Application on Unapp</h2>
							<p class="admin"><span>May 12, 2018</span></p>
							<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life</p>
							<p class="author-wrap"><a href="#" class="author-img" style="background-image: url({{ asset('frontEnd') }}/images/person1.jpg);"></a> <a href="#" class="author">by Dave Miller</a></p>
						</article>
					</div>
					<div class="col-md-4 animate-box">
						<article>
							<h2>Building the Mention Sales Application on Unapp</h2>
							<p class="admin"><span>May 12, 2018</span></p>
							<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life</p>
							<p class="author-wrap"><a href="#" class="author-img" style="background-image: url({{ asset('frontEnd') }}/images/person2.jpg);"></a> <a href="#" class="author">by Dave Miller</a></p>
						</article>
					</div>
					<div class="col-md-4 animate-box">
						<article>
							<h2>Building the Mention Sales Application on Unapp</h2>
							<p class="admin"><span>May 12, 2018</span></p>
							<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life</p>
							<p class="author-wrap"><a href="#" class="author-img" style="background-image: url({{ asset('frontEnd') }}/images/person3.jpg);"></a> <a href="#" class="author">by Dave Miller</a></p>
						</article>
					</div>
				</div>
			</div>
		</div>

		<div id="colorlib-subscribe" class="colorlib-subscribe" style="background-image: url({{ asset('frontEnd') }}/images/cover_img_1.jpg);" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1 text-center colorlib-heading animate-box">
						<h2>Already trusted by over 10,000 users</h2>
						<p>Subscribe to receive unapp tips from instructors right to your inbox.</p>
					</div>
				</div>
				<div class="row animate-box">
					<div class="col-md-6 col-md-offset-3">
						<div class="row">
							<div class="col-md-12">
							<form class="form-inline qbstp-header-subscribe">
								<div class="col-three-forth">
									<div class="form-group">
										<input type="text" class="form-control" id="email" placeholder="Enter your email">
									</div>
								</div>
								<div class="col-one-third">
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Inscriviti ora</button>
									</div>
								</div>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="colorlib-pricing">
			<div class="container" style="align:center">
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center colorlib-heading animate-box">
						<h2>Prezzi</h2>
						<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 text-center animate-box">
						<div class="pricing">
							<h2 class="pricing-heading">Per lo Studio</h2>
							<div class="price">50<sup class="currency">€</sup><small>al mese.</small></div>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							<p><a href="#" class="btn btn-primary">Acquista</a></p>
						</div>
					</div>
					<div class="col-md-6 text-center animate-box">
						<div class="pricing">
							<h2 class="pricing-heading">Per il Manager</h2>
							<div class="price">100<sup class="currency">€</sup><small>al mese.</small></div>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							<p><a href="#" class="btn btn-primary">Acquista</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		--}}
@endsection
