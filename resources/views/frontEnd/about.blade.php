@extends('frontEnd.master', ['activePage' => 'about', 'titlePage' => __('About')])
@section('content')

		<section id="home" class="video-hero" style="height: 500px; background-image: url({{ asset('frontEnd') }}/images/cover_img_1.jpg);  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
		<div class="overlay"></div>
			<div class="display-t display-t2 text-center">
				<div class="display-tc display-tc2">
					<div class="container">
						<div class="col-md-12 col-md-offset-0">
							<div class="animate-box">
								<h2>Su di noi</h2>
								<p class="breadcrumbs"><span><a href="/">Home</a></span> <span>Services</span></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="colorlib-about">
			<div class="container">
				<div class="row row-pb-lg">
					<div class="col-md-6 animate-box">
						<div class="video colorlib-video" style="background-image: url({{ asset('frontEnd') }}/images/about.jpg);">
							<a href="https://vimeo.com/channels/staffpicks/93951774" class="popup-vimeo"><i class="icon-play3"></i></a>
							<div class="overlay"></div>
						</div>
					</div>
					<div class="col-md-6 animate-box">
						<h2>Al servizio dello studio dentistico</h2>
						<p> tutti noi dentisti sappiamo quanto importante sia per misurare la “salute dello studio dentistico analizzare in modo ”manageriale” la quantità e le performance delle nostre prime visite; non solo ! Tutti noi sappiamo quanto siano importanti i processi di gestione, richiamo e reminder dei nuovi pazienti. Tutto ciò, grazie al nostro software dental manager è oggi possibile. Accedi a dental manager gratuitamente per 15 giorni con tutte le sue funzionalità complete.</p>
					</div>
				</div>

				{{--
				<div class="row">
					<div class="col-md-8 col-md-offset-2 text-center colorlib-heading animate-box">
						<h2>Collaborate with your design team in a new way</h2>
						<p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 text-center animate-box">
						<div class="staff-entry">
							<a href="#" class="staff-img" style="background-image: url({{ asset('frontEnd') }}/images/person1.jpg);"></a>
							<div class="desc">
								<h3>Emily Turner</h3>
								<span>Developer</span>
								<p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
								<p>
									<ul class="colorlib-social-icons">
										<li><a href="#"><i class="icon-twitter"></i></a></li>
										<li><a href="#"><i class="icon-facebook"></i></a></li>
										<li><a href="#"><i class="icon-linkedin"></i></a></li>
										<li><a href="#"><i class="icon-dribbble"></i></a></li>
									</ul>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 text-center animate-box">
						<div class="staff-entry">
							<a href="#" class="staff-img" style="background-image: url({{ asset('frontEnd') }}/images/person2.jpg);"></a>
							<div class="desc">
								<h3>Jackie Chen</h3>
								<span>Developer</span>
								<p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
								<p>
									<ul class="colorlib-social-icons">
										<li><a href="#"><i class="icon-twitter"></i></a></li>
										<li><a href="#"><i class="icon-facebook"></i></a></li>
										<li><a href="#"><i class="icon-linkedin"></i></a></li>
										<li><a href="#"><i class="icon-dribbble"></i></a></li>
									</ul>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 text-center animate-box">
						<div class="staff-entry">
							<a href="#" class="staff-img" style="background-image: url({{ asset('frontEnd') }}/images/person3.jpg);"></a>
							<div class="desc">
								<h3>Noah Nelson</h3>
								<span>Designer</span>
								<p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
								<p>
									<ul class="colorlib-social-icons">
										<li><a href="#"><i class="icon-twitter"></i></a></li>
										<li><a href="#"><i class="icon-facebook"></i></a></li>
										<li><a href="#"><i class="icon-linkedin"></i></a></li>
										<li><a href="#"><i class="icon-dribbble"></i></a></li>
									</ul>
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 text-center animate-box">
						<div class="staff-entry">
							<a href="#" class="staff-img" style="background-image: url({{ asset('frontEnd') }}/images/person4.jpg);"></a>
							<div class="desc">
								<h3>Dorothy Murphy</h3>
								<span>Designer</span>
								<p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
								<p>
									<ul class="colorlib-social-icons">
										<li><a href="#"><i class="icon-twitter"></i></a></li>
										<li><a href="#"><i class="icon-facebook"></i></a></li>
										<li><a href="#"><i class="icon-linkedin"></i></a></li>
										<li><a href="#"><i class="icon-dribbble"></i></a></li>
									</ul>
								</p>
							</div>
						</div>
					</div>
				</div>
				--}}
			</div>
		</div>
@endsection
