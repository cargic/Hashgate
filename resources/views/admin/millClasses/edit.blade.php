@include('UEditor::head')
@extends('admin.base')

@section('top')
    <div class="page-title">

        <div class="title-env">
            <h1 class="title">编辑商品</h1>
        </div>

        <div class="breadcrumb-env">

            <ol class="breadcrumb bc-1">
                <li>
                    <a href="{{ route('admin.home') }}"><i class="fa-home"></i>数据统计</a>
                </li>
                <li>
                    <a href="{{ route('goods.index') }}">商品管理</a>
                </li>
                <li class="active">

                    <strong>编辑商品</strong>
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

                    <form role="form" class="form-horizontal" method="post" action="{{ url('goods').'/'.$goods->id }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" value="PUT" name="_method">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1"><span style="color: red;">注意事项：</span></label>

                            <label class="col-sm-3 control-label" for="field-1"><span style="color: red;">红色标记部分为必填项，其余可以选填并按要求填写。</span></label>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-5">商品分类：</label>

                            <div class="col-sm-3 form-block">
                                @if(!empty($categories))
                                    @foreach($categories as $k=>$v)
                                        <div class="cbr-replaced @if(in_array($v['id'], $goods->category_ids_array)) cbr-checked @endif" id="category_checked_{{ $v['id'] }}"><div class="cbr-input">
                                                <input type="checkbox" name="category_{{ $v['id'] }}" value="{{ $v['id'] }}"  @if(in_array($v['id'], $goods->category_ids_array)) checked @endif class="cbr cbr-done">
                                            </div><div class="cbr-state"><span></span></div></div>
                                        {{ $v['name'] }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    @endforeach
                                @endif
                                @if( $goods->category_ids )
                                        <input type="hidden" id="categoryIds" name="category_ids" value="{{ $goods->category_ids  }}">
                                @else
                                        <input type="hidden" id="categoryIds" name="category_ids" value="">
                                @endif
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1"><span style="color: red;">*&nbsp;</span>Icon：</label>

                            <div id="goods_icon" class="col-sm-10" style="display: flex">
                                <div style="width: 100px; text-align: center; margin-right: 10px;">
                                    <img style="margin-right: 10px;" width="100" height="100" src="{{ asset('admin/images/goods_icon_1.png') }}" alt="">
                                    <br><input  type="radio" name="icon" value="admin/images/goods_icon_1.png" @if( strstr($goods->icon,'goods_icon_1.png') ) checked @endif>
                                </div>
                                <div style="width: 100px; text-align: center; margin-right: 10px;">
                                    <img style="margin-right: 10px;" width="100" height="100" src="{{ asset('admin/images/goods_icon_2.png') }}" alt="">
                                    <br><input type="radio" name="icon" value="admin/images/goods_icon_2.png" @if( strstr($goods->icon,'goods_icon_2.png') ) checked @endif>
                                </div>
                                <div style="width: 100px; text-align: center; margin-right: 10px;">
                                    <img style="margin-right: 10px;" width="100" height="100" src="{{ asset('admin/images/goods_icon_3.png') }}" alt="">
                                    <br><input type="radio" name="icon" value="admin/images/goods_icon_3.png" @if( strstr($goods->icon,'goods_icon_3.png') ) checked @endif>
                                </div>
                                <div style="width: 100px; text-align: center; margin-right: 10px;">
                                    <img style="margin-right: 10px;" width="100" height="100" src="{{ asset('admin/images/goods_icon_4.png') }}" alt="">
                                    <br><input type="radio" name="icon" value="admin/images/goods_icon_4.png" @if( strstr($goods->icon,'goods_icon_4.png') ) checked @endif>
                                </div>
                                @if( $goods->ext_icon )
                                    <div style="width: 100px; text-align: center; margin-right: 10px;">
                                        <img style="margin-right: 10px;" width="100" height="100" src="{{ $goods->icon }}" alt="">
                                        <br><input type="radio" name="icon" value="{{ $goods->icon }}" checked>
                                    </div>
                                @endif
                                <button id="upload_icon_btn" class="btn" type="button" style="width: 100px;height: 100px; border: 1px dashed darkgray;position:relative;">
                                    <p style="font-size: 30px;">+</p>
                                    <p>点击上传图片</p>
                                    <input style="width: 100px;height: 100px;opacity: 0; position: absolute;top: 0;left: 0" id="upload_icon" type="file" class="form-control" onchange="uploadGoodsIcon(this)">
                                </button>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1"><span style="color: red;">*&nbsp;</span>商品名称：</label>

                            <div class="col-sm-3">
                                <input type="text" name="goods_name" class="form-control" id="field-1" placeholder="中文" value="{{ $goods->goods_name }}">
                            </div>

                            <label class="col-sm-2 control-label" for="field-1">（EN）商品名称：</label>

                            <div class="col-sm-3">
                                <input type="text" name="goods_name_en" class="form-control" id="field-1" placeholder="英语" value="{{ $goods->goods_name_en }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-5"><span style="color: red;">* </span>商品图：</label>

                            <div class="col-sm-10" id="goods_picture" style="display: flex">
                                @if( $goods->picture_array )
                                    @foreach( $goods->picture_array as $picture )
                                        <div><img width="100" height="100" src="{{ $picture }}" alt=""></div>&nbsp;&nbsp;
                                    @endforeach
                                    <input id="picture_value" type="hidden" name="picture" value="{{ $goods->picture }}">
                                @else
                                    <input id="picture_value" type="hidden" name="picture" value="">
                                @endif
                                <button class="btn" type="button" style="width: 100px;height: 100px; border: 1px dashed darkgray;position:relative; margin-bottom: 0px;">
                                    <p style="font-size: 30px;">+</p>
                                    <p>点击上传图片</p>
                                    <input style="width: 100px;height: 100px;opacity: 0; position: absolute;top: 0;left: 0" id="upload_picture" type="file" name="picture" class="form-control" onchange="uploadGoodsPicture(this)">
                                </button>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1"><span style="color: red;">* </span>原价：</label>

                            <div class="col-sm-3">
                                <span style="display: flex;">
                                    <select name="price_unit" class="btn btn-success">
                                        <option value="3" @if($goods->price_unit == 1) selected @endif>฿</option>
                                        <option value="1" @if($goods->price_unit == 2) selected @endif>$</option>
                                        <option value="2" @if($goods->price_unit == 3) selected @endif>¥</option>
                                    </select>
                                    <input type="text" name="price" class="form-control" id="field-1" placeholder="" value="{{ $goods->price }}">
                                </span>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1">现价：</label>

                            <div class="col-sm-3">
                                <span style="display: flex;">
                                    <select name="new_price_unit" class="btn btn-success">
                                        <option value="3" @if($goods->price_unit == 1) selected @endif>฿</option>
                                        <option value="1" @if($goods->price_unit == 2) selected @endif>$</option>
                                        <option value="2" @if($goods->price_unit == 3) selected @endif>¥</option>
                                    </select>
                                    <input type="text" name="new_price" class="form-control" id="field-1" placeholder="" value="{{ $goods->new_price }}">
                                </span>
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1">Web尺寸：</label>

                            <div class="col-sm-3">
                                <input type="text" name="web_size" class="form-control" id="field-1" placeholder="" value="{{ $goods->web_size }}">
                            </div>

                            <label class="col-sm-2 control-label" for="field-1">Phone尺寸：</label>

                            <div class="col-sm-3">
                                <input type="text" name="phone_size" class="form-control" id="field-1" placeholder="" value="{{ $goods->phone_size }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1">支持格式：</label>

                            <div class="col-sm-3">
                                <input type="text" name="format" class="form-control" id="field-1" placeholder="如：jpg、jpeg、png" value="{{ $goods->format }}">
                            </div>

                            <label class="col-sm-2 control-label" for="field-1">生命周期：</label>

                            <div class="col-sm-3">
                                <input type="text" name="life" class="form-control" id="field-1" placeholder="如：per week" value="{{ $goods->life }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1"><span style="color: red;">* </span>中文概要：</label>

                            <div class="col-sm-8">
                                <input type="text" name="abstract" class="form-control" id="field-1" placeholder="" value="{{ $goods->abstract }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1"><span style="color: red;">* </span>英文概要：</label>

                            <div class="col-sm-8">
                                <input type="text" name="abstract_en" class="form-control" id="field-1" placeholder="" value="{{ $goods->abstract_en }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-5">（CN）商品详情：</label>

                            <texteare id="content" style="display: none">{{ $goods->detail }}</texteare>

                            <div class="col-sm-10">

                                <!-- 加载编辑器的容器 -->
                                <script id="container" name="detail" type="text/plain" style="width:1120px;height:300px"></script>

                                <!-- 实例化编辑器 -->
                                <script type="text/javascript">
                                var ue = UE.getEditor('container');
                                ue.ready(function() {
                                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                });
                                </script>

                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-5">（EN）商品详情：</label>

                            <texteare id="content_en" style="display: none">{{ $goods->detail_en }}</texteare>

                            <div class="col-sm-10">

                                <!-- 加载编辑器的容器 -->
                                <script id="container_en" name="detail_en" type="text/plain" style="width:1120px;height:300px"></script>

                                <!-- 实例化编辑器 -->
                                <script type="text/javascript">
                                var ue = UE.getEditor('container_en');
                                ue.ready(function() {
                                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                });
                                </script>

                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1">Discord：</label>

                            <div class="col-sm-3">
                                <input type="text" name="discord" class="form-control" id="field-1" placeholder="" value="{{ $goods->discord }}">
                            </div>

                            <label class="col-sm-2 control-label" for="field-1">Email：</label>

                            <div class="col-sm-3">
                                <input type="text" name="email" class="form-control" id="field-1" placeholder="" value="{{ $goods->email }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1">Twitter：</label>

                            <div class="col-sm-3">
                                <input type="text" name="twitter" class="form-control" id="field-1" placeholder="" value="{{ $goods->twitter }}">
                            </div>

                            <label class="col-sm-2 control-label" for="field-1">Wechat：</label>

                            <div class="col-sm-3">
                                <input type="text" name="wechat" class="form-control" id="field-1" placeholder="" value="{{ $goods->wechat }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1">QQ：</label>

                            <div class="col-sm-3">
                                <input type="text" name="qq" class="form-control" id="field-1" placeholder="" value="{{ $goods->qq }}">
                            </div>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-1">排序：</label>

                            <div class="col-sm-1">
                                <input type="text" name="sort" class="form-control" id="field-1" placeholder="（可选）" value="{{ $goods->sort }}">
                            </div>

                            <label class="col-sm-3 control-label" style="color: red;" for="field-1">注：大于0的正数，数值越大排序越靠前 </label>
                        </div>

                        <div class="form-group-separator"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="field-5"></label>

                            <div class="col-sm-10">
                                <button type="submit" id="submit_before" class="btn btn-success">编辑商品</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <script src="{{ asset('admin/js/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>
        window.onload = function(){
            var ue = UE.getEditor('container');
            var content = $('#content').text();
            ue.ready(function() {
                ue.setContent(content);
            });

            var ue_en = UE.getEditor('container_en');
            var content_en = $('#content_en').text();
            ue_en.ready(function() {
                ue_en.setContent(content_en);
            });
        };

        $('#submit_before').click(function () {
            var vals = '';
            $('input[type=checkbox]:checked').each(function (index, item) {
                vals += $(this).val() +',';
            });
            console.log(vals)
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

        function uploadGoodsIcon() {
            var fileObj = document.getElementById("upload_icon").files[0]; // js 获取文件对象
            if (fileObj.size <= 0) {
                alert("请选择文件");
                return;
            }

            var formFile = new FormData();
            formFile.append("file", fileObj); //加入文件对象
            formFile.append('_token',"{{ csrf_token() }}")

            $.ajax({
                url: "{{ url('uploadGoodsPicture') }}",
                data: formFile,
                type: "post",
                cache: false,//上传文件无需缓存
                processData: false,//用于对data参数进行序列化处理 这里必须false
                contentType: false, //必须
                success: function (result) {
                    if(result.status){
                        var iconPath = result.data;
                        var imgHtml = '<div style="width: 100px; text-align: center; margin-right: 10px;"><img style="margin-right: 10px;" width="100" height="100" src="'+iconPath+'" alt=""><br><input  type="radio" name="icon" value="'+iconPath+'"></div>';
                        $('#goods_icon').prepend(imgHtml);
                    }else {
                        layer.alert(data.msg, {icon: 5});
                    }
                },
            })
        }

        function uploadGoodsPicture() {
            var fileObj = document.getElementById("upload_picture").files[0]; // js 获取文件对象
            if (fileObj.size <= 0) {
                alert("请选择文件");
                return;
            }

            var formFile = new FormData();
            formFile.append("file", fileObj); //加入文件对象
            formFile.append('_token',"{{ csrf_token() }}")

            $.ajax({
                url: "{{ url('uploadGoodsPicture') }}",
                data: formFile,
                type: "post",
                cache: false,//上传文件无需缓存
                processData: false,//用于对data参数进行序列化处理 这里必须false
                contentType: false, //必须
                success: function (result) {
                    if(result.status){
                        var picPath = result.data;
                        var imgHtml = '<div><img width="100" height="100" src="'+picPath+'" alt=""></div>&nbsp;&nbsp;';
                        $('#goods_picture').prepend(imgHtml);
                        var pictureValue = $('#picture_value').val();
                        if(pictureValue){
                            $('#picture_value').val(pictureValue + ','+ picPath)
                        }else {
                            $('#picture_value').val(picPath)
                        }

                    }else {
                        layer.alert(data.msg, {icon: 5});
                    }
                },
            })
        }
    </script>

@endsection