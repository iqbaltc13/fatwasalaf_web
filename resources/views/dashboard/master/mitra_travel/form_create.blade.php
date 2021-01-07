<div class="uk-card-content">
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nama</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="nama" name="nama" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Deskripsi</label>
        
    </div>
    <div class="uk-margin">
        <textarea id="deskripsi" cols="30" rows="20" name="deskripsi" required>
            
        </textarea>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">No Izin Kemenag</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="no_izin_kemenag" name="no_izin_kemenag" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nama Direktur</label>
        
    </div>
    
    <div class="uk-margin">
       
        <input class="uk-input" id="nama_direktur" name="nama_direktur" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Lokasi Kantor</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="lokasi_kantor" name="lokasi_kantor" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Titik Keberangkatan</label>
        
    </div>
    
    <div class="uk-margin">
       
        <input class="uk-input" id="titik_keberangkatan" name="titik_keberangkatan" type="text" data-sc-input="outline" required>
    </div>
   
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nomor Urut</label>
        
    </div>
    
    <div class="uk-margin">
       
        <input class="uk-input" id="order" name="order" type="number"   data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Telepon</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="telepon" name="telepon" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Website</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="website" name="website" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Social Media</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="social_media" name="social_media" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Tahun Berdiri</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="tahun_berdiri" name="tahun_berdiri" type="number" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Logo <sup>*</sup></label>
        
    </div>
    <div class="uk-margin-medium-top sc-padding-small">
      
        <div class="uk-form-controls">
            <div class="js-upload" uk-form-custom>
                <input type="file" name="logo" required>
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