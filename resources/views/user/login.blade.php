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
<h2>登录</h2>
<form action="/user/logindo" method="post">
<table>
    <tr>
        <th>邮箱</th>
        <td><input type="text" name="email"></td>
    </tr>
    <tr>
        <th>密码</th>
        <td><input type="password" name="pwd"></td>
    </tr>
    <tr>
        <th></th>
        <td><input type="submit" value="登录"></td>
    </tr>
</table>
</form>
</body>
</html>