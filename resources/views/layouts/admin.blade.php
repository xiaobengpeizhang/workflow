<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>System</title>
    <link href="{{ asset('layui/css/layui.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">工作流系统</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="{{ asset('img/headerimg.jpg') }}" class="layui-nav-img">

                    @if (Auth::guest())
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @else
                        {{ Auth::user()->name }}
                    @endif
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="{{ route('password.request') }}">修改密码</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    退出
                </a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree" lay-filter="leftbar">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">我的申请</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;">查询申请记录</a></dd>
                        <dd><a href="javascript:;">我要请假</a></dd>
                        <dd><a href="javascript:;">我要加班</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">我的审批</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;">待处理</a></dd>
                        <dd><a href="javascript:;">已处理</a></dd>
                    </dl>
                </li>
                {{--<li class="layui-nav-item"><a href="">云市场</a></li>--}}
                {{--<li class="layui-nav-item"><a href="">发布商品</a></li>--}}
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div id="content" style="padding: 15px;">
            @yield('content')
        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © workflow.com - created by xiaobeng
    </div>
</div>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('layui/layui.js') }}"></script>
<script src="{{ asset('js/all.js') }}"></script>
<script>
    //JavaScript代码区域
    layui.use(['element', 'layer',], function () {
        var element = layui.element;
        var layer = layui.layer;

        layer.msg('Welcome');

        element.on('nav(leftbar)', function (elem) {
            console.log(elem.text());
            switch (elem.text()) {
                case '查询申请记录':
                    var url = '{{ route('myRequest') }}';
                    pageLoad(url);
                    break;
                case '我要请假':
                    var url = '{{ route('askForLeave') }}';
                    pageLoad(url);
                    break;
                case '我要加班':
                    var url = '{{ route('askForOvertime') }}';
                    pageLoad(url);
                    break;
                case '待处理':
                    var url = '{{ route('waitingApprove') }}';
                    pageLoad(url);
                    break;
                case '已处理':
                    break;
                default:
                    break;
            }
        })

    });


</script>


</body>
</html>
