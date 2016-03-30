<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>


</head>
<body>
    <h1>Profile Update</h1>

    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id]]) !!}
        <div>
            {!! Form::label('notify', 'Want email notification?') !!}
            {!! Form::checkbox('notify', null, null, ['id' => 'notify']) !!}
        </div>

        <div>
            {!! Form::submit('Update Profile') !!}
        </div>
    {!! Form::close() !!}
</body>
</html>