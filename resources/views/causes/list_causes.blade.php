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
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="probootstrap-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center section-heading probootstrap-animate" data-animate-effect="fadeIn">
                    <h2>Donate For A Causes</h2>
                    <p class="lead">Sed a repudiandae impedit voluptate nam Deleniti dignissimos perspiciatis nostrum
                        porro nesciunt</p>
                </div>
            </div>
            <div class="row">
                @if (count($donations) == 0)
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p>No Donations Present At The Moment</p>
                        </div>
                    </div>
                @else
                    @foreach ($donations as $donation)
                        <div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 probootstrap-animate"
                            data-animate-effect="fadeIn">
                            <div class="probootstrap-image-text-block probootstrap-cause">
                                <figure>
                                    <img src="/img/img_sm_1.jpg" alt="cause cover image" class="img-responsive">
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

                                    <h2 style="height: 50px; overflow: hidden;">
                                        <a href="{{ route('cause.details', ['id' => $donation->id]) }}">
                                            {{ Str::words($donation->title, 8, '...') }}
                                        </a>
                                    </h2>

                                    <div class="probootstrap-date">
                                        <i class="icon-calendar"></i>
                                        <span style="text-transform: capitalize;" class="relative-time"
                                            data-timestamp="{{ $donation->due_date }}"></span>
                                    </div>

                                    <p style="height: 100px; overflow: hidden;">
                                        {{ Str::words($donation->description, 15, '...') }}</p>
                                    <p><a href="{{ route('cause.details', ['id' => $donation->id]) }}"
                                            class="btn btn-primary btn-black">View Details</a></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            @if ($donations->hasPages())
                <div class="text-center">
                    {{ $donations->onEachSide(5)->links() }}
                </div>
            @endif
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
                @if (count($recentDonations) == 0)
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p>No Recorded Donation Activity</p>
                        </div>
                    </div>
                @else
                    @foreach ($recentDonations as $userDonation)
                        <div class="col-md-3">
                            <div class="probootstrap-donors text-center probootstrap-animate">
                                <figure class="media">
                                    <img src="/img/person_6.jpg" alt="cause cover image" class="img-responsive">
                                </figure>
                                <div class="text">
                                    <h3>{{ Str::limit($userDonation->user->name, 16, '..') }}</h3>
                                    <p class="donated">Donated <span class="money">${{ $userDonation->amount }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
</x-app-layout>
