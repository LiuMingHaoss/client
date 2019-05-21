<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册</title>
</head>
<body>
<form action="/firm/regdo" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>企业名称：</td>
            <td><input type="text" name="firm_name"><br></td>
        </tr>
        <tr>
            <td>企业法人：</td>
            <td><input type="text" name="firm_man"><br></td>
        </tr>
        <tr>
            <td>税务号：</td>
            <td><input type="text" name="firm_num"><br></td>
        </tr>
        <tr>
            <td>营业执照：</td>
            <td><input type="file" name="firm_img"><br></td>
        </tr>
        <tr>
            <td><input type="submit" value="注册"></td>
        </tr>
    </table>



</form>
</body>
</html>