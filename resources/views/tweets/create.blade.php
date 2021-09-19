<x-app-layout>
    <div class="mt-6">
        <div class="max-w-xl px-10 pt-6 pb-6 mx-auto bg-white rounded-lg shadow-md">
            <div class="card-header">Create</div>
            <form method="POST" action="{{ route('tweets.store') }}">
                @csrf
                <div class="form-group row mb-0">
                    <div class="col-md-12 p-3 w-100 d-flex">
                        <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                        <div class="ml-2 d-flex flex-column">
                            <p class="mb-0">{{ $user->name }}</p>
                            <a href="{{ url('users/' .$user->id) }}" class="text-secondary">{{ $user->screen_name }}</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="4">{{ old('text') }}</textarea>

                        @error('text')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12 text-right">
                        <p class="mb-4 text-danger">140文字以内</p>
                        <button type="submit" class="btn btn-primary">
                            ツイートする
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
