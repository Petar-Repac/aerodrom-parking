<!DOCTYPE html>
<html lang="sr">
@include('partials.head.head')
<body>


<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">

    <!-- Blog Posts Section -->
    <section id="blog-posts" class="blog-posts section">
        <!-- Section Title -->
        <div class="container section-title aos-init aos-animate" data-aos="fade-up">
            <h2>Vesti</h2>
        </div><!-- End Section Title -->



        <div class="container">
            <div class="row gy-4">


                @if(count($articles ?? []) == 0)
                    <h3>No news so far...</h3>
                @else
                    @foreach($articles as $article)
                        <div class="col-lg-4">
                            <article>

                                <div class="post-img">
                                    @if($article['thumbnail'])
                                        <img
                                            src="https://cms.aeroparking.rs/assets/{{ $article['thumbnail']['id'] ?? ''}}?fit=cover&width=366&height=275&quality=60"
                                            alt="" loading="lazy"/>
                                    @else
                                        <img src="{{asset('assets/img/logo.png')}}" alt="" loading="lazy"/>
                                    @endif
                                </div>

                                <p class="post-category">

                                    @php
                                        $tagNames = [
                                            'most_read' => 'najčitanije',
                                            'advice' => 'saveti',
                                            'news' => 'vesti',
                                            'visa_guide' => 'vodič za vizu',
                                            'fun_facts' => 'zanimljivosti',
                                        ];
                                    @endphp

                                    @foreach($article['tags'] as $tag)
                                        <a href="{{ route('news.tag', ['tag' => $tag]) }}">  <span>{{$tagNames[$tag] ?? 'vesti'}} </span> </a>
                                    @endforeach
                                </p>

                                <h2 class="title">
                                    <a href="/blog/{{$article['slug']}}">{{$article['title']}}</a>
                                </h2>
                                <p>
                                    {{$article['lead']}}
                                </p>

                                <div class="d-flex align-items-center">
                                    {{--                                    <img src="assets/img/blog/blog-author.jpg" alt="" class="img-fluid post-author-img flex-shrink-0">--}}
                                    <div class="post-meta">
                                        {{--                                        <p class="post-author">Maria Doe</p>--}}
                                        <p class="post-date">
                                            <time datetime="{{ \Carbon\Carbon::parse($article['date_created'])->diffForHumans() }}">
                                                {{ \Carbon\Carbon::parse($article['date_created'])->diffForHumans() }}
                                            </time>
                                        </p>
                                    </div>
                                </div>

                            </article>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>

    </section><!-- /Blog Posts Section -->

    @include('partials.page-sections.cta')
</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.reservation-drawer')

@include('partials.common.scripts-homepage')

{{--@include('partials.util.theme-customizer')--}}
</body>

</html>
