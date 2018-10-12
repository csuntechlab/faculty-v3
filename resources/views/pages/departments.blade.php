@extends('layouts.master')


@section('content')


<div class="pb-1 bg-white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item active">All Departments</li>
            </ol>
        </nav>

    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="h3 pt-3 mb-5">All Departments</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12 pb-3">
                <a href="/search" class="card-department">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title h6 font-weight-normal">Academic First Year Experiences</h2>
                        </div>                           
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 pb-3">
                <a href="/search" class="card-department">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title h6 font-weight-normal">Acounting & Information Systems</h2>
                        </div>                           
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 pb-3">
                <a href="/search" class="card-department">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title h6 font-weight-normal">African Studies</h2>
                        </div>                           
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 pb-3">
                <a href="/search" class="card-department">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title h6 font-weight-normal">Asian American Studies</h2>
                        </div>                           
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 pb-3">
                <a href="/search" class="card-department">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title h6 font-weight-normal">American Indian Studies Program</h2>
                        </div>                           
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 pb-3">
                <a href="/search" class="card-department">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title h6 font-weight-normal">Anthropology</h2>
                        </div>                           
                    </div>
                </a>
            </div>

        </div>

        <div class="pt-5 mt-lg-4">
            <div class="row">
                <div class="col-12">
                    <a href="{{ url('search') }}">&#8592; Back to Search</a>
                </div>
            </div>
        </div>

    </div>
</div>




@stop

@section('page-specific-scripts')
<script>
$(function() {

});
</script>
@stop