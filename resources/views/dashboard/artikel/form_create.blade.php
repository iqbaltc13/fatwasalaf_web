<div id="vue-form-element">
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="judul">Judul<sup>*</sup></label>
        <div class="uk-form-controls">
            <input class="uk-input" id="judul" name="judul" type="text" data-sc-input="outline" required>
        </div>
        @error('judul')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="sc-padding-small uk-margin-medium-top">
      
        <label class="uk-form-label" for="artikel">Artikel</label>
        <div class="uk-form-controls">
            <textarea  name="artikel" id="artikel"  cols="30" rows="20"></textarea>
         
        </div>
        @error('artikel')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="sc-padding-small uk-margin-medium-top">
        <label class="uk-form-label" for="judul">Thumbnail<sup>*</sup></label>
        <div class="uk-form-controls">
            <input type="hidden" name="thumbnail_file_id" id="thumbnail_file_id">
            <input type="file" name="thumbnail" id="thumbnail" style="display: none" onchange="uploadFile()">
            <img src="#" id="thumbnail_image" alt="File Thumbnail" srcset="" style="display: none">
            <button type="button" class="sc-button sc-button-success" id="thumbnail_upload" onclick="document.getElementById('thumbnail').click()"> Unggah </button>
        </div>
    </div>
    <div class="sc-padding-small uk-margin-medium-top">
        <label class="uk-form-label" for="judul">Konten<sup>*</sup></label>
        <div class="uk-form-controls">
            <input type="hidden" name="konten_file_id" id="konten_file_id">
            <input type="file" name="konten" id="konten" style="display: none" onchange="uploadKonten()">
            <img src="#" id="konten_image" alt="File Konten" srcset="" style="display: none">
            <button type="button" class="sc-button sc-button-success" id="konten_upload" onclick="document.getElementById('konten').click()"> Unggah </button>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function uploadFile()
        {
            let csrf = "{{csrf_token()}}";
            let file = document.getElementById('thumbnail').files[0];
            let formData = new FormData();
            formData.append('file',file);
            formData.append('_token',csrf);
            formData.append('folder',"artikel");
            axios.post('{{route("upload_image")}}',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function(data){
                output = data.data.data;
                document.getElementById('thumbnail_image').src = output.full_path;
                document.getElementById('thumbnail_image').style.display = "block";
                document.getElementById('thumbnail_file_id').value = output.id;

            });
        }
        function uploadKonten()
        {
            let csrf = "{{csrf_token()}}";
            let file = document.getElementById('konten').files[0];
            let formData = new FormData();
            formData.append('file',file);
            formData.append('_token',csrf);
            formData.append('folder',"artikel");
            axios.post('{{route("upload_image")}}',formData,{
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function(data){
                output = data.data.data;
                document.getElementById('konten_image').src = output.full_path;
                document.getElementById('konten_image').style.display = "block";
                document.getElementById('konten_file_id').value = output.id;

            });
        }
    </script>
@endpush