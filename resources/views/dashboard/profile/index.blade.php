
@extends('layouts.dashboard_modul')
@section('content')
@php
    $publicUrl = url('/').'/templates/scutum-admin/scutum_v2.1.0/admin/html/dist/';   
    $assetUrl = url('/').'/assets/img/';   
@endphp
<div class="uk-flex uk-flex-center">
    <div class="uk-width-5-5@l">
        <div data-uk-grid>
            <div class="uk-width-4-4@l">
                <div class="uk-card">
                    <div class="uk-card-body">
                        <div class="uk-text-center">
                            <img src="{{$assetUrl}}user.png" class="sc-avatar uk-margin-bottom" alt="citlalli25"/>                         
                        <h4 class="uk-card-title">{{$data->name}}</h4>
                        <span class="sc-color-secondary">{{$data->username}}</span>
                        </div>
                        <ul class="uk-list uk-list-divider">
                            <li class="sc-list-group">
                                <div class="sc-list-addon">
                                    <i class="mdi mdi-email"></i>
                                </div>
                                <div class="sc-list-body">
                                <div class="sc-list-body-inner">{{$data->email}}</div>
                                </div>
                            </li>
                            <li class="sc-list-group">
                                <div class="sc-list-addon">
                                    <i class="mdi mdi-phone"></i>
                                </div>
                                <div class="sc-list-body">
                                    {{$data->phone}}                                      
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand@l">
                <div class="uk-card">
                    <div class="uk-card-body">
                        <div class="uk-child-width-1-2@m uk-text-center" data-uk-grid>
                            <div>
                                <div class="sc-round sc-padding md-bg-grey-100">
                                    <h2 class="uk-margin-remove md-color-green-500">34 845</h2>
                                    <p class="sc-color-secondary uk-margin-remove">Followers</p>
                                </div>
                            </div>
                            <div>
                                <div class="sc-round sc-padding md-bg-grey-100">
                                    <h2 class="uk-margin-remove md-color-green-500">2 410</h2>
                                    <p class="sc-color-secondary uk-margin-remove">Following</p>
                                </div>
                            </div>
                            <div>
                                <div class="sc-round sc-padding md-bg-grey-100">
                                    <h2 class="uk-margin-remove md-color-green-500">148</h2>
                                    <p class="sc-color-secondary uk-margin-remove">Stories</p>
                                </div>
                            </div>
                            <div>
                                <div class="sc-round sc-padding md-bg-grey-100">
                                    <h2 class="uk-margin-remove md-color-red-500">31</h2>
                                    <p class="sc-color-secondary uk-margin-remove">Posts</p>
                                </div>
                            </div>
                        </div>

                        <h4 class="uk-heading-line uk-margin-large-top"><span>Friends</span></h4>
                        <div class="uk-flex uk-flex-wrap uk-grid-medium" data-uk-grid>
                            <div>
                                <a href="#" class="sc-avatar-wrapper">
                                    <span class="sc-user-status online"></span>
                                    <img src="{{$publicUrl}}assets/img/avatars/avatar_02_sm.png" class="sc-avatar " alt="timmy.greenfelder"/>                                        </a>
                            </div>
                            <div>
                                <a href="#" class="sc-avatar-wrapper">
                                    <span class="sc-user-status away"></span>
                                    <img src="{{$publicUrl}}assets/img/avatars/avatar_03_sm.png" class="sc-avatar " alt="arowe"/>                                        </a>
                            </div>
                            <div>
                                <a href="#" class="sc-avatar-wrapper">
                                    <span class="sc-user-status online"></span>
                                    <img src="{{$publicUrl}}assets/img/avatars/avatar_04_sm.png" class="sc-avatar " alt="hyost"/>                                        </a>
                            </div>
                            <div>
                                <a href="#" class="sc-avatar-wrapper">
                                    <span class="sc-user-status busy"></span>
                                    <img src="{{$publicUrl}}assets/img/avatars/avatar_05_sm.png" class="sc-avatar " alt="fletcher.gislason"/>                                        </a>
                            </div>
                        </div>

                        <h4 class="uk-heading-line uk-margin-large-top"><span>Comments</span></h4>
                        <div class="sc-round md-bg-grey-100 sc-padding">
                            <ul class="uk-list uk-list-divider uk-margin-bottom sc-list-align">
                                <li class="sc-list-group">
                                    <div class="sc-list-body">
                                        <p class="uk-margin-remove uk-text-small uk-text-meta">14/11/2019 14:31</p>
                                        <a href="#" class="sc-link uk-text-large uk-text-truncate uk-display-block">Culpa odio dolorum voluptatum impedit.</a>
                                        <p class="uk-margin-remove uk-text-wrap">Quia aut veritatis saepe perferendis rerum voluptatem tempore quia illo laudantium aspernatur quam soluta.</p>
                                    </div>
                                </li>
                                <li class="sc-list-group">
                                    <div class="sc-list-body">
                                        <p class="uk-margin-remove uk-text-small uk-text-meta">16/11/2019 08:45</p>
                                        <a href="#" class="sc-link uk-text-large uk-text-truncate uk-display-block">Hic sed dicta atque.</a>
                                        <p class="uk-margin-remove uk-text-wrap">Sunt nihil magni quis tempora et id cum et eum voluptatibus voluptas quia recusandae ratione blanditiis ducimus non commodi nemo voluptatem odit porro dolores assumenda enim.</p>
                                    </div>
                                </li>
                                <li class="sc-list-group">
                                    <div class="sc-list-body">
                                        <p class="uk-margin-remove uk-text-small uk-text-meta">28/11/2019 20:11</p>
                                        <a href="#" class="sc-link uk-text-large uk-text-truncate uk-display-block">Nihil qui nulla voluptatem voluptatem.</a>
                                        <p class="uk-margin-remove uk-text-wrap">Quisquam voluptatem maiores aut quis eveniet iusto corporis sapiente beatae aut sed est ratione ut perferendis ut impedit exercitationem ad sunt.</p>
                                    </div>
                                </li>
                            </ul>
                            <button class="sc-button sc-button-small">More comments</button>
                        </div>

                        <h4 class="uk-heading-line uk-margin-large-top"><span>Timeline</span></h4>
                        <div class="sc-timeline">
                            <div class="sc-timeline-item">
                                <div class="sc-timeline-date">17 Sep</div>
                                <div class="sc-timeline-icon md-bg-red-500 sc-light">
                                    <i class="mdi mdi-image"></i>
                                </div>
                                <div class="sc-timeline-body sc-timeline-body-border">
                                    <h4 class="sc-timeline-header">Created New Album</h4>
                                    <hr>
                                    <div class="sc-timeline-content">
                                        <ul class="sc-list-images uk-list uk-list-inline">
                                            <li><img src="{{$publicUrl}}assets/img/photos/paula-brustur-766878-unsplash_md.jpg" class="" alt="paula-brustur-766878-unsplash"/></li>
                                            <li><img src="{{$publicUrl}}assets/img/photos/avantgarde-concept-763896-unsplash_md.jpg" class="" alt="avantgarde-concept-763896-unsplash"/></li>
                                            <li><img src="{{$publicUrl}}assets/img/photos/briana-tozour-756151-unsplash_md.jpg" class="" alt="briana-tozour-756151-unsplash"/></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="sc-timeline-item">
                                <div class="sc-timeline-date">16 Sep</div>
                                <div class="sc-timeline-icon md-bg-green-500 sc-light">
                                    <i class="mdi mdi-file-document"></i>
                                </div>
                                <div class="sc-timeline-body sc-timeline-body-border">
                                    <h4 class="sc-timeline-header">Added New posts in <a href="#">Businness</a> category</h4>
                                    <span class="sc-timeline-meta">23 comments; 14 pingbacks</span>
                                    <hr>
                                    <div class="sc-timeline-content">
                                        Eum consequatur neque molestiae quia distinctio iste sint quisquam officiis ea quo excepturi dolor ducimus nisi minus ut qui voluptates eos ipsam tempore fuga molestias natus.                                            </div>
                                </div>
                            </div>
                            <div class="sc-timeline-item">
                                <div class="sc-timeline-date">15 Sep</div>
                                <div class="sc-timeline-icon md-bg-light-blue-500 sc-light">
                                    <i class="mdi mdi-comment"></i>
                                </div>
                                <div class="sc-timeline-body uk-box-shadow-small">
                                    <h4 class="sc-timeline-header">Added 3 commments</h4>
                                    <span class="sc-timeline-meta"></span>
                                    <div class="sc-timeline-content"></div>
                                </div>
                            </div>
                            <div class="sc-timeline-item">
                                <div class="sc-timeline-date">14 Sep</div>
                                <div class="sc-timeline-icon md-bg-amber-500 sc-light">
                                    <i class="mdi mdi-calendar-check"></i>
                                </div>
                                <div class="sc-timeline-body md-bg-grey-100">
                                    <h4 class="sc-timeline-header">Completed 2 tasks</h4>
                                    <div class="sc-timeline-content">
                                        <ul class="sc-list-shadow uk-margin-top">
                                            <li>
                                                <a href="#">Molestiae fuga labore autem numquam ad.</a>
                                                <p class="sc-list-secondary-text uk-text-small">Logged: 2h 12m</p>
                                            </li>
                                            <li><a href="#">Consequatur laborum repudiandae recusandae et.</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="uk-heading-line uk-margin-large-top"><span>Notes</span></h4>
                        <p>{{$data->self_description}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
@endpush
@endsection