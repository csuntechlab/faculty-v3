@extends('layouts.master')


@section('content')

<main class="main py-5 my-5">
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
                    <div class="row justify-content-center">
                        <div class="col-lg-7 col-md-8 col-9 pr-0">
                            <input type="text" class="form-control form-control-lg pr-0 indexSearch__input" placeholder="Search by name..." aria-label="Faculty Name" aria-describedby="btn-search">
                        </div>
                        <div class="col-lg-1 col-md-2 col-3 pl-0">
                            <button type="button" class="indexSearch__btn btn btn-lg btn-primary btn-block" id="btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                    
                <div class="text-center">
                    <a href="/departments">Browse By Department</a> 
                </div>
            </div>
        </div>
    </div>
</main>

@stop

@section('page-specific-scripts')
<script>
$(function() {

});
</script>
@stop
