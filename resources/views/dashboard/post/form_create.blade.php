<div id="vue-form-element">
    <div class="sc-padding-small">
      
        <label class="uk-form-label" for="title">Judul<sup>*</sup></label>
        <div class="uk-form-controls">
            <input class="uk-input" id="title" name="title" type="text" data-sc-input="outline" required>
        </div>
        @error('title')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
        
    </div>
    <div class="uk-margin">
        <label class="uk-form-label" for="article" for="f-empl-recent">Artikel <sup>*</sup></label>
        
    </div>
    <div class="uk-margin">
        <textarea id="article" cols="30" rows="20" name="article" required>
        </textarea>
    </div>
    @error('article')
       
        <div class="uk-alert-danger" data-uk-alert>
            <a class="uk-alert-close" data-uk-close></a>
                {{ $message }}
        </div>
    @enderror
     <div class="uk-margin-medium-top sc-padding-small">
        <label class="uk-form-label" for="category">Kategori<sup>*</sup></label>
        <div class="uk-form-controls">
            <select class="uk-select" id="category"   name="categories[]" required>
                <option  selected  value="">-- Pilih Kategori--</option>
                @foreach ($arrDataCategories as $item)
                    <option   value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
               
                
               
                   
                
                
            
            </select>
        </div>
        @error('category')
           
            <div class="uk-alert-danger" data-uk-alert>
                <a class="uk-alert-close" data-uk-close></a>
                    {{ $message }}
            </div>
        @enderror
    </div>
    
    
    
</div>
   