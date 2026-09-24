@extends('layouts.app')

@section('title', $title)

@section('content')
    <section class="post-detail-page mx-auto max-w-3xl py-8 sm:py-12">
        <a href="{{ $backRoute }}" class="post-detail-back">← {{ $backLabel }}</a>
        <article class="post-detail-card">
            <p class="post-detail-category">{{ $category }}</p>
            <h1>{{ $title }}</h1>
            <p class="post-detail-description">{{ $description }}</p>
            <dl class="post-detail-meta">
                <div>
                    <dt>Lieu</dt>
                    <dd>{{ $location }}</dd>
                </div>
                @if ($date)
                    <div>
                        <dt>Date</dt>
                        <dd>{{ $date }}</dd>
                    </div>
                @endif
            </dl>
        </article>
    </section>
@endsection
