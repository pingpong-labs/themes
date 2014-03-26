@extends('simple::layouts.master')

@section('content')
	<div id="bl-main" class="bl-main">
		<section>
			<div class="bl-box">
				<h2 class="bl-icon bl-icon-about">About</h2>
			</div>
			<div class="bl-content">
				<h2>About Me</h2>
				<p>
					{{ Shortcode::compile('[post-content id="5"]') }}
				</p>
			</div>
			<span class="bl-icon bl-icon-close"></span>
		</section>
		<section id="bl-work-section">
			<div class="bl-box">
				<h2 class="bl-icon bl-icon-works">Works</h2>
			</div>
			<div class="bl-content">
				<h2>My Works</h2>
				<p>Mung bean maize dandelion sea lettuce catsear bunya nuts ricebean tatsoi caulie horseradish pea.</p>
				<ul id="bl-work-items">
					<li data-panel="panel-1"><a href="#"><img src="{{ Theme::asset('images/1.jpg') }}" /></a></li>
					<li data-panel="panel-2"><a href="#"><img src="{{ Theme::asset('images/2.jpg') }}" /></a></li>
					<li data-panel="panel-3"><a href="#"><img src="{{ Theme::asset('images/3.jpg') }}" /></a></li>
					<li data-panel="panel-4"><a href="#"><img src="{{ Theme::asset('images/4.jpg') }}" /></a></li>
				</ul>
			</div>
			<span class="bl-icon bl-icon-close"></span>
		</section>
		<section>
			<div class="bl-box">
				<h2 class="bl-icon bl-icon-blog">Blog</h2>
			</div>
			<div class="bl-content">
				<h2 class="">Latest Posts</h2>
				<?php
				$posts->setBaseUrl('posts');
				?>
				@foreach($posts as $post)
				<article>
					<h3>{{ $post->title }}</h3>
					<p>
						{{ $post->content }}
						<a href="{{ $post->permalink }}">Read more</a>
					</p>
				</article>
				@endforeach
				<div class="text-center pager-post">
					{{ $posts->links('pagination::simple') }}
				</div>
			</div>
			<span class="bl-icon bl-icon-close"></span>
		</section>
		<section>
			<div class="bl-box">
				<h2 class="bl-icon bl-icon-contact">Contact</h2>
			</div>
			<div class="bl-content">
				<!-- uncomment this to enable google map
				<h2 class="bl-heading">Get In Touch</h2>
				<div class="maps">
				 <iframe width="100%" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?t=m&amp;hl=en-US&amp;gl=US&amp;mapclient=embed&amp;q=Bandung+West+Java+Indonesia&amp;ie=UTF8&amp;hq=&amp;hnear=Bandung,+West+Java,+Indonesia&amp;z=12&amp;ll=-6.914864,107.725487&amp;output=embed"></iframe><br />
				</div> -->
				<h2 class="bl-contact-heading">Contact Me</h2>
				<form class="row contact-form">
					<div class="col-md-6">
						<div class="form-group">
							<label>Name:</label>
							<input placeholder="Name" type="text" id="name" class="form-control">
						</div>
						<div class="form-group">
							<label>Email:</label>
							<input placeholder="Email" type="email" id="email" class="form-control">
						</div>
						<div class="form-group">
							<label>Subject:</label>
							<input placeholder="Subject" type="text" id="subject" class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Message:</label>
							<textarea rows="6" id="name" placeholder="Message" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<button class="btn btn-submit">
								Send Message
							</button>
						</div>
					</div>
				</form>									
			</div>
			<span class="bl-icon bl-icon-close"></span>
		</section>
		<!-- Panel items for the works -->
		<div class="bl-panel-items" id="bl-panel-work-items">
			<div data-panel="panel-1">
				<div>
					<img src="{{ Theme::asset('images/1.jpg') }}" />
					<h3>Fixie bespoke</h3>
					<p>Iphone artisan direct trade ethical Austin. Fixie bespoke banh mi ugh, deep v vinyl hashtag. Tumblr gentrify keffiyeh pop-up iphone twee biodiesel. Occupy american apparel freegan cliche. Mustache trust fund 8-bit jean shorts mumblecore thundercats. Pour-over small batch forage cray, banjo post-ironic flannel keffiyeh cred ethnic semiotics next level tousled fashion axe. Sustainable cardigan keytar fap bushwick bespoke.</p>
				</div>
			</div>
			<div data-panel="panel-2">
				<div>
					<img src="{{ Theme::asset('images/2.jpg') }}" />
					<h3>Chillwave mustache</h3>
					<p>Squid vinyl scenester literally pug, hashtag tofu try-hard typewriter polaroid craft beer mlkshk cardigan photo booth PBR. Chillwave 90's gentrify american apparel carles disrupt. Pinterest semiotics single-origin coffee craft beer thundercats irony, tumblr bushwick intelligentsia pickled. Narwhal mustache godard master cleanse street art, occupy ugh selfies put a bird on it cray salvia four loko gluten-free shoreditch.</p>
				</div>
			</div>
			<div data-panel="panel-3">
				<div>
					<img src="{{ Theme::asset('images/3.jpg') }}" />
					<h3>Austin hella</h3>
					<p>Ethical cray wayfarers leggings vice, seitan banksy small batch ethnic master cleanse. Pug chillwave etsy, scenester meh occupy blue bottle tousled blog tonx pinterest selvage mixtape swag cosby sweater. Synth tousled direct trade, hella Austin craft beer ugh chambray.</p>
				</div>
			</div>
			<div data-panel="panel-4">
				<div>
					<img src="{{ Theme::asset('images/4.jpg') }}" />
					<h3>Brooklyn dreamcatcher</h3>
					<p>Fashion axe 90's pug fap. Blog wayfarers brooklyn dreamcatcher, bicycle rights retro YOLO. Wes anderson lomo 90's food truck 3 wolf moon, twee jean shorts. Iphone small batch twee wolf yr before they sold out. Brooklyn echo park cred, portland pug selvage flannel seitan tousled mcsweeney's.</p>
				</div>
			</div>
			<nav>
				<span class="bl-next-work">&gt; Next Project</span>
				<span class="bl-icon bl-icon-close"></span>
			</nav>
		</div>
	</div>
</div><!-- /container -->

@endsection
