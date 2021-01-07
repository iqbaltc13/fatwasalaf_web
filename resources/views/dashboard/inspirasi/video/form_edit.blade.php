<div class="uk-card-content">
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Judul</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="title" name="title"  value="{{$data->title}}" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Subjudul</label>
        
    </div>
    <div class="uk-margin">
        <input class="uk-input" id="subtitle" name="subtitle" value="{{$data->subtitle}}" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Deskripsi</label>
        
    </div>
    <div class="uk-margin">
        <input class="uk-input" id="description" value="{{$data->description}}" name="description" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Durasi (detik)</label>
        
    </div>
    <div class="uk-margin">
       
        <input  class="uk-input" id="duration_second" name="duration_second" value="{{$data->duration_second}}" type="number" data-sc-input="outline" required>
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
        <label class="uk-form-label" for="f-empl-recent">Video URL</label>
        
    </div>
    <div class="uk-margin">
        <input class="uk-input" id="video_url" name="video_url" value="{{$data->video_url}}" type="text" data-sc-input="outline" required>
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
        <input type="hidden" name="is_active" value="{{$data->is_active}}">
    </div>
   

    
   
</div>