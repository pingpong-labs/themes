@extends('simple::layouts.master')

@section('title')
	{{ t('search.results') }}
	{{ $q }}
	{{ $posts->getTotal() ? "(".$posts->getTotal().")":'' }}
@endsection

@section('content')
	
<section class="container-fluid content-blue single-post">
	<div class="row">
		<div class="row col-md-12">
			{{ Form::open(['route' => 'search', 'class' => 'navbar-form', 'method' => 'GET', 'role' => 'search']) }}
		  	<h3>
		  		Find something:
		  	</h3>
			<div class="input-group input-group-lg">
			  	{{ Form::text('q', null, ['class' => 'form-control', 'placeholder' => t('search.placeholder')]) }}
			    <div class="input-group-btn">
			        <button class="btn btn-default" type="submit">
			          <i class="glyphicon glyphicon-search"></i>
			        </button>
			    </div>
			</div>
			{{ Form::close() }}
		</div>
		<div class="col-md-12">
		<h2>
			{{ t('search.results') }}
			<b>{{ $q }}</b>
			{{ $posts->getTotal() ? "(".$posts->getTotal().")":'' }}
		</h2>

		@if($posts->count())
			@include('simple::partials.posts', compact('posts'))
		@else
			<h3>
				Nothing found for <b>{{ $q }}</b>
			</h3>
		@endif
		</div>
	</div>
</section>
@endsection