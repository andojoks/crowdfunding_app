@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <section class="probootstrap-section">
        <div class="container">
            <div class="row probootstrap-gutter60 mt40">

                <div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 probootstrap-animate" data-animate-effect="fadeIn"
                    style="position: sticky; top: 20px;">
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

                            <div class="probootstrap-date">
                                <i class="icon-calendar"></i>
                                <span style="text-transform: capitalize;" class="relative-time"
                                    data-timestamp="{{ $donation->due_date }}"></span>
                            </div>

                            <p>Created By {{ $donation->user->name }}</p>


                            @auth
                                @if ($donation->status != 'completed')
                                    <div class="mt10">
                                        <form action="{{ route('cause.donate', ['id' => $donation->id]) }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <input type="number" name="amount" id="amount"
                                                    class="border border-gray-300 p-2 rounded-lg w-full" min="1"
                                                    step="0.01" placeholder="Enter donation amount" required>
                                            </div>

                                            <div class=" text-center">
                                                <button type="submit" class="btn btn-primary btn btn-lg">
                                                    Make Donation
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                            @guest
                                <p class="mt10 text-error">Please sign-in to make a donation to this cause</p>
                            @endguest
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8 probootstrap-animate">

                    @auth
                        @if ($donation->status != 'completed' && $donation->user_id == auth()->id())
                            <div class="mb10 text-right"
                                style="position: sticky; top: 0px;padding-top:15px;z-index:1;background-color:white;">
                                <a href="{{ route('cause.edit', ['id' => $donation->id]) }}"
                                    class="btn btn-primary btn-lg">Update</a>
                            </div>
                        @endif
                    @endauth

                    <h2>{{ $donation->title }}</h2>
                    <p>{{ $donation->description }}</p>

                    <!-- Render description html which is generated in wysiwyg editor-->
                    <div class="mt10">{!! $donation->details !!}</div>
                </div>

            </div>
        </div>
    </section>


    @if (count($recentDonors) > 0)
        <section class="probootstrap-section probootstrap-bg probootstrap-section-dark">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center section-heading probootstrap-animate"
                        data-animate-effect="fadeIn">
                        <h2>Donations To This Cause</h2>
                        <p class="lead">Sed a repudiandae impedit voluptate nam Deleniti dignissimos perspiciatis
                            nostrum
                            porro nesciunt</p>
                    </div>
                </div>
                <div class="row">
                    @foreach ($recentDonors as $donor)
                        <div class="col-md-3">
                            <div class="probootstrap-donors text-center probootstrap-animate">
                                <figure class="media">
                                    <img src="/img/person_6.jpg" alt="cause cover image"
                                        class="img-responsive">
                                </figure>
                                <div class="text">
                                    <h3>{{ Str::limit($donor->name, 16, '..') }}</h3>
                                    <p class="donated">Donated <span
                                            class="money">${{ $donor->user_donations_sum_amount }}</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            </div>
        </section>
    @endif


    <!-- session message display -->
    @if (session('message'))
        <!-- Modal (open by default) -->
        <div id="myModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="false" style="display: block;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Message</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ session('message') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button id="closeModalButton" type="button" class="btn btn-default"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Backdrop -->
        <div id="modalBackdrop" class="modal-backdrop" style="display: blocl;opacity:0.6;"></div>

        <script>
            // Function to close the modal
            function closeModal() {
                document.getElementById('myModal').classList.remove('in');
                document.getElementById('myModal').style.display = 'none';
                document.getElementById('modalBackdrop').style.display = 'none';
            }

            // Automatically open the modal on page load
            document.addEventListener('DOMContentLoaded', function() {

                // Close modal when clicking close button or close button in footer
                document.getElementById('closeModal').addEventListener('click', closeModal);
                document.getElementById('closeModalButton').addEventListener('click', closeModal);

                // Close modal when clicking outside the modal (on backdrop)
                document.getElementById('modalBackdrop').addEventListener('click', closeModal);
            });
        </script>
    @endif
</x-app-layout>
