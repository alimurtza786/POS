<section class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2 class="h4 text-dark">
                {{ __('Update Password') }}
            </h2>
            <p class="text-muted">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="card-body mt-4">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                <input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
                @error('updatePassword.current_password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
                @error('updatePassword.password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                @error('updatePassword.password_confirmation')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                @if (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ __('Saved.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        </form>
    </div>
</section>
