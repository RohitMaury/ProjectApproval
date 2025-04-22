<!DOCTYPE html>
<html>
<head>
    <title>Project Status Update</title>
</head>
<body>
    <h2>Hello {{ $project->user->name }},</h2>

    <p>Your project <strong>{{ $project->title }}</strong> has been <strong>{{ $status }}</strong>.</p>

    <p>Time: {{ now() }}</p>

    <p>Regards,<br>Project Approval System</p>
</body>
</html>
