<div class="uk-card-content">
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Judul</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="title" name="title" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Konten</label>
        
    </div>
    <div class="uk-margin">
        <textarea id="html" cols="30" rows="20" name="html" >
        </textarea>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nomor Urut</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="order" name="order" type="number"   data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Banner <sup>*</sup></label>
        
    </div>
    <div class="uk-margin-medium-top sc-padding-small">
      
        <div class="uk-form-controls">
            <div class="js-upload" uk-form-custom>
                <input type="file" name="image_slide" required>
                <button class="uk-button uk-button-default" type="button" tabindex="-1">Pilih</button>
            </div>
        </div>
        @error('image_slide')
               
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Gambar Header Content <sup>*</sup></label>
        
    </div>
    <div class="uk-margin-medium-top sc-padding-small">
      
        <div class="uk-form-controls">
            <div class="js-upload" uk-form-custom>
                <input type="file" name="image_content">
                <button class="uk-button uk-button-default" type="button" tabindex="-1">Pilih</button>
            </div>
        </div>
        @error('image_content')
               
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Posisi</label>
        
    </div>
    <div class="uk-margin">
        <select class="uk-select" id="position"  name="position" required>
            <option selected value="">-- Pilih Posisi --</option>
            <option value="home_top">Home Top</option>
            
            
        
        </select>
       
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Status</label>
        
    </div>
    <div class="uk-alert-success alert-status-aktif" id="alert-active" data-uk-alert>
       
          Aktif
    </div>
    <div class="uk-alert-danger alert-status-aktif" id="alert-inactive" data-uk-alert>
        
          NonAktif
    </div>
    <div class="uk-margin">
        <input type="checkbox" id="status_aktif" netliva-switch />
        <input type="hidden" name="is_active" value="0">
    </div>
   

    
   
</div>