<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<script src="/js/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="/js/layui/css/layui.css">
<table class="layui-table">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>企业名称</th>
        <th>法人</th>
        <th>税务号</th>
        <th>appid</th>
        <th>key</th>
        <th>执照</th>

        <th>操作</th>

    </tr>
    </thead>
    <tbody>
    @foreach($data as $k=>$v)
        <tr uid="{{$v['id']}}">
            <td>{{$v['firm_name']}}</td>
            <td>{{$v['firm_man']}}</td>
            <td>{{$v['firm_num']}}</td>
            <td>{{$v['appid']}}</td>
            <td>{{$v['key']}}</td>
            <td>{{$v['firm_img']}}</td>

        @if($v['status']==1)
                <td>已通过</td>
            @else
            <td><button class="btn">点击通过</button></td>
                @endif
        </tr>
    @endforeach

    </tbody>
</table>
</body>
</html>
<script>
    $(function(){
        $('.btn').click(function(){
            var _this=$(this);
            var uid=_this.parents('tr').attr('uid');
            $.post(
                '/firm/verify',
                {uid:uid},
                function(res){
                    alert(res.msg);
                    history.go(0);
                },
                'json'
            )
        })
    })
</script>
