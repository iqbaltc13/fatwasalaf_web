<div id="vue-form-element">
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="name">Nama Kategori<sup>*</sup></label>
        <div class="uk-form-controls">
            <input class="uk-input" id="name" name="name" type="text"  value="{{$data->name}}" data-sc-input="outline" required>
        </div>
        @error('name')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    
    
    
</div>
   