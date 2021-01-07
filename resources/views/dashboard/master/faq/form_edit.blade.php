<div class="uk-card-content">
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Nomor</label>
        <input class="uk-input" id="nomor" name="nomor" type="number" data-sc-input="outline" value="{{$data->nomor}}" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Judul</label>
        <input class="uk-input" id="judul" name="judul" type="text" value="{{$data->judul}}" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Konten</label>
        
    </div>
    <div class="uk-margin">
        <textarea id="konten" cols="30" rows="20" name="konten" required>
            {{$data->konten}}
        </textarea>
    </div>
   
</div>