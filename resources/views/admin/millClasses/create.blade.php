@extends('admin.base')

@section('top')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">添加分类</h1>
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

                    <strong>添加分类</strong>
                </li>
            </ol>

        </div>

    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">

            <div class="panel panel-default">
                <div class="panel-body">

                    <form role="form" class="form-horizontal" method="post" action="{{ route('millClasses.store') }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-5">上级分类：</label>

                            <div class="col-sm-3 form-block">
                                <select class="form-control" name="parent_id" id="">
                                    <option value="">选择上级</option>
                                    @foreach($parentClasses as $class)
                                        <option value="">{{ $class['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1"><span style="color: red;">*&nbsp;</span>分类名称：</label>

                            <div class="col-sm-3">
                                <input type="text" name="millClasses_name" class="form-control" id="field-1" value="{{ old('millClasses_name') }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1">排序：</label>

                            <div class="col-sm-1">
                                <input type="text" name="sort" class="form-control" id="field-1" placeholder="" value="{{ old('sort') }}">
                            </div>

                            <label class="col-sm-4 control-label" style="color: red;" for="field-1">注：大于0的整数，数值越大排序越靠前 </label>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-5"></label>

                            <div class="col-sm-10">
                                <button type="submit" id="submit_before" class="btn btn-success">添加分类</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        $('#submit_before').click(function () {
            var vals = '';
            $('input[type=checkbox]:checked').each(function (index, item) {
                vals += $(this).val() +',';
            });

            $('#categoryIds').val(vals);
        });

        $("div[id^='category_checked_']").click(function () {

            if($(this).children().children().attr('checked')){
                $(this).toggleClass('cbr-checked');
                $(this).children().children().attr('checked',false);
            }else {
                $(this).toggleClass('cbr-checked');
                $(this).children().children().attr('checked',true);
            }
        });
    </script>

@endsection