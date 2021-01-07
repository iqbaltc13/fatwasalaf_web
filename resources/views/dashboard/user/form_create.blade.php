<div class="uk-card-content">
<div class="uk-margin">
    <label class="uk-form-label" for="f-empl-recent">Nama</label>
    <input class="uk-input" id="name" name="name" type="text" data-sc-input="outline" required>
</div>
<div class="uk-margin">
    <label class="uk-form-label" for="f-empl-recent">Email</label>
    <input class="uk-input" id="email" name="email" type="text" data-sc-input="outline" required>
</div>
<div class="uk-margin">
    <label class="uk-form-label" for="f-empl-recent">Nomor telepon</label>
    <input class="uk-input" id="phone" name="phone" type="number" data-sc-input="outline" required>
</div>
<div>
    <label class="uk-form-label" for="f-empl-recent">Role</label>
    <ul class="uk-list">
        @foreach ($role as $item)
            <li>
            <input type="checkbox" value="{{$item->id}}" name="role[]" id="select-role-{{$item->id}}" data-sc-icheck>
                <label for="select-role-1">{{$item->name}}</label>
            </li>
            
        @endforeach
      
      
    </ul>
</div>
<div class="uk-margin">
    <label class="uk-form-label" for="f-empl-recent">Kata sandi</label>
    <input class="uk-input" id="password" name="password" type="password" data-sc-input="outline" required>
    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="uk-margin">
    <label class="uk-form-label" for="f-empl-recent">Konfirmasi Kata Sandi</label>
    <input class="uk-input" id="password_confirmation" name="password_confirmation" type="password" data-sc-input="outline" required>
</div>
</div>