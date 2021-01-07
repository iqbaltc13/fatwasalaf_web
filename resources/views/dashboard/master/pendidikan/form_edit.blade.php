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
    
    
    <div class="uk-margin-medium-top sc-padding-small">
        <label class="uk-form-label" for="built_in">Status Aktif<sup>*</sup></label>
        <div class="uk-form-controls">
            <select class="uk-select" id="is_active"   name="is_active" required>
                <option @if(is_null($data->is_active)) selected @endif value="">-- Pilih Status Aktif--</option>
                <option  @if($data->is_active == 0) selected @endif value="0">0</option>
                <option  @if($data->is_active == 1) selected @endif value="1">1</option>
               
                   
                
                
            
            </select>
        </div>
        @error('is_active')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
</div>
   