@extends('admin.layout')
@section('main-content')
<form
    @if (isset($manufacture))
        action="{{ route('nha-san-xuat.update', ['id' => $manufacture->id]) }}"
    @else
        action="{{ route('nha-san-xuat.store') }}"
    @endif method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 form-group">
                            <label>Tên @if (!isset($manufacture)) <span style="color: red">*</span> @endif </label>
                            <input type="text" name="ten" id="ten" class="form-control" required maxlength="50" placeholder="Nhập tên" @isset($manufacture) value="{{ $manufacture->ten }}" @endisset/>
                        </div>

                        <div class="col-6 form-group">
                            <label>Hình ảnh @if (!isset($manufacture)) <span style="color: red">*</span> @endif </label>
                            <div class="col-12 row">

                                <div class="col-3">
                                    <label for="files" class="btn btn-primary waves-effect waves-light btn-block">Tải hình</label>

                                </div>

                                <div class="col-3">
                                    <button type="button" class="btn btn-secondary waves-effect waves-light btn-block btn-remove">Xóa hình</button>
                                </div>

                                <div class="col-5">
                                    @if (isset($manufacture))
                                        <input type="hidden" name="is_remove" id="is_remove">
                                    @endif
                                    <input type="file" id="files" @if (!isset($manufacture)) required @endif class="d-none" name="hinh_anh" accept=".png, .jpg, .jpeg"/>
                                </div>
                            </div>
                            <div id="image_preview">
                                @if (isset($manufacture->anh))
                                    <div class="file-thumb position-relative d-inline-flex mx-2 my-2" style="width: 6rem">
                                        <img style="width:100%" src="{{ $manufacture->anh }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-2" style="margin-left: auto">
                            <button type="submit" class="btn btn-primary waves-effect waves-light btn-block">Lưu</button>
                        </div>
                        <div class="col-2">
                            <a href="{{ route('nha-san-xuat.list') }}" class="btn btn-secondary waves-effect waves-light btn-block">Hủy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('page-css')
<style>
    #image_preview button {
        position: absolute;
        right: 0;
        top: 0;
    }

    .close {
        line-height: 0;
    }
</style>
@endsection

@section('page-js')
<script src="{{ asset('plugins/parsleyjs/parsley.min.js') }}"></script>
@endsection

@section('page-custom-js')
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();

        const Toast = Swal.mixin({
            toast: true,
            width: "20rem",
            position: 'bottom-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toast.fire({
                    icon: 'error',
                    title: "{!! $error  !!}"
                });
            @endforeach
        @endif

        $('#files').change(function() {
            $('#image_preview').empty();
            var img = `<div class="file-thumb position-relative d-inline-flex mx-2 my-2" style="width: 6rem">
                <img style="width:100%" src="${URL.createObjectURL(event.target.files[0])}">
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true" class="btn-close font-15 fa fa-times" onclick="click_close()"></span>
                </button>
            </div>`;
            $('#image_preview').append(img);
        });

        $('.btn-remove').click(function() {
            $('#image_preview').empty();
            $('#is_remove').val('removed');
        });
    });

    function click_close() {
        var node = event.srcElement.parentElement.parentElement;
        var preview_image = document.getElementById("image_preview");
        preview_image.removeChild(node);
    }
</script>
@endsection
