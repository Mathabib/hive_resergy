<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Comment Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f6fa; padding: 30px; margin: 0;">
    <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="640" style="background-color: #ffffff; padding: 24px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <tr>
                        <td style="font-family: Arial, sans-serif; color: #db4747; font-size: 24px; font-weight: bold; padding-bottom: 10px;">
                            📝 New Comment on a Task
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; color: #333333; padding-bottom: 15px;">
                            <strong>{{ $comment->user->name }}</strong> has commented on a task within your project.
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="6" cellspacing="0" width="100%" style="font-size: 15px; color: #444;">
                                <tr>
                                    <td width="120" style="color: #666;">📌 <strong>Project:</strong></td>
                                    <td>{{ $task->project->nama ?? 'Unnamed Project' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #666;">🧾 <strong>Task:</strong></td>
                                    <td>{{ $task->nama_task }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #666;">⏱️ <strong>Status:</strong></td>
                                    <td style="text-transform: capitalize;">{{ $task->status ?? 'Unknown' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #666;">🕒 <strong>Commented At:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($comment->created_at)->format('l, d M Y') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; background-color: #f9f9f9; border-left: 5px solid #db4747; border-radius: 6px; margin-top: 20px;">
                            <p style="margin: 0; font-style: italic; font-size: 16px; color: #444;">
                                “{{ $comment->content }}”
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px; color: #666666; padding-top: 20px;">
                            You are receiving this email because you have access to the project related to this task.
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top: 20px;">
                            <a href="{{ url('/tasks/'.$task->id) }}" style="background-color: #db4747; color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-weight: bold; display: inline-block;">
                                🔗 View Task Details
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #eee; margin-top: 40px; padding-top: 20px; font-size: 12px; color: #aaa; text-align: center;">
                            This is an automated message from your Task Management System.<br>
                            Please do not reply directly to this email.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
