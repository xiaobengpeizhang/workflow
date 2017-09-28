<span class="layui-breadcrumb">
  <a href="">首页</a>
  <a href="">我的申请</a>
  <a><cite>查询申请记录</cite></a>
</span>

<div class="site-title">
    <fieldset><legend><a name="fieldset">查询申请记录</a></legend></fieldset>
</div>

<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md10">
            <div class="layui-collapse">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">选择查询条件</h2>
                    <div class="layui-colla-content layui-show">
                        <form class="layui-form" lay-filter="search" >
                            {{ csrf_field() }}
                            <div class="layui-form-item">
                                <label class="layui-form-label">请假类型：</label>
                                <div class="layui-input-inline">
                                    <select id="type" name="type" lay-verify="required">
                                        <option value="请假">请假</option>
                                        <option value="加班">加班</option>
                                    </select>
                                </div>

                                <label class="layui-form-label">审批状态：</label>
                                <div class="layui-input-inline">
                                    <select id="status" name="status" lay-verify="required">
                                        <option value="等待中">等待中</option>
                                        <option value="已通过">已通过</option>
                                        <option value="被拒绝">被拒绝</option>

                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">时间范围：</label>
                                <div id="radio">
                                    <div class="layui-input-block">
                                        <input type="radio" name="range" value="7days" title="最近一周" lay-filter="7Days">
                                        <input type="radio" name="range" value="30days" title="最近一个月" lay-filter="30Days">
                                        <input type="radio" name="range" value="90days" title="最近三个月" lay-filter="90Days">
                                        <input type="radio" name="range" value="setDays" title="自定义时间段" lay-filter="setDays">
                                    </div>
                                </div>
                                <div id="date">
                                    <div class="layui-input-inline">
                                        <input type="text" id="start" name="start" lay-verify="required"  class="layui-input">
                                    </div>
                                    <div class="layui-form-mid">~</div>
                                    <div class="layui-input-inline">
                                        <input type="text" id="end" name="end" lay-verify="required"  class="layui-input">
                                    </div>
                                    <div class="layui-input-inline">
                                        <input type="radio" name="range" title="返回选择" lay-filter="goback">
                                    </div>
                                </div>

                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit lay-filter="search">搜索</button>
                                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="site-title">
    <fieldset><legend><a name="fieldset">申请记录</a></legend></fieldset>
</div>
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md10">
            <table id="table" lay-filter="table"></table>

        </div>
    </div>
</div>



<script>
    layui.use(['element','form','laydate','layer','table'],function(){
        var element = layui.element;
        var form = layui.form;
        var laydate = layui.laydate;
        var layer = layui.layer;
        var table = layui.table;

        laydate.render({
            elem:'#end',
            type:'date'
        });
        laydate.render({
            elem:'#start',
            type:'date'
        });
        $('#date').hide();
        $('#table').hide();


        var now = new Date();
        form.on('radio(7Days)',function(data){
            console.log(data.value);
            $('#start').val(getBeforNday(now,7).replace(/\//g,'-'));
            $('#end').val(now.format('yyyy-MM-dd'));
        });
        form.on('radio(30Days)',function(data){
            console.log(data.value);
            $('#start').val(getBeforNday(now,30).replace(/\//g,'-'));
            $('#end').val(now.format('yyyy-MM-dd'));
        });
        form.on('radio(90Days)',function(data){
            console.log(data.value);
            $('#start').val(getBeforNday(now,90).replace(/\//g,'-'));
            $('#end').val(now.format('yyyy-MM-dd'));
        });

        form.on('radio(setDays)',function(data){
            console.log(data.value);
            $('#radio').hide();
            $('#date').show();
        });

        form.on('radio(goback)',function(){
            $('#radio').show();
            $('#date').hide();
        });

        form.on('submit(search)',function(data){
            var start = data.field.start;
            var end = data.field.end;
            if(isDateValid(start,end) == false){
                layer.msg('你输入的时间范围无效！',{icon:5});
            }
            getSearchResult(data.field,table);
            $('#table').show();
            return false;  //阻止页面跳转
        });
        form.render();
        element.init();

        table.on('tool(table)',function(obj){
            var url = '{{ route('getLeaveDetail') }}'+'/'+obj.data.requestNo;

            $.get(url,function(data,status){
                if(status == 'success'){
                    layer.open({
                        title:'详细信息',
                        content:data,
                        area:['500px','500px']
                    });
                }
            })
        });

    });

    function getSearchResult(form,table){
        table.render({
            url:'{{ route('searchRequest') }}',
            where:form,
            elem:'#table',
            id:'requestNo',
            height:315,
            page:true,
            cols:[[
                {checkbox:true},
                {field:'requestNo',title:'申请编号',width:150,sort:true},
                {field:'requestType',title:'申请类型',width:100,sort:true},
                {field:'type',title:'具体类型',width:100,sort:true},
                {field:'description',title:'当前进度',width:230,sort:true},
                {field:'created_at',title:'申请提交时间',width:200,sort:true},
                {title:'操作',toolbar:'#tool',width:115}
            ]]
        })
    }

</script>

<script type="text/html" id="tool">
    <a class="layui-table-link" lay-event="detail">查看详情</a>
</script>

