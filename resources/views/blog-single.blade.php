<!DOCTYPE html>
<html lang="sr">
@include('partials.head.head')
<body>


<!-- ======= Header ======= -->
@include('partials.common.header')

<main id="main">


    <!-- Page Title -->
    <div class="page-title dark-background">
        <div class="container position-relative">
            <h1> {{ $article['title'] ?? '' }} </h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Početna</a></li>
                    <li class="current"> {{ $article['title'] ?? '' }} </li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <div class="container">
        <div class="row">

            <div class="col-lg-8">

                <!-- Blog Details Section -->
                <section id="blog-details" class="blog-details section">
                    <div class="container">

                        <article class="article">

                            <div class="post-img">
                                <img src="https://cms.aeroparking.rs/assets/{{ $article['thumbnail']['id'] ?? ''}}"
                                     alt="" class="img-fluid">
                            </div>

                            <h3 class="title">{{ $article['lead'] ?? '' }} </h3>

                            <div class="meta-top">
                                <ul>
                                    <li class="post-category d-inline-flex align-items-center" data-aos="fade-up" data-aos-delay="100">
                             <span class="material-symbols-outlined">
                                           sports_tennis
                             </span>
                                        <span class="tennis-category">Tennis</span>
                                    </li>

                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <time
                                            datetime="{{ \Carbon\Carbon::parse($article['date_created'])->diffForHumans() }}">
                                            {{ \Carbon\Carbon::parse($article['date_created'])->diffForHumans() }}
                                        </time></li>
                                </ul>
                            </div><!-- End meta top -->

                            <div class="content">
                                {!! $article['content'] ?? '' !!}
                            </div><!-- End post content -->

                            <div class="meta-bottom">
                                <i class="bi bi-tags"></i>
                                <ul class="tags">

                                    @foreach($article['tags'] as $tag)
                                        <li><a href="{{ route('news.tag', ['tag' => $tag]) }}">{{ucwords($tag)}}</a></li>
                                    @endforeach

                                </ul>
                            </div><!-- End meta bottom -->

                        </article>

                    </div>
                </section><!-- /Blog Details Section -->
            </div>

            <div class="col-lg-4 sidebar">


            </div>

        </div>
    </div>
</main><!-- End #main -->

@include('partials.common.footer')

@include('partials.common.reservation-drawer')

@include('partials.common.scripts-homepage')

@include('partials.util.theme-customizer')
</body>

</html>
