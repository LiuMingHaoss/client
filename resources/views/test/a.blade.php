
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
<script src="http://api.1809a.com/a.js"></script>

<script>
    $.ajax({
          method: "get",
          url: "http://api.1809a.com/test/b",
            dataType:"jsonp",  //数据格式设置为jsonp
    }).done(function(msg) {
          console.log(msg);
    });

</script>
</body>
</html>