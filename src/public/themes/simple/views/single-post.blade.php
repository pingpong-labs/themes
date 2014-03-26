@extends('simple::layouts.master')

@section('title')
	{{ $post->title }}
@stop

@section('content')
		
		<section class="container-fluid content-red single-post">
			<div class="row">
				<div class="pull-left">
					{{ $post->gravatar }}
				</div>
				<div class="col-md-10">
					<h1 class="clearfix">
						{{ $post->title }}
					</h1>
					<div class="col-xs-12 row col-sm-12 col-md-12 pull-left">
						<ul class="list-inline">
							<li>
								<i class="glyphicon glyphicon-calendar"></i>
								&nbsp;<span>{{ $post->created_at->format('m/d/Y') }}</span>
							</li>
							<li>
								<i class="glyphicon glyphicon-time"></i>
								&nbsp;<span>{{ $post->created_at->format('h:i a') }}</span>
							</li>
							<li>
								<i class="glyphicon glyphicon-user"></i>
								&nbsp;<span>{{ $post->author }}</span>
							</li>
							<li>
								<i title="" class="glyphicon glyphicon-tag"></i>
								&nbsp;<span>{{ $post->category }}</span>
							</li>
							<li>
								<i title="" class="glyphicon glyphicon-tags"></i>
								&nbsp;
								@foreach($post->tags as $tag)
									{{ $tag->name }}
								@endforeach
							</li>
							@if(Auth::check())
							<li>
								<a href="{{ url('admin/posts/'.$post->id.'/edit') }}">
									<i class="glyphicon glyphicon-edit"></i>
									Edit
								</a>
							</li>
							@endif
						</ul>
					</div>
				</div>
				</div>
			<h3 class="heading">{{ $post->title }}</h2>
			<div class="content">
				<div class="body">
					{{ $post->content(true) }}
				</div>
				<!--  comments box -->
				<div class="comments">						
					<div id="disqus_thread"></div>
				    <script type="text/javascript">
				        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
				        var disqus_shortname = 'gravitano'; // required: replace example with your forum shortname

				        /* * * DON'T EDIT BELOW THIS LINE * * */
				        (function() {
				            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				        })();
				    </script>
				    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
				    <a href="http://disqus.com" class="dsq-brlink">Comments powered by <span class="logo-disqus">Disqus</span></a>
				</div>
			</div>
		</section>		

@endsection
