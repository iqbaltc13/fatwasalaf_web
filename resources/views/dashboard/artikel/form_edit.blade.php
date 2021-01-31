<div id="vue-form-element">
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="title">Judul<sup>*</sup></label>
        <div class="uk-form-controls">
            <input class="uk-input" id="title" name="title" type="text" value="{{$data->title}}" data-sc-input="outline" required>
        </div>
        @error('title')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="sc-padding-small uk-margin-medium-top">
      
        <label class="uk-form-label" for="artikel">Artikel</label>
        <div class="uk-form-controls">
            <textarea  name="article" id="article"  cols="30" rows="20">{{$data->article}}</textarea>
         
        </div>
        @error('article')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    <div class="uk-margin-medium-top sc-padding-small">
        <label class="uk-form-label" for="built_in">Status Aktif<sup>*</sup></label>
        <div class="uk-form-controls">
            <select class="uk-select" id="status"   name="status" required>
                <option @if(is_null($data->is_active)) selected @endif value="">-- Pilih Status Aktif--</option>
                <option  @if($data->status == 0) selected @endif value="0">0</option>
                <option  @if($data->status == 1) selected @endif value="1">1</option>
               
                   
                
                
            
            </select>
        </div>
        @error('status')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
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