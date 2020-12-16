<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/assets/compiled/css/app.css" rel="stylesheet">

    <title>Share</title>
</head>
<body>
<p>Instant copy & paste across your network.</p>
<p>DO NOT USE WITH SENSITIVE DATA OR ON PUBLIC NETWORKS</p>
<button type="button" class="btn btn-danger" id="chest-delete">Clear data</button>
<form action="/" class="dropzone" id="file">
    @csrf
</form>
<form>
    @csrf
    <input id="chest-ip" name="chest-ip" type="hidden" value="{{request()->ip()}}">
    <div class="form-group">
        <textarea class="form-control" id="chest-text" rows="100"
                  placeholder="Paste/write your text here">{{is_null($chest) ? '' : $chest['text']}}</textarea>
    </div>
    @foreach(is_null($chest) ? [] : $chest['files'] as $file)
        <input class="file-path" type="hidden" value="{{$file->getFilePath()}}">
    @endforeach
</form>
<script src="/assets/compiled/js/app.js"></script>
<script src="/assets/compiled/js/chest.js"></script>
</body>
</html>
