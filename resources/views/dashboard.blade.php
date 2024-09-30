@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <section class="probootstrap-hero" style="background-image: url(/img/hero_bg_bw_1.jpg)"
        data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="probootstrap-slider-text probootstrap-animate" data-animate-effect="fadeIn">
                        <h1 class="probootstrap-heading probootstrap-animate">Donate <span>Together we can make a
                                difference</span></h1>
                        <p class="probootstrap-animate"><a href="/causes" class="btn btn-primary btn-lg">Donate Now</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="probootstrap-service-intro">
            <div class="container">
                <div class="probootstrap-service-intro-flex">
                    <div class="item probootstrap-animate" data-animate-effect="fadeIn">
                        <div class="icon">
                            <i class="icon-wallet"></i>
                        </div>
                        <div class="text">
                            <h2>Give Donation</h2>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                            <p><a href="#">Lear More</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center section-heading probootstrap-animate" data-animate-effect="fadeIn">
                    <h2>Most Popular Causes</h2>
                    <p class="lead">Sed a repudiandae impedit voluptate nam Deleniti dignissimos perspiciatis nostrum
                        porro nesciunt</p>
                </div>
            </div>
            <div class="row">
                @foreach ($popularDonations as $donation)
                    <div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 probootstrap-animate"
                        data-animate-effect="fadeIn">
                        <div class="probootstrap-image-text-block probootstrap-cause">
                            <figure>
                                <img src="/img/img_sm_1.jpg" alt="cause cover image"
                                    class="img-responsive">
                            </figure>
                            <div class="probootstrap-cause-inner">
                                <div class="progress">
                                    @php
                                        // Calculate the percentage and ensure it's capped at 100%
                                        $percentage = round(
                                            ($donation->amount_received / $donation->target_amount) * 100,
                                            1,
                                        );
                                        $percentage = $percentage > 100 ? 100 : $percentage; // Cap at 100%
                                    @endphp

                                    <div class="progress-bar progress-bar-s2" data-percent="{{ $percentage }}">
                                    </div>
                                </div>

                                <div class="row mb30">
                                    <div class="col-md-6 col-sm-6 col-xs-6 probootstrap-raised">Raised: <span
                                            class="money">$ {{ $donation->amount_received }}</span></div>
                                    <div class="col-md-6 col-sm-6 col-xs-6 probootstrap-goal">Goal: <span
                                            class="money">${{ $donation->target_amount }}</span></div>
                                </div>

                                <h2 style="height: 50px; overflow: hidden;"><a
                                        href="#">{{ Str::words($donation->title, 8, '...') }}</a></h2>
                                {{-- <div class="probootstrap-date"><i class="icon-calendar"></i> 2 hours remaining</div> --}}

                                <div class="probootstrap-date">
                                    <i class="icon-calendar"></i>
                                    <span style="text-transform: capitalize;"  class="relative-time" data-timestamp="{{ $donation->due_date }}"></span>
                                </div>

                                <p style="height: 100px; overflow: hidden;">
                                    {{ Str::words($donation->description, 15, '...') }}</p>
                                <p><a href="{{ route('cause.details', ['id' => $donation->id]) }}"
                                        class="btn btn-primary btn-black">View Details</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>Save the future for the little children by donating. <a href="causes.html">See all causes</a>
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="probootstrap-section probootstrap-bg probootstrap-section-dark"
        style="background-image: url(/img/hero_bg_bw_1.jpg)" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center section-heading probootstrap-animate" data-animate-effect="fadeIn">
                    <h2>Latest Donations</h2>
                    <p class="lead">Sed a repudiandae impedit voluptate nam Deleniti dignissimos perspiciatis nostrum
                        porro nesciunt</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="probootstrap-donors text-center probootstrap-animate">
                        <figure class="media">
                            <img src="/img/person_6.jpg" alt="cause cover image"
                                class="img-responsive">
                        </figure>
                        <div class="text">
                            <h3>Linda Reyez</h3>
                            <p class="donated">Donated <span class="money">$500.00</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="probootstrap-donors text-center probootstrap-animate">
                        <figure class="media">
                            <img src="/img/person_1.jpg" alt="cause cover image"
                                class="img-responsive">
                        </figure>
                        <div class="text">
                            <h3>Chris Worth</h3>
                            <p class="donated">Donated <span class="money">$1,500.00</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="probootstrap-donors text-center probootstrap-animate">
                        <figure class="media">
                            <img src="/img/person_5.jpg" alt="cause cover image"
                                class="img-responsive">
                        </figure>
                        <div class="text">
                            <h3>Janet Morris</h3>
                            <p class="donated">Donated <span class="money">$250.00</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="probootstrap-donors text-center probootstrap-animate">
                        <figure class="media">
                            <img src="/img/person_7.jpg" alt="cause cover image"
                                class="img-responsive">
                        </figure>
                        <div class="text">
                            <h3>Jessa Sy</h3>
                            <p class="donated">Donated <span class="money">$400.00</span></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="probootstrap-section  probootstrap-section-colored">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center section-heading probootstrap-animate">
                    <h2>What People Says</h2>
                    <p class="lead">Sed a repudiandae impedit voluptate nam Deleniti dignissimos perspiciatis nostrum
                        porro nesciunt</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 probootstrap-animate">
                    <div class="owl-carousel owl-carousel-testimony owl-carousel-fullwidth">
                        <div class="item">

                            <div class="probootstrap-testimony-wrap text-center">
                                <figure>
                                    <img src="/img/person_1.jpg" alt="cause cover image">
                                </figure>
                                <blockquote class="quote">&ldquo;Design must be functional and functionality must be
                                    translated into visual aesthetics, without any reliance on gimmicks that have to be
                                    explained.&rdquo; <cite class="author"> &mdash; <span>Mike Fisher</span></cite>
                                </blockquote>
                            </div>

                        </div>
                        <div class="item">
                            <div class="probootstrap-testimony-wrap text-center">
                                <figure>
                                    <img src="/img/person_2.jpg" alt="cause cover image">
                                </figure>
                                <blockquote class="quote">&ldquo;Creativity is just connecting things. When you ask
                                    creative people how they did something, they feel a little guilty because they
                                    didn’t really do it, they just saw something. It seemed obvious to them after a
                                    while.&rdquo; <cite class="author"> &mdash;<span>Jorge Smith</span></cite>
                                </blockquote>
                            </div>
                        </div>
                        <div class="item">
                            <div class="probootstrap-testimony-wrap text-center">
                                <figure>
                                    <img src="/img/person_3.jpg" alt="cause cover image">
                                </figure>
                                <blockquote class="quote">&ldquo;I think design would be better if designers were much
                                    more skeptical about its applications. If you believe in the potency of your craft,
                                    where you choose to dole it out is not something to take lightly.&rdquo; <cite
                                        class="author">&mdash; <span>Brandon White</span></cite></blockquote>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
