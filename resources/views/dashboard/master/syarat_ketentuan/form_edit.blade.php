<div class="uk-card-content">
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Jenis</label>
        <input class="uk-input" id="jenis" name="jenis" type="text" value="{{$data->jenis}}" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Judul</label>
        <input class="uk-input" id="judul" name="judul" type="text" value="{{$data->judul}}" data-sc-input="outline" required>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="f-empl-recent">Konten</label>
        
    </div>
    <div class="uk-margin">
        <textarea id="html_konten" cols="30" rows="20" name="html_konten" required>
            {{$data->html_konten}}
        </textarea>
    </div>
   
</div>