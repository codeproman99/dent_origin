@extends('frontEnd.master', ['activePage' => 'contact', 'titlePage' => __('Contact')])
@section('content')

		<section id="home" class="video-hero" style="height: 500px; background-image: url({{ asset('frontEnd') }}/images/cover_img_1.jpg);  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
		<div class="overlay"></div>
			<div class="display-t display-t2 text-center">
				<div class="display-tc display-tc2">
					<div class="container">
						<div class="col-md-12 col-md-offset-0">
							<div class="animate-box">
								<h2>I nostri contatti</h2>
								<p class="breadcrumbs"><span><a href="/">Home</a></span> <span>Contact</span></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div id="colorlib-contact">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-push-8 animate-box">
						<h2>Ci puoi trovare qui</h2>
						<div class="row">
							<div class="col-md-12">
								<div class="contact-info-wrap-flex">
									<div class="con-info">
										<p><span><i class="icon-location-2"></i></span>{{-- VIA --}}<br> 31100 - Treviso</p>
									</div>
									<div class="con-info">
										<p><span><i class="icon-phone3"></i></span> <a href="tel://1234567920">{{-- NUMERO TELEFONO --}}</a></p>
									</div>
									<div class="con-info">
										<p><span><i class="icon-paperplane"></i></span> <a href="mailto:info@dentalmanager.it">info@dentalmanager.it</a></p>
									</div>
									<div class="con-info">
										<p><span><i class="icon-globe"></i></span> <a href="https://www.dentalmanager.it">dentalmanager.it</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8 col-md-pull-4 animate-box">
						<h2>Scrivici</h2>
						@if(count($errors) > 0)
							<div class="alert alert-danger">
								<ul>
									@foreach($errors->all() as $error)
										<li>{{ __($error) }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						@if($message = Session::get('success'))
								<div class="alert alert-success alert-block">
									<strong>{{ __($message) }}</strong>
								</div>
						@endif
						<form method="post" action="{{ url('contact/send') }}">
							{{ csrf_field() }}
							<div class="row form-group">
								<div class="col-md-6">
									<!-- <label for="fname">First Name</label> -->
									<input type="text" id="name" name ="name" class="form-control" placeholder="il tuo Nome">
								</div>
								<div class="col-md-6">
									<!-- <label for="lname">Last Name</label> -->
									<input type="text" id="surname"  name="surname" class="form-control" placeholder="il tuo Cognome">
								</div>
							</div>

							<div class="row form-group">
								<div class="col-md-12">
									<!-- <label for="email">Email</label> -->
									<input type="text" id="email" name="email" class="form-control" placeholder="la tua email">
								</div>
							</div>


							<div class="row form-group">
								<div class="col-md-12">
									<!-- <label for="message">Message</label> -->
									<textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="il tuo messaggio"></textarea>
								</div>
							</div>
							<div class="form-group">
								<input type="submit" value="Invia" class="btn btn-primary">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div id="map" class="colorlib-map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d44608.534979154385!2d12.199976284390557!3d45.67022907423109!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x477937d3c10cde51%3A0x42f69b005c22748d!2s31100%20Treviso%20TV!5e0!3m2!1sit!2sit!4v1585644955765!5m2!1sit!2sit" width="100%" height="500" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>

@endsection
