<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>SiteStar inquiry</title>
</head>
<body style="margin:0;padding:24px;background:#f3f0e8;color:#161a22;font-family:Georgia,serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;margin:0 auto;background:#ffffff;border:1px solid #d8d1c3;border-radius:16px;">
        <tr>
            <td style="padding:28px;">
                <p style="margin:0 0 8px;font-family:Arial,sans-serif;font-size:12px;letter-spacing:0.16em;text-transform:uppercase;color:#145550;">SiteStar</p>
                <h1 style="margin:0 0 20px;font-size:22px;font-weight:normal;">New inquiry</h1>
                <p style="margin:0 0 8px;font-family:Arial,sans-serif;font-size:14px;"><strong>Name</strong><br>{{ $senderName }}</p>
                <p style="margin:0 0 8px;font-family:Arial,sans-serif;font-size:14px;"><strong>Email</strong><br>{{ $senderEmail }}</p>
                <p style="margin:0 0 8px;font-family:Arial,sans-serif;font-size:14px;"><strong>Phone</strong><br>{{ $phone ?: 'Not provided' }}</p>
                <p style="margin:0 0 8px;font-family:Arial,sans-serif;font-size:14px;"><strong>Subject</strong><br>{{ $topic }}</p>
                <p style="margin:16px 0 0;font-family:Arial,sans-serif;font-size:14px;white-space:pre-wrap;">{{ $inquiry }}</p>
            </td>
        </tr>
    </table>
</body>
</html>
