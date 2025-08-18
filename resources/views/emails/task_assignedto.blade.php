<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Task Assigned</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f4f4f4">
    <tr>
      <td align="center" style="padding: 40px 0;">
        <table width="600" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-collapse:collapse;">
          <tr>
            <td style="padding: 30px;">

              <!-- Greeting -->
              <h2 style="font-size:24px; color:#b71c1c; margin:0 0 20px 0;">Hello 👋</h2>

              <!-- Intro -->
              <p style="font-size:16px; color:#555555; margin:0 0 20px 0;">You have been assigned a new task. Here are the details:</p>

              <!-- Task Info -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#fff3f3; border-left:4px solid #c62828; padding: 0;">
                <tr>
                  <td style="padding: 15px;">
                    <p style="font-size:16px; color:#b71c1c; margin:0 0 10px 0;"><strong>📌 Task Name:</strong> {{ $task->nama_task }}</p>

                    @if($task->description)
                    <p style="font-size:16px; color:#333; margin:10px 0 0 0;"><strong>📝 Description:</strong> {{ $task->description }}</p>
                    @endif

                    @if($task->end_date)
                    <p style="font-size:16px; color:#333; margin:10px 0 0 0;"><strong>📅 Deadline:</strong> {{ \Carbon\Carbon::parse($task->end_date)->format('F d, Y') }}</p>
                    @endif
                  </td>
                </tr>
              </table>

              <!-- Button -->
              <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin: 30px auto;">
                <tr>
                  <td align="center" bgcolor="#c62828" style="border-radius: 6px;">
                    <a href="{{ url('/tasks/' . $task->id) }}"
                       style="display: inline-block; padding: 12px 24px; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">
                       🔍 View Task
                    </a>
                  </td>
                </tr>
              </table>

              <!-- Footer -->
              <p style="font-size:16px; color:#555555; margin:30px 0 0 0;">Thank you for being part of our team 💼.</p>
              <p style="font-size:13px; color:#999999; text-align:center; margin-top:40px;">
                &copy; {{ date('Y') }} Hive Resindo. All rights reserved.<br>
              </p>

            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

</body>
</html>
