@extends('layout')
@section('main-content')
<form
    @if (isset($product))
        action="{{ route('san-pham.update', ['id' => $product->id]) }}"
    @else
        action="{{ route('san-pham.store') }}"
    @endif method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 form-group">
                            <label>Mã sản phẩm @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <input type="text" name="ma_sp" id="ma_sp" class="form-control" required maxlength="20" placeholder="Nhập mã sản phẩm" @isset($product) value="{{ $product->ten_sp }}" @endisset/>
                        </div>

                        <div class="col-3 form-group">
                            <label>Tên sản phẩm @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <input type="text" name="ten_sp" id="ten_sp" class="form-control" required maxlength="50" placeholder="Nhập tên sản phẩm" @isset($product) value="{{ $product->ten_sp }}" @endisset/>
                        </div>

                        <div class="col-3 form-group">
                            <label>Loại sản phẩm @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <select class="form-control" id="loai_sp" name="loai_sp" required>
                                @if (!isset($product))
                                    <option selected disabled>Chọn loại sản phẩm</option>
                                @endif
                                @if (isset($product_types))
                                    @foreach ($product_types as $product_type)
                                        <option @if (isset($product) && $product_type->id == $product->loai_sp_id) selected @endif value="{{ $product_type->id }}"> {{ $product_type->ten }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-3 form-group">
                            <label>Nhà sản xuất @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <select class="form-control" id="nha_sx" name="nha_sx" required>
                                @if (!isset($product))
                                    <option selected disabled>Chọn nhà sản xuất</option>
                                @endif
                                @if (isset($manufactures))
                                    @foreach ($manufactures as $manufacture)
                                        <option @if (isset($product) && $manufacture->id == $product->nha_sx_id) selected @endif value="{{ $manufacture->id }}"> {{ $manufacture->ten }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3 form-group">
                            <label>Giá @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <input type="text" name="gia" id="gia" class="form-control" required maxlength="20" placeholder="Nhập giá" @isset($product) value="{{ $product->gia }}" @endisset/>
                        </div>

                        <div class="col-3 form-group">
                            <label>Số lượng @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <input type="text" name="so_luong" id="so_luong" class="form-control" required maxlength="4" placeholder="Nhập số lượng" @isset($product) value="{{ $product->so_luong }}" @endisset/>
                        </div>

                        <div class="col-3 form-group">
                            <label>Giảm giá @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <input type="text" name="giam_gia" id="giam_gia" class="form-control" required maxlength="5" placeholder="Nhập giảm giá" @isset($product) value="{{ $product->giam_gia }}" @endisset/>
                        </div>

                        <div class="col-3 form-group">
                            <label>Màu sắc @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <input type="text" name="mau_sac" id="mau_sac" class="form-control" required maxlength="50" placeholder="Nhập tên sản phẩm" @isset($product) value="{{ $product->mau_sac }}" @endisset/>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group">
                            <label>Mô tả @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <textarea name="ma_sp" id="ma_sp" class="form-control" rows="5" maxlength="191" placeholder="Nhập mô tả">@isset($product) value="{{ $product->ten_sp }}" @endisset</textarea>
                        </div>

                        <div class="col-6 form-group">
                            <label>Hình ảnh @if (!isset($product)) <span style="color: red">*</span> @endif </label>
                            <div class="col-12 row">
                                <div class="col-3">
                                    <label for="upload_file" class="btn btn-primary waves-effect waves-light btn-block">Tải hình</label>
                                    <input type="file" id="upload_file" class="d-none" name="upload_file[]" accept="image/*" onchange="preview_image();" multiple/>
                                </div>

                                <div class="col-3">
                                    <button type="button" class="btn btn-secondary waves-effect waves-light btn-block btn-remove">Xóa hình</button>
                                </div>
                            </div>
                            <div id="image_preview"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2" style="margin-left: auto">
                            <button type="submit" class="btn btn-primary waves-effect waves-light btn-block">Lưu</button>
                        </div>
                        <div class="col-2">
                            <a href="{{ route('san-pham.list') }}" class="btn btn-secondary waves-effect waves-light btn-block">Hủy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</div>
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

        $('.btn-remove').click(function() {
            console.log('Click');
            $('#image_preview').empty();
        });

        @error('ma_sp')
            Toast.fire({
                icon: 'error',
                title: "{!! $message !!}"
            });
        @enderror

        @error('hinh_anh')
            Toast.fire({
                icon: 'error',
                title: "{!! $message !!}"
            });
        @enderror
    });

    function preview_image() {
        var total_file=document.getElementById("upload_file").files.length;
        for (var i = 0; i < total_file; i++) {
            var img = `<div class="file-thumb position-relative d-inline-flex mx-2 my-2" style="width: 6rem">
                <img style="width:100%" src="${URL.createObjectURL(event.target.files[i])}">
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true" class="font-15 fa fa-times" onclick="click_close()"></span>
                </button>
            </div>`;
            $('#image_preview').append(img);
        }
    }

    function click_close() {
        var node = event.srcElement.parentElement.parentElement;
        var preview_image = document.getElementById("image_preview");
        preview_image.removeChild(node);
    }
</script>
@endsection
