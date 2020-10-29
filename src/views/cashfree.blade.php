<html>

<head>
    <title>Processing Payment</title>
</head>

<body>
    <form method="post" name="redirect" action="{{ $endPoint }}">
        {{dd($params)}}
        @foreach($params as $param_key=>$param_value)
        <input type="hidden" name="{{ $param_key }}" value="{{ $param_value  }}" />
        @endforeach
        <input type="hidden" name="checksum" value="{{ $checksum }}" />
    </form>
    <script language='javascript'>
    document.redirect.submit();
    </script>
</body>

</html>