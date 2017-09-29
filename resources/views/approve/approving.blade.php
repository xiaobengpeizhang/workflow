
<span class="layui-breadcrumb">
  <a href="">首页</a>
  <a href="">我的审批</a>
  <a><cite>待处理</cite></a>
</span>

<div class="site-title">
    <fieldset><legend><a name="fieldset">待处理申请列表</a></legend></fieldset>
</div>

<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md10">
            <table id="table" lay-filter="table"></table>

        </div>
    </div>
</div>


<script>
    layui.use(['element','table','form'],function(){
        var element = layui.element;
        var table = layui.table;
        var form = layui.form;

        $('#approveForm').hide();
        element.init();
        table.render({
            url:'{{ route('getApproveList') }}',
            elem:'#table',
            id:'requestNo',
            height:410,
            page:true,
            cols:[[
                {checkbox:true},
                {field:'requestNo',title:'申请编号',width:150,sort:true},
                {field:'realName',title:'申请人',width:100,sort:true},
                {field:'requestType',title:'申请类型',width:100,sort:true},
                {field:'description',title:'当前进度',width:230,sort:true},
                {field:'created_at',title:'申请提交时间',width:200,sort:true},
                {title:'操作',toolbar:'#tool',width:115}
            ]]
        });

        table.on('tool(table)',function(obj){
            var url = '{{ route('getLeaveDetail') }}'+'/'+obj.data.requestNo;
            //查看详细信息
            $.get(url,function(data,status){
                if(status == 'success'){
                    layer.open({
                        title:'详细信息',
                        content:data,
                        area:['500px','500px'],
                        btn:['同意','拒绝'],
                        yes: function(index, layero){
                            //审批弹窗
                            layer.prompt({
                                formType: 2,
                                title: '审批意见'
                            }, function(value, index, elem){
                                var url = '{{ route('agree') }}';
                                approveByteamleader(url,value,obj.data.requestNo);
                            });
                        },
                        btn2: function (index,layero) {
                            layer.prompt({
                                formType: 2,
                                title: '审批意见'
                            }, function(value, index, elem){
                                var url = '{{ route('disagree') }}';
                                approveByteamleader(url,value,obj.data.requestNo);
                            });
                            return false;
                        }

                    });
                }
            })
        });

    });
</script>

<script type="text/html" id="tool">
    <a class="layui-table-link" lay-event="detail">查看详情</a>
</script>

<script>
    function approveByteamleader(url,value,requestNo){
        $.post(url,{
            message:value,
            requestNo:requestNo
        },function(data,status){
            if(status == 'success' && data == 'updateSuccess'){
                layer.closeAll();
                message('审批意见提交成功，数据已更新！');
            }
        })
    }

</script>