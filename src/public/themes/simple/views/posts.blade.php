@extends('simple::layouts.master')

@section('title', 'All Posts')

@section('content')
		
		<section class="container-fluid content-blue single-post">
			<div class="row">
				<div class="col-md-12">
					<h2 class="">All Posts</h2>
					@include('simple::partials.posts');
				</div>
			</div>
		</section>		

@endsection
