@extends('layouts.master')

@section('title')
{{ config('app.name') }}
@stop

@section('content')

<section class="py-3 py-md-5 my-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <!-- <div>
                    <a class="btn--feedback" href="https://www.csun.edu/faculty/scholarship/feedback" target="_blank">Give Feedback</a>
                </div> -->
                <div class="indexHeader">
                    <div class="text-center">
                        <div class="indexHeader__rise-arrow">
                            <div class="rise-arrow rise-arrow--2tone d-block mx-auto"></div>
                            <div class="rise-arrow rise-arrow--middle d-block mx-auto"></div>
                            <div class="rise-arrow rise-arrow--bottom d-block mx-auto"></div>
                        </div>
                        <div class="indexHeader__rise-arrow">
                            <div class="rise-arrow rise-arrow--2tone d-block mx-auto"></div>
                            <div class="rise-arrow rise-arrow--2tone d-block mx-auto"></div>
                            <div class="rise-arrow rise-arrow--middle d-block mx-auto"></div>
                            <div class="rise-arrow rise-arrow--bottom d-block mx-auto"></div>
                        </div>
                        <div class="indexHeader__rise-arrow">
                            <div class="rise-arrow rise-arrow--2tone d-block mx-auto"></div>
                            <div class="rise-arrow rise-arrow--middle d-block mx-auto"></div>
                            <div class="rise-arrow rise-arrow--bottom d-block mx-auto"></div>
                        </div>
                    </div>
                    <div class="indexHeader__title h1 text-center">Discover Faculty Members</div>
                </div>
                
                
                <div class="indexSearch mb-5">
                    {!! Form::open(['route' => 'search', 'method' => 'GET']) !!}
                    <div class="row justify-content-center">
                        <div class="col-lg-7 col-md-8 col-8 pr-0">
                            <input type="text" name="q" class="form-control form-control-lg pr-0 indexSearch__input" placeholder="Search by name..." aria-label="Faculty Name" aria-describedby="btn-search">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-4 pl-0">
                            <button type="submit" class="indexSearch__btn btn btn-lg btn-primary btn-block" id="btn-search"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                    
                <div class="text-center">
                    <a href="{{ route('departments') }}">Browse By Department</a> 
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('page-specific-scripts')
<script>
$(function() {

});
</script>
@stop
