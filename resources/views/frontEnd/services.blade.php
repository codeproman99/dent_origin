@extends('frontEnd.master', ['activePage' => 'services', 'titlePage' => __('Services')])
@section('content')

		<section id="home" class="video-hero" style="height: 500px; background-image: url({{ asset('frontEnd') }}/images/cover_img_1.jpg);  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
		<div class="overlay"></div>
			<div class="display-t display-t2 text-center">
				<div class="display-tc display-tc2">
					<div class="container">
						<div class="col-md-12 col-md-offset-0">
							<div class="animate-box">
								<h2>Il nostro gestionale</h2>
								<p class="breadcrumbs"><span><a href="/">Home</a></span> <span>Services</span></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="colorlib-services">
			<div class="container">
				<div class="row">
					<div class="col-md-4 text-center animate-box">
						<div class="services">
							<span class="icon">
								<i class="icon-browser"></i>
							</span>
							<div class="desc">
								<h3>Create your own template</h3>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 text-center animate-box">
						<div class="services">
							<span class="icon">
								<i class="icon-download"></i>
							</span>
							<div class="desc">
								<h3>Automatic Backup Data</h3>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 text-center animate-box">
						<div class="services">
							<span class="icon">
								<i class="icon-layers"></i>
							</span>
							<div class="desc">
								<h3>Page Builder</h3>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 text-center animate-box">
						<div class="services">
							<span class="icon">
								<i class="icon-video"></i>
							</span>
							<div class="desc">
								<h3>Watch tutorial</h3>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 text-center animate-box">
						<div class="services">
							<span class="icon">
								<i class="icon-gears"></i>
							</span>
							<div class="desc">
								<h3>Help &amp; Support</h3>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							</div>
						</div>
					</div>
					<div class="col-md-4 text-center animate-box">
						<div class="services">
							<span class="icon">
								<i class="icon-adjustments"></i>
							</span>
							<div class="desc">
								<h3>Lots of features</h3>
								<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

@endsection
