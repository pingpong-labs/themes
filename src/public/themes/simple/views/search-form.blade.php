@extends('simple::layouts.master')

@section('title')
	Search : {{ site('name') }}
@endsection

@section('content')

<section class="container-fluid single-post">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
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
	</div>
</section>

@endsection