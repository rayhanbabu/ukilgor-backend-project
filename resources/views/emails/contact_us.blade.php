<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Message Details</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding: 20px;">

    <table width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: auto; background:#ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
        <tr>
            <td style="background:#004aad; padding: 20px; color:#ffffff; text-align:center;">
                <h2 style="margin: 0;">New Message Received</h2>
            </td>
        </tr>

        <tr>
            <td style="padding: 20px;">

                <p style="font-size: 16px; margin-bottom: 10px;">
                    <strong>Name:</strong> {{ $model->name }}
                </p>

                <p style="font-size: 16px; margin-bottom: 10px;">
                    <strong>Phone:</strong> {{ $model->phone }}
                </p>

                <p style="font-size: 16px; margin-bottom: 10px;">
                    <strong>Email:</strong> {{ $model->email }}
                </p>

                <p style="font-size: 16px; margin-bottom: 10px;">
                    <strong>Subject:</strong> {{ $model->subject }}
                </p>

                <p style="font-size: 16px; margin-bottom: 20px;">
                    <strong>Message:</strong><br>
                    {!! nl2br(e($model->message)) !!}
                </p>

                <p style="font-size: 14px; color:#555;">
                    Thanks,<br>
                    <strong>Ancova</strong>
                </p>

            </td>
        </tr>

    </table>

</body>
</html>
