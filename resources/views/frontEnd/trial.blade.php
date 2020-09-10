@extends('frontEnd.master', ['activePage' => 'trial', 'titlePage' => __('Trial')])
@section('content')

		<section id="home" class="video-hero" style="height: 500px; background-image: url({{ asset('frontEnd') }}/images/cover_img_1.jpg);  background-size:cover; background-position: center center;background-attachment:fixed;" data-section="home">
		<div class="overlay"></div>
			<div class="display-t display-t2 text-center">
				<div class="display-tc display-tc2">
					<div class="container">
						<div class="col-md-12 col-md-offset-0">
							<div class="animate-box">
								<h2>Prova il nostro gestionale gratuitamente</h2>
								<h3 style="color:white">15 Giorni di utilizzo te li regaliamo noi</h3>
								<p class="breadcrumbs"><span><a href="/">Home</a></span> <span>trial</span></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div id="colorlib-contact">
			<div class="container">
				<div class="row">
					<div class="col-md-12 animate-box">
						<h2>Compila il Form per registrarti alla prova gratuita:</h2>
						<h3>Entro qualche minuto riceverai le istruzioni per accedere al gestionale via email!</h3>

						@if(count($errors) > 0)
							<div class="alert alert-danger">
								<ul>
									@foreach($errors->all() as $error)
										<li>{{ __($error) }}</li>
									@endforeach
								</ul>
								<center>Questi dati verranno utilizzati per la creazione del vostro utente.</center>
							</div>
						@endif

						@if($message = Session::get('success'))
								<div class="alert alert-success alert-block">
									<strong>{{ __($message) }}</strong>
								</div>
						@endif
						<form method="post" action="{{ url('trial/send') }}">
							{{ csrf_field() }}
							<div class="row form-group">
								<div class="col-md-6">
									<!-- <label for="fname">First Name</label> -->
									<input type="text" id="name" name="name" class="form-control" placeholder="il tuo Nome">
								</div>
								<div class="col-md-6">
									<!-- <label for="lname">Last Name</label> -->
									<input type="text" id="surname" name="surname" class="form-control" placeholder="il tuo Cognome">
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
									<!-- <label for="subject">Subject</label> -->
									<input type="text" id="business_name" name="business_name" class="form-control" placeholder="il nome della tua attività. . .  esempio: Studio Dentistico Rossi">
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

</div>

@endsection
