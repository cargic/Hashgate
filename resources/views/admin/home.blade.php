@extends('admin.base')

@section('content')

    <div class="row">
        <div class="col-sm-3">

            <div class="xe-widget xe-counter" data-count=".num" data-from="0" data-to="99.9" data-suffix="%" data-duration="2">
                <div class="xe-icon">
                    <i class="linecons-cloud"></i>
                </div>
                <div class="xe-label">
                    {{--<strong class="num">{{ $stat['today_online_users'] }}</strong>--}}
                    <span>在线人数</span>
                </div>
            </div>

            <div class="xe-widget xe-counter xe-counter-purple" data-count=".num" data-from="1" data-to="117" data-suffix="k" data-duration="3" data-easing="false">
                <div class="xe-icon">
                    <i class="linecons-user"></i>
                </div>
                <div class="xe-label">
                    {{--<strong class="num">{{ $stat['users'] }}</strong>--}}
                    <span>所有用户</span>
                </div>
            </div>

            <div class="xe-widget xe-counter xe-counter-info" data-count=".num" data-from="1000" data-to="2470" data-duration="4" data-easing="true">
                <div class="xe-icon">
                    <i class="linecons-params"></i>
                </div>
                <div class="xe-label">
                    {{--<strong class="num">{{ $stat['online_coin'] }}</strong>--}}
                    <span>在线币种</span>
                </div>
            </div>

            <div class="xe-widget xe-counter xe-counter-red" data-count=".num" data-from="1000" data-to="2470" data-duration="4" data-easing="true">
                <div class="xe-icon">
                    <i class="linecons-eye"></i>
                </div>
                <div class="xe-label">
                    {{--<strong class="num">{{ $stat['error_coin'] }}</strong>--}}
                    <strong class="num">功能未开放</strong>
                    <span>异常节点</span>
                </div>
            </div>

        </div>
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div style="display: flex;align-items: center;justify-content: space-between;">
                    <h3 style="font-size: 18px;" class="panel-title">网站首页近30日访问量</h3>
                    <div class="btn-group">
                        <button id="pv" type="button" class="btn btn-info btn-xs">PV</button>
                        <button id="uv" type="button" class="btn btn-xs">UV</button>
                    </div>
                    </div>
                    <div class="panel-options">
                    </div>
                </div>
                <div class="panel-body">
                    <div id="bar-3-pv" style="height: 310px; width: 100%;">
                        <div class="col-sm-12" id="contain" style="width: 100%;height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="bar-3" style="height: 310px; width: 100%;">
                        <div class="col-sm-12" id="headStat" style="width: 100%;height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="bar-3" style="height: 310px; width: 100%;">
                        <div class="col-sm-12" id="stayTimeStat" style="width: 100%;height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">节点收藏柱状图</h3>
                    <div class="panel-options">
                    </div>
                </div>
                <div class="panel-body">
                    <div id="bar-3" style="height: 310px; width: 100%;">
                        <div class="col-sm-12" id="star" style="width: 100%;height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">站点列表点击次数统计</h3>
                    <div class="panel-options">
                    </div>
                </div>
                <div class="panel-body">
                    <div id="bar-3" style="height: 310px; width: 100%;">
                        <div class="col-sm-12" id="listStat" style="width: 100%;height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/js/echarts.common.min.js') }}"></script>
    <script type="text/javascript">

        {{--$('#pv').click(function () {--}}
            {{--$('#pv').addClass('btn-info')--}}
            {{--$('#uv').removeClass('btn-info')--}}

            {{--getData(0);--}}
            {{--setTimeout('pvOrUvChart()', 1000);--}}
        {{--});--}}

        {{--$('#uv').click(function () {--}}
            {{--$('#uv').addClass('btn-info')--}}
            {{--$('#pv').removeClass('btn-info')--}}

            {{--getData(1);--}}
            {{--setTimeout('pvOrUvChart()', 1000);--}}
        {{--});--}}

        {{--// 访问量图标统计--}}
        {{--var dates = [];--}}
        {{--var times = [];--}}
        {{--function getData(type) {--}}
            {{--dates = [];--}}
            {{--times = [];--}}
            {{--$.post("{{ url('/webstat') }}", {--}}
                {{--"_token": "{{ csrf_token() }}","type": type--}}
            {{--}, function(data) {--}}
                {{--$.each(data, function(i, item) {--}}
                    {{--dates.push(item.date);--}}
                    {{--times.push(item.times);--}}
                {{--});--}}
            {{--});--}}
        {{--}--}}
        {{--getData(0);--}}
        {{--function pvOrUvChart() {--}}
            {{--var myChart = echarts.init(document.getElementById("contain"));--}}

            {{--option = {--}}
                {{--tooltip : {--}}
                    {{--trigger: 'axis'--}}
                {{--},--}}
                {{--legend: {--}}
                    {{--data:['访问量']--}}
                {{--},--}}
                {{--toolbox: {--}}
                    {{--show : true,--}}
                    {{--feature : {--}}
                        {{--mark : {show: true},--}}
                        {{--dataView : {show: true, readOnly: false},--}}
                        {{--magicType : {show: true, type: ['line', 'bar']},--}}
                        {{--restore : {show: true},--}}
                        {{--saveAsImage : {show: true}--}}
                    {{--}--}}
                {{--},--}}
                {{--calculable : true,--}}
                {{--xAxis : [--}}
                    {{--{--}}
                        {{--axisLine: {--}}
                            {{--lineStyle: { color: '#333' }--}}
                        {{--},--}}
                        {{--axisLabel: {--}}
                            {{--rotate: 30,--}}
                            {{--interval: 0--}}
                        {{--},--}}
                        {{--type : 'category',--}}
                        {{--boundaryGap : false,--}}
                        {{--data : dates    // x的数据，为上个方法中得到的pvdate--}}
                    {{--}--}}
                {{--],--}}
                {{--yAxis : [--}}
                    {{--{--}}
                        {{--type : 'value',--}}
                        {{--axisLabel : {--}}
                            {{--formatter: '{value} 次'--}}
                        {{--},--}}
                        {{--axisLine: {--}}
                            {{--lineStyle: { color: '#333' }--}}
                        {{--}--}}
                    {{--}--}}
                {{--],--}}
                {{--series : [--}}
                    {{--{--}}
                        {{--name:'访问量',--}}
                        {{--type:'line',--}}
                        {{--smooth: 0.3,--}}
                        {{--data: times   // y轴的数据，由上个方法中得到的pvtimes--}}
                    {{--}--}}
                {{--]--}}
            {{--};--}}
            {{--// 使用刚指定的配置项和数据显示图表。--}}
            {{--myChart.setOption(option);--}}
        {{--}--}}
        {{--setTimeout('pvOrUvChart()', 1000);--}}

        {{--// 收藏柱状图统计--}}
        {{--var  coin_name= [];--}}
        {{--var  sum= [];--}}
        {{--function getStarsData() {--}}
            {{--$.post("{{ url('/getStarsStat') }}", {--}}
                {{--"_token": "{{ csrf_token() }}"--}}
            {{--}, function(data) {--}}
                {{--$.each(data, function(i, item) {--}}
                    {{--coin_name.push(item.coin_name);--}}
                    {{--sum.push(item.star_count);--}}
                {{--});--}}
            {{--});--}}
        {{--}--}}
        {{--getStarsData();--}}
        {{--function starChart() {--}}
            {{--var myChart = echarts.init(document.getElementById("star"));--}}

            {{--option = {--}}
                {{--tooltip : {--}}
                    {{--trigger: 'axis'--}}
                {{--},--}}
                {{--legend: {--}}
                    {{--data:['收藏量']--}}
                {{--},--}}
                {{--toolbox: {--}}
                    {{--show : true,--}}
                    {{--feature : {--}}
                        {{--mark : {show: true},--}}
                        {{--dataView : {show: true, readOnly: false},--}}
                        {{--magicType : {show: true, type: ['line', 'bar']},--}}
                        {{--restore : {show: true},--}}
                        {{--saveAsImage : {show: true}--}}
                    {{--}--}}
                {{--},--}}
                {{--calculable : true,--}}
                {{--xAxis : [--}}
                    {{--{--}}
                        {{--type : 'category',--}}
                        {{--data : coin_name,--}}
                        {{--axisLabel: {interval:0}--}}
                    {{--}--}}
                {{--],--}}
                {{--yAxis : [--}}
                    {{--{--}}
                        {{--type : 'value'--}}
                    {{--}--}}
                {{--],--}}
                {{--series : [--}}
                    {{--{--}}
                        {{--color:'#40bbea',--}}
                        {{--name:'收藏量',--}}
                        {{--type:'bar',--}}
                        {{--data: sum,--}}
                        {{--markPoint : {--}}
                            {{--data : [--}}
                                {{--{type : 'max', name: '最大值'},--}}
                                {{--{type : 'min', name: '最小值'}--}}
                            {{--]--}}
                        {{--},--}}
                    {{--}--}}
                {{--]--}}
            {{--};--}}

            {{--// 使用刚指定的配置项和数据显示图表。--}}
            {{--myChart.setOption(option);--}}
        {{--}--}}
        {{--setTimeout('starChart()', 1000);--}}

        {{--// 首页语言统计--}}
        {{--var  head_stat = '';--}}
        {{--function getHeadData() {--}}
            {{--$.post("{{ url('/headStat') }}", {--}}
                {{--"_token": "{{ csrf_token() }}"--}}
            {{--}, function(data) {--}}
                {{--head_stat = data;--}}
            {{--});--}}
        {{--}--}}
        {{--getHeadData();--}}
        {{--function headStatChart() {--}}
            {{--var myChart = echarts.init(document.getElementById("headStat"));--}}

            {{--option = {--}}
                {{--title : {--}}
                    {{--text: '站点用户使用语言比例',--}}
                    {{--// subtext: '纯属虚构',--}}
                    {{--x:'center'--}}
                {{--},--}}
                {{--tooltip : {--}}
                    {{--trigger: 'item',--}}
                    {{--formatter: "{a} <br/>{b} : {c} 次 ({d}%)"--}}
                {{--},--}}
                {{--legend: {--}}
                    {{--orient: 'vertical',--}}
                    {{--left: 'left',--}}
                {{--},--}}
                {{--series : [--}}
                    {{--{--}}
                        {{--name: '访问来源',--}}
                        {{--type: 'pie',--}}
                        {{--radius : '55%',--}}
                        {{--center: ['50%', '60%'],--}}
                        {{--data:head_stat,--}}
                        {{--itemStyle: {--}}
                            {{--emphasis: {--}}
                                {{--shadowBlur: 10,--}}
                                {{--shadowOffsetX: 0,--}}
                                {{--shadowColor: 'rgba(0, 0, 0, 0.5)'--}}
                            {{--}--}}
                        {{--}--}}
                    {{--}--}}
                {{--]--}}
            {{--};--}}

            {{--// 使用刚指定的配置项和数据显示图表。--}}
            {{--myChart.setOption(option);--}}
        {{--}--}}
        {{--setTimeout('headStatChart()', 1000);--}}

        {{--// 详情停留时间统计--}}
        {{--var  stay_time_stat = '';--}}
        {{--function getStayTimeData() {--}}
            {{--$.post("{{ url('/detailStayTimeStat') }}", {--}}
                {{--"_token": "{{ csrf_token() }}"--}}
            {{--}, function(data) {--}}
                {{--stay_time_stat = data;--}}
            {{--});--}}
        {{--}--}}
        {{--getStayTimeData();--}}
        {{--function stayTimeStatChart() {--}}
            {{--var myChart = echarts.init(document.getElementById("stayTimeStat"));--}}

            {{--option = {--}}
                {{--title : {--}}
                    {{--text: '币种详情页面停留时间比例图',--}}
                    {{--subtext: '单位：S（秒）',--}}
                    {{--x:'center'--}}
                {{--},--}}
                {{--tooltip : {--}}
                    {{--trigger: 'item',--}}
                    {{--formatter: "{a} <br/>{b} : {c} s ({d}%)"--}}
                {{--},--}}
                {{--legend: {--}}
                    {{--orient: 'vertical',--}}
                    {{--left: 'left',--}}
                {{--},--}}
                {{--series : [--}}
                    {{--{--}}
                        {{--name: '所属币种',--}}
                        {{--type: 'pie',--}}
                        {{--radius : '55%',--}}
                        {{--center: ['50%', '60%'],--}}
                        {{--data:stay_time_stat,--}}
                        {{--itemStyle: {--}}
                            {{--emphasis: {--}}
                                {{--shadowBlur: 10,--}}
                                {{--shadowOffsetX: 0,--}}
                                {{--shadowColor: 'rgba(0, 0, 0, 0.5)'--}}
                            {{--}--}}
                        {{--}--}}
                    {{--}--}}
                {{--]--}}
            {{--};--}}

            {{--// 使用刚指定的配置项和数据显示图表。--}}
            {{--myChart.setOption(option);--}}
        {{--}--}}
        {{--setTimeout('stayTimeStatChart()', 1000);--}}

        {{--var  list_name= [];--}}
        {{--var  list_times= [];--}}
        {{--function getListData()--}}
        {{--{--}}
            {{--$.post("{{ url('/listStat') }}", {--}}
                {{--"_token": "{{ csrf_token() }}"--}}
            {{--}, function(data) {--}}
                {{--$.each(data, function(i, item) {--}}
                    {{--list_name.push(item.name);--}}
                    {{--list_times.push(item.value);--}}
                {{--});--}}
            {{--});--}}
        {{--}--}}
        {{--getListData();--}}
        {{--function listChart() {--}}
            {{--var myChart = echarts.init(document.getElementById("listStat"));--}}

            {{--option = {--}}
                {{--title : {--}}
                    {{--// text: '站点用户使用语言比例',--}}
                    {{--subtext: '注：+（正序） -（倒序）',--}}
                    {{--x:'center'--}}
                {{--},--}}
                {{--tooltip : {--}}
                    {{--trigger: 'axis'--}}
                {{--},--}}
                {{--// legend: {--}}
                {{--//     data:['点击量']--}}
                {{--// },--}}
                {{--toolbox: {--}}
                    {{--show : true,--}}
                    {{--feature : {--}}
                        {{--mark : {show: true},--}}
                        {{--dataView : {show: true, readOnly: false},--}}
                        {{--magicType : {show: true, type: ['line', 'bar']},--}}
                        {{--restore : {show: true},--}}
                        {{--saveAsImage : {show: true}--}}
                    {{--}--}}
                {{--},--}}
                {{--calculable : true,--}}
                {{--xAxis : [--}}
                    {{--{--}}
                        {{--type : 'category',--}}
                        {{--data : list_name,--}}
                        {{--axisLabel: {--}}
                            {{--rotate: 30,--}}
                            {{--interval:0--}}
                        {{--}--}}
                    {{--}--}}
                {{--],--}}
                {{--yAxis : [--}}
                    {{--{--}}
                        {{--type : 'value'--}}
                    {{--}--}}
                {{--],--}}
                {{--series : [--}}
                    {{--{--}}
                        {{--color:'#91c7ae',--}}
                        {{--name:'点击量',--}}
                        {{--type:'bar',--}}
                        {{--data: list_times,--}}
                        {{--markPoint : {--}}
                            {{--data : [--}}
                                {{--{type : 'max', name: '最大值'},--}}
                                {{--{type : 'min', name: '最小值'}--}}
                            {{--]--}}
                        {{--},--}}
                    {{--}--}}
                {{--]--}}
            {{--};--}}

            {{--// 使用刚指定的配置项和数据显示图表。--}}
            {{--myChart.setOption(option);--}}
        {{--}--}}
        {{--setTimeout('listChart()', 1000);--}}


    </script>

@endsection