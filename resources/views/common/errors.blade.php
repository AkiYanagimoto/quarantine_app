@if (count($errors) > 0)
<!-- Form Error List -->
<div class="alert alert-danger">
    <div>
        <strong>⼊⼒した⽂字を修正してください。</strong>
    </div>
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif