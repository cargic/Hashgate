@extends('admin.base')

@section('top')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">矿机列表</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <a href="{{ route('admin.home') }}"><i class="fa-home"></i>数据统计</a>
                </li>
                <li>
                    <a href="{{ route('mill.index') }}">矿机管理</a>
                </li>
                <li class="active">

                    <strong>矿机列表</strong>
                </li>
            </ol>

        </div>

    </div>
@endsection


@section('content')
    <div class="panel panel-default">
        <div class="panel-body">

            <div id="example-2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <table class="table table-bordered table-striped dataTable no-footer" id="example-2" role="grid" aria-describedby="example-2_info">
                    <thead>
                    <tr role="row">
                        {{--<th style="width: 60px;">排序</th>--}}
                        <th style="width: 100px;">矿机编号</th>
                        <th>当前状态</th>
                        <th>IP</th>
                        <th>24H在线率</th>
                        <th style="width: 100px;">所在矿池</th>
                        <th style="width: 100px;">备注</th>
                        <th style="width: 150px;">操作</th>
                    </tr>
                    </thead>

                    <tbody class="middle-align">
                    @foreach($list as $k=>$v)
                        <tr role="row" @if($k%2 !== 0) class="odd" @else class="even" @endif>
                            {{--<td></td>--}}
                            <td>{{ $v['mill_number'] }}</td>
                            <td>{{ $v['status'] }}</td>
                            <td>{{ $v['ip'] }}</td>
                            <td>{{ $v['online_24hr'] }}</td>
                            <td>{{ $v['remark'] }}</td>
                            <td>{{ $v['updated_at'] }}</td>
                            <td>
                                <a href="{{ url('mill/'.$v['id'].'/edit') }}" class="btn btn-secondary btn-sm btn-icon icon-left">
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
                $.post("{{ url('mill') }}/"+id, {'_token':'{{ csrf_token() }}', '_method':'delete'},
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

        {{--$("input[class^=sort_]").blur(function () {--}}
            {{--var id = $(this).data('id');--}}
            {{--var sort = $(this).val();--}}
            {{--$.ajax({--}}
                {{--cache: true,--}}
                {{--type: "GET",--}}
                {{--url:"{{ url('modifymillSort') }}",--}}
                {{--data:{"id":id,"sort":sort},--}}
                {{--error: function(request) {--}}
                    {{--console.log(request);--}}
                {{--},--}}
                {{--success: function(data) {--}}
                    {{--if(data.state){--}}
                        {{--location.reload()--}}
                    {{--}else {--}}
                        {{--layer.alert(data.msg, {icon: 5});--}}
                    {{--}--}}
                {{--}--}}
            {{--})--}}
        {{--})--}}
    </script>

@endsection