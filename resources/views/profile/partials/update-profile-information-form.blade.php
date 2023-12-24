<section class="container my-5">
    <div class="card">
        <div class="card-header">
            <h2 class="h4 text-dark">
                {{ __('Profile Information') }}
            </h2>
            <p class="text-muted">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </div>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="card-body mt-4">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                <div class="invalid-feedback">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                <div class="invalid-feedback">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 text-dark">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="btn btn-link">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                @endif
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ __('Saved.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        </form>
    </div>
</section>
