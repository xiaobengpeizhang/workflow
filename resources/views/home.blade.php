@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">注册员工信息</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="form-horizontal" method="POST" action="{{ route('setUserInfo') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('realName') ? ' has-error' : '' }}">
                                <label for="realName" class="col-md-4 control-label">真实姓名：</label>

                                <div class="col-md-6">
                                    <input id="realName" type="text" class="form-control" name="realName" value="{{ old('realName') }}" required autofocus>

                                    @if ($errors->has('realName'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('realName') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                                <label for="sex" class="col-md-4 control-label">性别：</label>

                                <div class="col-md-6">
                                    <input value="男" type="radio"  name="sex" > 男
                                    <input value="女" type="radio"  name="sex" > 女

                                    @if ($errors->has('sex'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('sex') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('depart') ? ' has-error' : '' }}">
                                <label for="depart" class="col-md-4 control-label">所属部门：</label>

                                <div class="col-md-6">
                                    <select name="depart" id="depart" class="form-control">
                                        <option value="00">---</option>
                                    </select>

                                    @if ($errors->has('depart'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('depart') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                <label for="group" class="col-md-4 control-label">所属小组：</label>

                                <div class="col-md-6">
                                    <select name="group" id="group" class="form-control">
                                        <option value="00">---</option>
                                    </select>

                                    @if ($errors->has('group'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('group') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                                <label for="position" class="col-md-4 control-label">当前职位：</label>

                                <div class="col-md-6">
                                    <input id="position" type="text" class="form-control" name="position" value="{{ old('position') }}" >

                                    @if ($errors->has('position'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('position') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        确定
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            console.log('pageload');
            DepartInit();
            Disable($('#group'))
        });

        function DepartInit(){
            console.log('departInit');
            var url = '{{route('getDepartList')}}';
            $.get(url,function(data,status){
                if(status == 'success'){
                    console.log(data);
                    for (i in data){
                        $('#depart').append('<option value="'+ data[i].id +'">'+ data[i].departName +'</option>')
                    }
                }
            })
        }

        function Disable(elem){
            elem.attr('disabled','disabled');
        }

        function Enable(elem){
            elem.removeAttr('disabled');
        }

        $('select#depart').change(function(){
            var depart_id = $(this).val();
//            console.log(depart_id);
            if(depart_id != '00'){
                $('#group').empty();
                GroupInit(depart_id);
                Enable($('#group'));
            }else {
                $('#group').empty().append('<option value="00">---</option>');
                Disable($('#group'));
            }
        });

        function GroupInit(depart_id){
//            console.log(depart_id);
            var url = './api/getGroupList/'+depart_id;
            $.get(url,function(data,status){
//                console.log(status);
                if(status == 'success'){
                    console.log(data);
                    for (i in data){
                        $('#group').append('<option value="'+ data[i].id +'">'+ data[i].groupName +'</option>')
                    }
                }
            })
        }
    </script>
@endsection
