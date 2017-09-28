<form class="layui-form layui-form-pane" pane>
    <div class="layui-form-item">
        <label class="layui-form-label">申请编号：</label>
        <div class="layui-input-block">
            <input class="layui-input" type="text" value="{{ $detail->requestNo }}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">请假类型：</label>
        <div class="layui-input-block">
            <input class="layui-input" type="text" value="{{ $detail->type }}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">申请理由：</label>
        <div class="layui-input-block">
            <input class="layui-input" type="text" value="{{ $detail->reason }}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">起止时间：</label>
        <div class="layui-input-block">
            <input class="layui-input" type="text" value="{{ $detail->startTime.' ~ '.$detail->endTime }}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">当前进度：</label>
        <div class="layui-input-block">
            <ul class="layui-timeline" style="margin-left: 20px;">
                @foreach($detail->getHistory as $history)
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h4 class="layui-timeline-title">{{ $history->created_at }}</h4>
                            {{--<p>{{ $history->route->description }}</p>--}}
                            <p>{{ $history->user->realName.$history->route->action.'了当前申请' }}</p>
                            <p>备注/附言：{{ $history->message }}</p>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
</form>




