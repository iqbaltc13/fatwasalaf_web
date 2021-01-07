<div class="uk-card-content">
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Judul</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="title" name="title" type="text"  value="{{$data->title}}" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Konten</label>
        
    </div>
    <div class="uk-margin">
        <textarea id="html" cols="30" rows="20" name="html" required>
            {{$data->html}}
        </textarea>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Header Image Saat Ini <sup>*</sup></label>
        <div class="uk-form-controls">
            @if($data->header_image)
                <img src="{{$data->header_image->full_path}}"  >
            @endif
        </div>
        
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Header Image <sup>*</sup></label>
        
    </div>
    <div class="uk-margin-medium-top sc-padding-small">
      
        <div class="uk-form-controls">
            <div class="js-upload" uk-form-custom>
                <input type="file" name="header_image" >
                <button class="uk-button uk-button-default" type="button" tabindex="-1">Pilih</button>
            </div>
        </div>
        @error('header_image')
               
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Gambar Thumbnail Saat Ini <sup>*</sup></label>
        <div class="uk-form-controls">
            @if($data->thumbnail)
                <img src="{{$data->thumbnail->full_path}}"  >
            @endif
        </div>
        
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Thumbnail <sup>*</sup></label>
        
    </div>
    <div class="uk-margin-medium-top sc-padding-small">
      
        <div class="uk-form-controls">
            <div class="js-upload" uk-form-custom>
                <input type="file" name="thumbnail" >
                <button class="uk-button uk-button-default" type="button" tabindex="-1">Pilih</button>
            </div>
        </div>
        @error('thumbnail')
               
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    

    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Durasi</label>
        
    </div>
    <div class="uk-margin">
       
        <input placeholder="Bacaan 5 Menit"  class="uk-input" id="duration_string"  value="{{$data->duration_string}}" name="duration_string" type="text" data-sc-input="outline" required>
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
      
        <input type="hidden" name="is_active" value="{{$data->is_active}}">
        {{-- <div class="status_aktif" id="status_aktif"></div> --}}
        <input type="checkbox" id="status_aktif" netliva-switch />

    </div>
    
    
   
</div>