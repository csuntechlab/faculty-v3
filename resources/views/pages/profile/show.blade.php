@extends('layouts.master')

{{-- META TAGS 4 SEO --}}
@section('title')
	{{ $user->display_name }}
@stop

@section('description')
	{{ $user->biography }}
@stop

@section('content')
<p>Placeholder</p>
@stop