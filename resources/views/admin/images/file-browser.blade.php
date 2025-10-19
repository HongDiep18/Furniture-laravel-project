<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Browser image</title>

    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js')}}"></script>

    <style>
        ul.file-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.file-list li {
            float: left;
            margin: 5px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        ul.file-list img {
            display: block;
            margin: 0 auto;
        }

        ul.file-list li:hover {
            background: rgba(236, 236, 236, 0.858);
        }
    </style>

    <script>
        $(document).ready(function () {
            var funcNum = <?php echo $_GET['CKEditorFuncNum'] . ';';  ?>

            $('#image-list').on('click', 'img', function () {
                var fileUrl = $(this).attr('title');
                window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
                window.close();
            }).hover(function () {
                $(this).css('cursor', 'pointer')
            });
        });
    </script>
</head>

<body>

    <div class="image-list" id="image-list">
        @foreach ($fileNames as $file)
            <div class="thumbnail">
                <ul class="file-list">
                    <li>
                        <img src="/storage/images/uploads/{{ $file }}" alt="thumb" width="120"
                        title="/storage/images/uploads/{{ $file }}">
                        <br>
                        <span>{{$file}}</span>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
</body>

</html>