@extends('admin.layout')
@section('page_css')
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
    <header class="page-header">
        <h2>Danh sách bài viết</h2>
        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Tables</span></li>
                <li><span>Advanced</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
    <section class="panel">
        <header class="panel-heading">
            <h2 class="panel-title">Danh sách hiện có</h2>
        </header>
        <div class="panel-body">
            <form name="filter-form" class="form-horizontal form-bordered" action="/admin/articles" method="get">
            <div class="row">
                <div class="col-md-4">

                        <div class="form-group">
                            <label class="col-md-6 control-label" for="inputSuccess">Danh mục bài viết</label>
                            <div class="col-md-6">
                                <select class="form-control mb-md" name="category_id">
                                    <option value="0">--Tất cả--</option>
                                    @foreach($categories as $cate)
                                        <option {{$current_category_id == $cate->id ? 'selected': ''}} value="{{$cate->id}}">{{$cate->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </div>
                <div class="col-md-5">

                </div>
                <div class="col-md-3">
                    <input class="form-control" type="text" name="datefilter" value="" />
                </div>
            </div>
            </form>
            @if(count($list) > 0)
                <table class="table table-bordered table-striped mb-none" id="datatable-default">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr class="gradeU">
                            <td>{{$item->id}}</td>
                            <td><img src="{{$item->defaultThumbnail}}" class="img-rounded" width="70px" alt=""></td>
                            <td><a href="/admin/articles/{{$item->id}}">{{$item->title}}</a></td>
                            <td>{{$item->category->name}}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="/admin/articles/{{$item->id}}/edit">Sửa</a>
                                <form style="display: inline" action="/admin/articles/{{$item->id}}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Chắc chắc xoá bài viết này?')">Xoá</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                Hiện tại chưa có sản phẩm nào, vui lòng <a href="/admin/articles/create">tạo mới</a>
            @endif
            <div class="row datatables-footer">
                <div class="col-sm-12 col-md-6">
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_paginate paging_bs_normal" id="datatable-default_paginate">
{{--                        {!! $list->links() !!}--}}
                        @include('pagination.default', ['paginator' => $list])
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end: page -->
@endsection

@section('page_js')
    <script>
        var selectCate = document.forms['filter-form']['category_id'];
        selectCate.onchange = function (){
            document.forms['filter-form'].submit();
        }
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();
            $('input[name="datefilter"]').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });
            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
                document.forms['filter-form'].submit();
            });
        });
    </script>
{{--    <script src="{{URL::asset('assets/vendor/select2/select2.js')}}"></script>--}}
{{--    <script src="{{URL::asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js')}}"></script>--}}
{{--    <script src="{{URL::asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js')}}"></script>--}}
{{--    <script src="{{URL::asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js')}}"></script>--}}

{{--    <script src="{{URL::asset('assets/javascripts/tables/examples.datatables.default.js')}}"></script>--}}
{{--    <script src="{{URL::asset('assets/javascripts/tables/examples.datatables.row.with.details.js')}}"></script>--}}
{{--    <script src="{{URL::asset('assets/javascripts/tables/examples.datatables.tabletools.js')}}"></script>--}}
@endsection

