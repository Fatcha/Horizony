@extends('layouts.app')


@section('content')

    <!-- Header -->
    <a name="about"></a>
    <div class="intro-header">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>{{ config('app.name', 'Laravel') }}</h1>
                        <h3>Pretest your candidates</h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <a href="{{route('register')}}" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Register</span></a>
                            </li>
                            {{--<li>--}}
                                {{--<a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#" class="btn btn-default btn-lg"><i class="fa fa-linkedin fa-fw"></i> <span class="network-name">Linkedin</span></a>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.intro-header -->

    <!-- Page Content -->

    {{--<a  name="services"></a>--}}
    {{--<div class="content-section-a">--}}

        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-lg-5 col-sm-6">--}}
                    {{--<hr class="section-heading-spacer">--}}
                    {{--<div class="clearfix"></div>--}}
                    {{--<h2 class="section-heading">Death to the Stock Photo:<br>Special Thanks</h2>--}}
                    {{--<p class="lead">A special thanks to <a target="_blank" href="http://join.deathtothestockphoto.com/">Death to the Stock Photo</a> for providing the photographs that you see in this template. Visit their website to become a member.</p>--}}
                {{--</div>--}}
                {{--<div class="col-lg-5 col-lg-offset-2 col-sm-6">--}}
                    {{--<img class="img-responsive" src="/layout/home-template/ipad.png" alt="">--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--<!-- /.container -->--}}

    {{--</div>--}}
    <!-- /.content-section-a -->

    <div class="content-section-b">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-lg-offset-1 col-sm-push-6  col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading" >Multiple tests available</h2>
                    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ultrices, arcu sit amet consectetur eleifend, mi nisl venenatis nisi, a placerat ante neque id lorem. Curabitur magna ex, tempus quis pulvinar ornare, tincidunt sed urna.
                    </p>
                </div>
                <div class="col-lg-5 col-sm-pull-6  col-sm-6">
                    <img class="img-responsive" src="/layout/home-template/test_tobuy.jpg" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-b -->

    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">In different language</h2>
                    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ultrices, arcu sit amet consectetur eleifend, mi nisl venenatis nisi, a placerat ante neque id lorem. Curabitur magna ex, tempus quis pulvinar ornare, tincidunt sed urna.</p>
                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="/layout/home-template/test_tobuy.jpg" alt="">
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->

    {{--<a  name="contact"></a>--}}
    {{--<div class="banner">--}}

        {{--<div class="container">--}}

            {{--<div class="row">--}}
                {{--<div class="col-lg-6">--}}
                    {{--<h2>Connect to Start Bootstrap:</h2>--}}
                {{--</div>--}}
                {{--<div class="col-lg-6">--}}
                    {{--<ul class="list-inline banner-social-buttons">--}}
                        {{--<li>--}}
                            {{--<a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="btn btn-default btn-lg"><i class="fa fa-linkedin fa-fw"></i> <span class="network-name">Linkedin</span></a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--<!-- /.container -->--}}

    {{--</div>--}}
    <!-- /.banner -->


@stop
