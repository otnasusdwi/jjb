@extends('layouts.landing')

@section('head')
    <title>{{ $aboutPage?->meta_title ?? ($aboutPage?->title ?? 'About Us') }} | JJB Travel Services</title>
    <meta name="description" content="{{ $aboutPage?->meta_description ?? 'Learn more about JJB Travel Bali and the people crafting your journeys.' }}">
    <link rel="stylesheet" href="{{ asset('css/landing-about.css') }}">
@endsection

@php
    $heroImage = $aboutPage?->hero_image ? asset('storage/' . $aboutPage->hero_image) : null;
    $summaryCopy = $aboutPage?->meta_description
        ?: ($aboutPage?->description ? Str::limit(strip_tags($aboutPage->description), 180) : 'Indonesia-first journeys designed with care and local expertise.');
@endphp

@section('content')
<section class="about-hero" @if($heroImage) style="background-image: linear-gradient(120deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.7) 100%), url('{{ $heroImage }}');" @endif>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="about-kicker">About JJB Travel</div>
                <h1 class="about-title">{{ $aboutPage?->title ?? 'About Us' }}</h1>
                <p class="about-lead">{{ $summaryCopy }}</p>

                <div class="hero-stats">
                    @if(isset($teamMembers) && $teamMembers->count() > 0)
                    <div class="stat-card">
                        <div class="stat-label">Our Team</div>
                        <div class="stat-number">{{ $teamMembers->count() }}+</div>
                        <p class="stat-copy">Travel specialists shaping bespoke journeys</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@if($aboutPage && ($aboutPage->description || $aboutPage->mission || $aboutPage->vision))
<section class="section-spacing">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-7">
                <div class="content-card">
                    <div class="eyebrow">Who We Are</div>
                    <div class="about-body">
                        {!! $aboutPage->description ?: '<p>Curated experiences across Java, Bali, Lombok, and Labuan Bajo with local expertise at every turn.</p>' !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="accent-card">
                    <div class="accent-header">
                        <span class="accent-icon"><i class="bi bi-compass"></i></span>
                        <div>
                            <p class="accent-kicker mb-1">Guided by purpose</p>
                            <h3 class="accent-title mb-0">What drives us</h3>
                        </div>
                    </div>
                    <div class="pill-list">
                        @if($aboutPage->meta_title)
                        <div class="pill">
                            <span class="pill-label">Promise</span>
                            <p class="pill-copy">{{ $aboutPage->meta_title }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($aboutPage?->story)
<section class="story-highlight section-spacing">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="eyebrow light">Our Story</div>
                <h2 class="story-title">Shaped by Indonesia, crafted for you</h2>
                <div class="story-copy">
                    {!! $aboutPage->story !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="glow-card">
                    <div class="glow-card-inner">
                        <span class="badge-soft">Trusted Companions</span>
                        <p class="mb-0">From the first hello to the final farewell, we choreograph every detail so you can stay present with Indonesia&#39;s beauty.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($aboutPage && ($aboutPage->mission || $aboutPage->vision))
<section class="section-spacing values-section">
    <div class="container">
        <div class="row g-4">
            @if($aboutPage->mission)
            <div class="col-lg-6">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-bullseye"></i></div>
                    <div>
                        <h3 class="value-title">Our Mission</h3>
                        <div class="value-copy">{!! $aboutPage->mission !!}</div>
                    </div>
                </div>
            </div>
            @endif
            @if($aboutPage->vision)
            <div class="col-lg-6">
                <div class="value-card">
                    <div class="value-icon"><i class="bi bi-eye"></i></div>
                    <div>
                        <h3 class="value-title">Our Vision</h3>
                        <div class="value-copy">{!! $aboutPage->vision !!}</div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

@if($aboutPage && ($aboutPage->ceo_name || $aboutPage->ceo_image || $aboutPage->ceo_message))
<section class="ceo-highlight section-spacing">
    <div class="container">
        <div class="row align-items-center g-4">
            @if($aboutPage->ceo_image)
            <div class="col-lg-4">
                <div class="ceo-photo">
                    <img src="{{ asset('storage/' . $aboutPage->ceo_image) }}" alt="{{ $aboutPage->ceo_name ?? 'CEO' }}">
                </div>
            </div>
            @endif
            <div class="col-lg-8">
                <div class="ceo-card">
                    <div class="eyebrow">Leadership Note</div>
                    @if($aboutPage->ceo_name)
                    <h3 class="ceo-name mb-1">{{ $aboutPage->ceo_name }}</h3>
                    @endif
                    @if($aboutPage->ceo_position)
                    <p class="ceo-role">{{ $aboutPage->ceo_position }}</p>
                    @endif
                    @if($aboutPage->ceo_message)
                    <blockquote class="ceo-quote">{!! $aboutPage->ceo_message !!}</blockquote>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($teamMembers->count() > 0)
<section class="team-section section-spacing">
    <div class="container">
        <div class="section-header text-center">
            <div class="eyebrow">People of JJB</div>
            <h2 class="section-title">Meet the team</h2>
            <p class="section-subtitle">A collective of on-ground experts bringing Indonesia closer to you.</p>
        </div>

        <div class="row g-4">
            @foreach($teamMembers as $member)
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="team-card">
                    <div class="avatar">
                        @if($member->image)
                            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}">
                        @else
                            <div class="avatar-placeholder"><i class="bi bi-person"></i></div>
                        @endif
                    </div>
                    <h4 class="member-name">{{ $member->name }}</h4>
                    <p class="member-role">{{ $member->position }}</p>
                    @if($member->bio)
                    <p class="member-bio">{!! Str::limit($member->bio, 110) !!}</p>
                    @endif
                    @if($member->email || $member->phone || $member->linkedin || $member->instagram)
                    <div class="member-links">
                        @if($member->email)
                        <a href="mailto:{{ $member->email }}" title="Email"><i class="bi bi-envelope"></i></a>
                        @endif
                        @if($member->phone)
                        <a href="tel:{{ $member->phone }}" title="Call"><i class="bi bi-telephone"></i></a>
                        @endif
                        @if($member->linkedin)
                        <a href="{{ $member->linkedin }}" target="_blank" rel="noopener" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        @endif
                        @if($member->instagram)
                        <a href="https://instagram.com/{{ ltrim($member->instagram, '@') }}" target="_blank" rel="noopener" title="Instagram"><i class="bi bi-instagram"></i></a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
