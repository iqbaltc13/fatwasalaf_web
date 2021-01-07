<div id="vue-form-element">
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="name">Nama<sup>*</sup></label>
        <div class="uk-form-controls">
            <input class="uk-input" id="nama" name="nama" type="text" data-sc-input="outline" required>
        </div>
        @error('nama')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    
    
    <div class="uk-margin-medium-top sc-padding-small">
        <label class="uk-form-label" for="is_active">Status Aktif<sup>*</sup></label>
        <div class="uk-form-controls">
            <select class="uk-select" id="is_active"  name="is_active" required>
                <option selected value="">-- Status Aktif--</option>
                <option value="0">0</option>
                <option value="1">1</option>
               
                   
                
                
            
            </select>
        </div>
        @error('built_in')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
</div>
   