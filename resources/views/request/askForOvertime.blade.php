<span class="layui-breadcrumb">
  <a href="">首页</a>
  <a href="">我的申请</a>
  <a><cite>我要加班</cite></a>
</span>

<div class="site-title">
    <fieldset>
        <legend><a name="fieldset">新建加班申请</a></legend>
    </fieldset>
</div>

<div class="layui-row">
    <div class="layui-col-md9">
        <form class="layui-form">
            {{ csrf_field() }}
            <div class="layui-form-item">
                <label class="layui-form-label">加班类型：</label>
                <div class="layui-input-inline">
                    <select name="type" lay-verify="required">
                        <option value="平日">平日</option>
                        <option value="周末">周末</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">加班理由：</label>
                <div class="layui-input-block">
                    <input type="text" name="reason" lay-verify="required" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">加班时间：</label>
                <div class="layui-input-inline">
                    <input type="text" id="start" name="start" lay-verify="required" class="layui-input">
                </div>
                <div class="layui-form-mid">~</div>
                <div class="layui-input-inline">
                    <input type="text" id="end" name="end" lay-verify="required" class="layui-input">
                </div>

            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">附言/备注：</label>
                <div class="layui-input-block">
                    <textarea name="message" placeholder="请输入内容" class="layui-textarea"></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="submit">立即提交</button>
                    <button id="reset" type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    layui.use(['form', 'laydate', 'element'], function () {
        var form = layui.form;
        var laydate = layui.laydate;
        var element = layui.element;

        laydate.render({
            elem: '#start',
            type: 'datetime'
        });

        var starttime = $('#start').val();
        laydate.render({
            elem: '#end',
            type: 'datetime'
//            min:starttime
        });

        form.render();
        console.log('form is rendering');

        element.init();

        form.on('submit(submit)', function (data) {
            var start = data.field.start;
            var end = data.field.end;
            if (isDateValid(start, end) == false) {
                layer.msg('你输入的时间范围无效！', {icon: 5});
                return false;
            }
//            console.log(data.field);
            createNewOvertime(data.field);
            $('#reset').click();
            return false;
        });
    });

    function createNewOvertime(form) {
        var url = '{{ route('createOvertime') }}';
        $.post(url, form, function (data, status) {
            if (status == 'success' && data == "createOvertimeSuccessed") {
                message('新的加班申请提交成功！');
            } else {
                return false;
            }
        })
    }


</script>

