<div id="vue-form-element">
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="nama">Nama<sup>*</sup></label>
        <div class="uk-form-controls">
        <input class="uk-input" id="nama" name="nama" value="{{$data->nama}}" type="text" data-sc-input="outline" required>
        </div>
        @error('nama')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    
    
    
</div>
   