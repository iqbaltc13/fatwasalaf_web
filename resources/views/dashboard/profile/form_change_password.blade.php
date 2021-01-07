<h3 class="uk-card-title">Change Password</h3>
<div class="uk-accordion-content">
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Old Password</label>
        <input class="uk-input" id="old_password" name="old_password" type="password" data-sc-input="outline" required>
        @error('old_password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">New Password</label>
        <input class="uk-input" id="password" name="password" type="password" data-sc-input="outline" required>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">New Password Confirmation</label>
        <input class="uk-input" id="password_confirmation" name="password_confirmation" type="password" data-sc-input="outline" required>
    </div>
</div>