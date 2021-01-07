<div class="uk-card-content">
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nama</label>
        
    </div>
    <div class="uk-margin">
       
    <input class="uk-input" id="nama" name="nama" value="{{$data->nama}}" type="text" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Deskripsi</label>
        
    </div>
    <div class="uk-margin">
        {{-- <textarea id="deskripsi" cols="30" rows="20" name="deskripsi" required>
            {{$data->deskripsi}}
        </textarea> --}}
        <input class="uk-input" id="deskripsi" name="deskripsi" type="text" value="{{$data->deskripsi}}" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Biaya Administrasi (Rp)</label>
        
    </div>
    <div class="uk-margin">
       
        <input   class="uk-input" id="biaya_administrasi" value="{{$data->biaya_administrasi}}" name="biaya_administrasi" type="number" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nominal Tabungan (Rp)</label>
        
    </div>
    <div class="uk-margin">
       
        <input   class="uk-input" id="nominal_tabungan" value="{{$data->nominal_tabungan}}" name="nominal_tabungan" type="number" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Jadikan Default ?</label>
        
    </div>
    <div class="uk-alert-success alert-is-default" id="alert-active" data-uk-alert>
       
        Default
    </div>
  <div class="uk-alert-danger alert-is-default" id="alert-inactive" data-uk-alert>
      
        No Default
  </div>
    <div class="uk-margin">
        <input type="checkbox" id="is_default" netliva-switch />
        <input type="hidden" name="is_default" value="{{$data->is_default}}">
    </div>
   

    
   
</div>