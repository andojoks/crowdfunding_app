@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <section class="probootstrap-section">
        <div class="container">
            <div class="row mt40">
                <div class="col-md-12 text-center section-heading probootstrap-animate" data-animate-effect="fadeIn">
                    <h2>Create And Manage Donation Causes</h2>
                </div>
            </div>

            <div class=" text-center mb10 probootstrap-animate" data-animate-effect="fadeIn">
                <a href="{{ route('causes.create') }}" class="btn btn-primary btn-lg">Add Donation Cause</a>
            </div>

            <div class="row">
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
                                    <a href="{{ route('causes.view_cause', ['id' => $donation->id]) }}">
                                        {{ Str::words($donation->title, 8, '...') }}
                                    </a>
                                </h2>

                                <div class="probootstrap-date"><i class="icon-calendar"></i> 2 hours remaining</div>

                                <p style="height: 100px; overflow: hidden;">
                                    {{ Str::words($donation->description, 15, '...') }}</p>
                                <p><a href="{{ route('causes.view_cause', ['id' => $donation->id]) }}"
                                        class="btn btn-primary btn-black">View Details</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($donations->hasPages())
                <div class="text-center">
                    {{ $donations->onEachSide(5)->links() }}
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
