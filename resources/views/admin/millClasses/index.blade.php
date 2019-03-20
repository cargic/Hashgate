@extends('admin.base')

@section('top')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">矿机分类</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <a href="{{ route('admin.home') }}"><i class="fa-home"></i>数据统计</a>
                </li>
                <li>
                    <a href="{{ route('millClasses.index') }}">分类管理</a>
                </li>
                <li class="active">

                    <strong>分类列表</strong>
                </li>
            </ol>

        </div>

    </div>
@endsection


@section('content')
    <div class="panel panel-default">

        <a href="{{ route('millClasses.create') }}"><button type="button" class="btn btn-success" style="float: right;">添加分类</button></a>
        <div class="panel-body">

            <div id="example-2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <table class="table table-bordered table-striped dataTable no-footer" id="example-2" role="grid" aria-describedby="example-2_info">
                    <thead>
                    <tr role="row">
                        <th style="width: 60px;">排序</th>
                        <th>分类名称</th>
                        <th>所属分类</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                    </thead>

                    <tbody class="middle-align">
                    @foreach($list as $k=>$v)
                        <tr role="row" @if($k%2 !== 0) class="odd" @else class="even" @endif>
                            <td>
                                <input style="width: 50px; !important;" class="{{ 'sort_'.$v['id'] }}" data-id="{{ $v['id'] }}" type="text" value="{{ $v['sort'] }}">
                            </td>
                            <td>{{ $v['class_name'] }}</td>
                            <td>{{ $v['parent_id'] }}</td>
                            <td>{{ $v['created_at'] }}</td>
                            <td>{{ $v['updated_at'] }}</td>
                            <td>
                                <a href="{{ url('millClasses/'.$v['id'].'/edit') }}" class="btn btn-secondary btn-sm btn-icon icon-left">
                                    编辑
                                </a>

                                <a href="javascript:;" onclick="delart({{ $v['id'] }})" class="btn btn-danger btn-sm btn-icon icon-left">
                                    删除
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if(!empty($list))
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="dataTables_info" id="example-2_info" role="status" aria-live="polite">Showing 1 to 10 of 60 entries</div>
                        </div>
                        <div class="col-xs-6">
                            <div class="dataTables_paginate paging_simple_numbers" id="example-2_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button previous disabled" aria-controls="example-2" tabindex="0" id="example-2_previous"><a href="{{ $page->url(1) }}">Previous</a></li>
                                    @for($i = 1; $i <= $page->lastpage(); $i++)
                                        <li class="paginate_button {{ $page->currentPage() == $i ? 'active' : '' }}" aria-controls="example-2" tabindex="0"><a href="{{ $page->url($i) }}">{{ $i }}</a></li>
                                    @endfor
                                    <li class="paginate_button next" aria-controls="example-2" tabindex="0" id="example-2_next"><a href="{{ $page->url($page->lastPage()) }}">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>

    <script>
        function delart(id) {
            layer.confirm('您确定要删除嘛？', {
                btn: ['确定','再考虑一下'] //按钮
            }, function(){
                $.post("{{ url('millClasses') }}/"+id, {'_token':'{{ csrf_token() }}', '_method':'delete'},
                    function (data) {
                        if(data.status = 1){
                            location.reload();
                            layer.alert(data.msg, {icon: 6});
                        }else {
                            layer.alert(data.msg, {icon: 5});
                        }
                    })
            });
        }

        $("input[class^=sort_]").blur(function () {
            var id = $(this).data('id');
            var sort = $(this).val();
            $.ajax({
                cache: true,
                type: "GET",
                url:"{{ url('modifymillClassesSort') }}",
                data:{"id":id,"sort":sort},
                error: function(request) {
                    console.log(request);
                },
                success: function(data) {
                    if(data.state){
                        location.reload()
                    }else {
                        layer.alert(data.msg, {icon: 5});
                    }
                }
            })
        })
    </script>

@endsection