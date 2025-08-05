<!DOCTYPE html>
<html>
<body>
    <p>Dear {{ $name }},</p>

    <p>You have been invited to join our new server:</p>
    <p>🌐 <strong>Server URL:</strong> <a href="https://www.hive.isolutions.co.id">www.hive.isolutions.co.id</a></p>

    <p>Please find your login credentials below:</p>
    <p>
        <strong>Username:</strong> {{ $email }}<br>
        <strong>Password:</strong> {{ $plainPassword }}
    </p>

    <p>🔑 Please log in and change your password after your first login for security purposes.</p>
    <p>If you experience any issues accessing the server, feel free to contact our support team at <a href="mailto:it@isolutions.co.id">it@isolutions.co.id</a>.</p>

    <p>Welcome aboard!</p>

    <p>Best regards,<br>
    ISolutions Indonesia Team</p>
</body>
</html>
