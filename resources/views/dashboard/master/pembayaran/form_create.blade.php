<div id="vue-form-element">
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="nomor_va">Nomor VA<sup>*</sup></label>
        <div class="uk-form-controls">
            <input class="uk-input" id="nomor_va" name="nomor_va" type="text" data-sc-input="outline" required>
        </div>
        @error('nomor_va')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="nominal">Nominal<sup>*</sup></label>
        <div class="uk-form-controls">
            <input class="uk-input" id="nominal" name="nominal" type="text" data-sc-input="outline" required>
        </div>
        @error('nominal')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="remarks">Remarks<sup>*</sup></label>
        <div class="uk-form-controls">
            <input class="uk-input" id="remarks" name="remarks" type="text" data-sc-input="outline" required>
        </div>
        @error('remarks')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    
    
</div>
   