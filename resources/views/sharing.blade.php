<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/assets/compiled/css/app.css" rel="stylesheet">

    <title>Share</title>
</head>
<body>
<p>Paste your text here</p>
<form>
    @csrf
    <input id="chest-id" name="chest-id" type="hidden" value="{{$chest['id'] }}">
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Example textarea</label>
        <textarea class="form-control" id="chest-text" rows="100">{{$chest['text']}}</textarea>
    </div>
</form>
<script src="/assets/compiled/js/app.js"></script>
<script src="/assets/compiled/js/chest.js"></script>
</body>
</html>
