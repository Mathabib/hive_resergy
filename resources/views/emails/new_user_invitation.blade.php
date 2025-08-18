<!DOCTYPE html>
<html>
<body>
    <p>Dear {{ $name }},</p>

    <p>You have been invited to join our new server:</p>
    <p>🌐 <strong>Server URL:</strong> <a href="https://www.hiive.resergy.com">www.hive.resergy.com</a></p>

    <p>Please find your login credentials below:</p>
    <p>
        <strong>Username:</strong> {{ $email }}<br>
        <strong>Password:</strong> {{ $plainPassword }}
    </p>

    <p>🔑 Please log in and change your password after your first login for security purposes.</p>
    <p>If you experience any issues accessing the server, feel free to contact our support team at <a href="mailto:it.helpdesk@resindori.com">it.helpdesk@resindori.com</a>.</p>

    <p>Welcome aboard!</p>

    <p>Best regards,<br>
    Resindo Indonesia Team</p>
</body>
</html>
