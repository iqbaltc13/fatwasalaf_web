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
    <div class="uk-margin-medium-top sc-padding-small">
        <label class="uk-form-label" for="built_in">Status Aktif<sup>*</sup></label>
        <div class="uk-form-controls">
            <select class="uk-select" id="status"   name="status" required>
                <option @if(is_null($data->is_active)) selected @endif value="">-- Pilih Status Aktif--</option>
                <option  @if($data->status == 0) selected @endif value="0">0</option>
                <option  @if($data->status == 1) selected @endif value="1">1</option>
               
                   
                
                
            
            </select>
        </div>
        @error('status')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    
    
    
</div>
   