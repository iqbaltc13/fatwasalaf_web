
<div class="uk-card-content">
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nama</label>
        <input class="uk-input" id="name" name="name"  value="{{$data->name}}" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Email</label>
        <input class="uk-input" id="email" name="email" value="{{$data->email}}"  type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nomor telepon</label>
        <input class="uk-input" id="phone" name="phone" value="{{$data->phone}}" type="number" data-sc-input="outline" required>
    </div>
    @php
        $arrMyRole=$myRole->pluck('role_id')->toArray();
    @endphp
    <div>
        <label class="uk-form-label" for="f-empl-recent">Role</label>
        <ul class="uk-list">
            @foreach ($role as $item)
                <li>
                    <input @if(in_array($item->id,$arrMyRole))checked @endif type="checkbox" value="{{$item->id}}" name="role[]" id="select-role-{{$item->id}}" data-sc-icheck>
                    <label for="select-role-1">{{$item->name}}</label>
                </li>
                
            @endforeach
          
          
        </ul>
    </div>
    
    
</div>
