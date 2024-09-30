@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <section class="probootstrap-section probootstrap-section-dark">
        <div class="container">
            <div class="row mt40">

                <div class="col-md-12 section-heading text-center">
                    <h2>{{ $isEditing ? 'Update Donation Cause' : 'Add Donation Cause' }}</h2>
                </div>

                <div class="col-md-12">
                    <form
                        action="{{ $isEditing ? route('cause.update', ['id' => $donation->id ?? 0]) : route('causes.store') }}"
                        method="POST">
                        @csrf

                        @if ($isEditing)
                            @method('PUT')
                        @endif

                        <!-- Title input -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input value="{{ $isEditing && isset($donation) ? $donation->title : old('title') }}"
                                type="text" class="form-control" id="title" name="title" placeholder="Title"
                                required>
                        </div>

                        <!-- Description input -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input
                                value="{{ $isEditing && isset($donation) ? $donation->description : old('description') }}"
                                type="textarea" class="form-control" id="description" name="description"
                                placeholder="Enter description" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <!-- Target Amount input -->
                                <div class="form-group">
                                    <label for="target_amount">Target Amount</label>
                                    <input
                                        value="{{ $isEditing && isset($donation) ? $donation->target_amount : old('target_amount') }}"
                                        type="number" class="form-control" id="target_amount" name="target_amount"
                                        placeholder="Target Amount" min="1" step="1" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Due date input -->
                                @php
                                    $minDateTime = Carbon\Carbon::now()->addHours(48)->format('Y-m-d\TH:i');
                                @endphp
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input
                                        value="{{ $isEditing && isset($donation) ? $donation->due_date : old('due_date') }}"
                                        type="datetime-local" class="form-control" id="due_date" name="due_date"
                                        placeholder="Due date" required min="{{ $minDateTime }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Status Selector -->
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="draft"
                                            {{ !$isEditing || (isset($donation) && $donation->status == 'draft') ? 'selected' : '' }}>
                                            Draft</option>
                                        <option value="open"
                                            {{ $isEditing && isset($donation) && $donation->status == 'open' ? 'selected' : '' }}>
                                            Open</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="editor">Message:</label>
                            <textarea id="editor" name="details" class="form-control" rows="3" style="overflow:auto;"></textarea>
                        </div>

                        <!-- Buttons row -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Cancel button on the right -->
                                @if ($isEditing && isset($donation))
                                    <a href="{{ route('causes.view_cause', ['id' => $donation->id]) }}"
                                        class="btn btn-default pull-right">Cancel</a>
                                @else
                                    <a href="{{ route('causes.index') }}" class="btn btn-default pull-right">Cancel</a>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <!-- Submit button on the left -->
                                <button type="submit" class="btn btn-primary pull-left">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
