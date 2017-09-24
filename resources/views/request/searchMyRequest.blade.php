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
                        <form class="layui-form" action="{{ route('searchRequest') }}" method="post" lay-filter="search" >
                            {{ csrf_field() }}
                            <div class="layui-form-item">
                                <label class="layui-form-label">请假类型：</label>
                                <div class="layui-input-inline">
                                    <select name="type" lay-verify="required">
                                        <option value="请假">请假</option>
                                    </select>
                                </div>

                                <label class="layui-form-label">审批状态：</label>
                                <div class="layui-input-inline">
                                    <select name="status" lay-verify="required">
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
                                    <button class="layui-btn" >立即提交</button>
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

<script>
    layui.use(['element','form','laydate'],function(){
        var element = layui.element;
        var form = layui.form;
        var laydate = layui.laydate;

        laydate.render({
            elem:'#end',
            type:'date'
        });
        laydate.render({
            elem:'#start',
            type:'date'
        });
        $('#date').hide();

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

        form.render();
        element.init();
    });


</script>
