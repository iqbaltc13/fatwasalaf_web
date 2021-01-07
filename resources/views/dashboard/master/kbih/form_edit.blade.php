<div id="vue-form-element">
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="name">Nama<sup>*</sup></label>
        <div class="uk-form-controls">
            
            <input class="uk-input" id="name" name="name" type="text" data-sc-input="outline" required value="{{$data->name}}">
        </div>
        @error('nama')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="sc-padding-small uk-margin-medium-top">
      
        <label class="uk-form-label" for="alamat">Alamat<sup>*</sup></label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" name="alamat" id="alamat" rows="5" data-sc-input="outline"required>
            {!!$data->alamat!!}
            </textarea>
            {{-- <input class="uk-input" id="alamat" name="alamat" type="text" data-sc-input="outline" required> --}}
        </div>
        @error('alamat')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="sc-padding-small uk-margin-medium-top">
      
        <label class="uk-form-label" for="email">Email<sup>*</sup></label>
        <div class="uk-form-controls">
            <input class="uk-input" id="email" name="email" type="email" data-sc-input="outline" required value="{{$data->email}}">
        </div>
        @error('email')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    
    <div class="sc-padding-small uk-margin-medium-top">
      
        <label class="uk-form-label" for="kota_id">Kota<sup>*</sup></label>
        <div class="uk-form-controls">
            <select class="uk-select" name="kota_id" id="kota_id">
                <option value="null">----Pilih Kota----</option>
                @foreach ($kota as $item)
                    <optgroup label="{{$item['nama']}}">
                    @foreach ($item['cities'] as $key => $row)
                        <option value="{{$key}}" {{($data->kota_id==$key)?"selected":""}}>{{$row}}</option>
                    @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        @error('kota_id')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="sc-padding-small uk-margin-medium-top">
      
        <label class="uk-form-label" for="latitude">Latitude</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="latitude" name="latitude" type="text" data-sc-input="outline" value="{{$data->latitude}}">
        </div>
        @error('latitude')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="sc-padding-small uk-margin-medium-top">
      
        <label class="uk-form-label" for="longitude">Longitude</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="longitude" name="longitude" type="text" data-sc-input="outline" value="{{$data->longitude}}">
        </div>
        @error('longitude')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>

    <div class="uk-margin-medium-top sc-padding-small">
        <label class="uk-form-label" for="status_aktif">Status Aktif<sup>*</sup></label>
        <div class="uk-form-controls">
            <select class="uk-select" id="status_aktif"  name="status_aktif" required>
                <option value="">-- Status Aktif--</option>
                <option value="1" {{($data->status_aktif==1)?'selected':""}}>Aktif</option>
                <option value="0" {{($data->status_aktif==0)?'selected':""}}>Tidak Aktif</option>
            </select>
        </div>
        @error('status_aktif')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
</div>
   