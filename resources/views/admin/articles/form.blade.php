@extends('admin.layout')

@section('page_css')
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/summernote/summernote.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/summernote/summernote-bs3.css')}}" />
@endsection

@section('content')
    <header class="page-header">
        <h2>Article Forms</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Forms</span></li>
                <li><span>Advanced</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>
    <!-- start: page -->
    <div class="row">
        <div class="col-xs-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Nhập thông tin tin tức</h2>
                </header>
                <div class="panel-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal form-bordered" action="/admin/articles" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Title</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="inputDefault" name="title">
                                @error('title')
                                    <div class="text-danger">* {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputSuccess">Danh mục bài viết</label>
                            <div class="col-md-6">
                                <select class="form-control mb-md" name="category_id">
                                    @foreach($categories as $cate)
                                    <option value="{{$cate->id}}">{{$cate->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Content</label>
                            <div class="col-md-9">
                                <textarea name="content" class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "ambiance" } }'>Start typing...</textarea>
                                @error('content')
                                <div class="text-danger">* {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="thumbnail">Thumbnail</label>
                            <div class="col-md-6">
                                <input type="hidden" class="form-control" id="thumbnail" name="thumbnail">
                                <div class="p-sm hidden" id="preview-div">

                                </div>
                                <button type="button" id="upload_widget" class="btn btn-sm btn-primary">Upload files</button>
                                @error('thumbnail')
                                <div class="text-danger">* {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Status</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="inputDefault" name="status">
                                @error('status')
                                <div class="text-danger">* {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6 col-xs-11">
                                <button class="btn btn-sm btn-primary colorpicker-element">
                                    Submit
                                </button>
                                <button class="btn btn-sm btn-default colorpicker-element">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('page_js')
    <script src="{{URL::asset('assets/vendor/summernote/summernote.js')}}"></script>
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>

    <script type="text/javascript">
        // Có 2 tham số.
        var myWidget = cloudinary.createUploadWidget({
                cloudName: 'hungkito20',
                uploadPreset: 'nsxdwj7u'
            },
            (error, result) => {
                if (!error && result && result.event === "success") {
                    var inputThumnail = document.getElementById('thumbnail');
                    var previewDiv = document.getElementById('preview-div');
                    if (inputThumnail){
                        var currentImageValue = inputThumnail.value;
                        if (currentImageValue.length > 0){
                            currentImageValue += ',';
                        }
                        currentImageValue += result.info.secure_url;
                        inputThumnail.value = currentImageValue;

                        // Xử lý preview
                        previewDiv.innerHTML += `<img src="${result.info.secure_url}" width="150px" class="img-rounded p-sm">`;
                        previewDiv.classList.remove('hidden');
                    }

                }
            }
        )

        document.getElementById("upload_widget").addEventListener("click", function(){
            myWidget.open();
        }, false);
    </script>
@endsection

