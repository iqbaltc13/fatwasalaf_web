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
        <textarea id="html" cols="30" rows="20" name="html" >
            {{$data->html}}
        </textarea>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nomor Urut</label>
        
    </div>
    <div class="uk-margin">
       
        <input class="uk-input" id="order" name="order" type="number"  value="{{$data->order}}" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Banner Saat Ini <sup>*</sup></label>
        <div class="uk-form-controls">
            @if($data->image_slide)
                <img src="{{$data->image_slide->full_path}}"  >
            @endif
        </div>
        
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Banner <sup>*</sup></label>
        
    </div>
    <div class="uk-margin-medium-top sc-padding-small">
      
        <div class="uk-form-controls">
            <div class="js-upload" uk-form-custom>
                <input type="file" name="image_slide">
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
        <label class="uk-form-label" for="f-h-subject">Gambar Header Content Saat Ini <sup>*</sup></label>
        <div class="uk-form-controls">
            @if($data->image_content)
                <img src="{{$data->image_content->full_path}}"  >
            @endif
        </div>
        
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-h-subject">Gambar Header Content <sup>*</sup></label>
        
    </div>
    <div class="uk-margin-medium-top sc-padding-small">
      
        <div class="uk-form-controls">
            <div class="js-upload" uk-form-custom>
                <input type="file" name="image_content" >
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
            <option @if($data->position=="home_top") selected @endif value="home_top">Home Top</option>
            
            
        
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
      
        <input type="hidden" name="is_active" value="{{$data->is_active}}">
        {{-- <div class="status_aktif" id="status_aktif"></div> --}}
        <input type="checkbox" id="status_aktif" netliva-switch />

    </div>
    
    
   
</div>