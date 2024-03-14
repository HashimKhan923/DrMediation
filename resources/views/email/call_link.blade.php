<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slot Booking Confirmation</title>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" bgcolor="#f4f4f4">
                <table width="600" cellpadding="0" cellspacing="0">
                    <!-- Header Section -->
                    <tr>
                        <td align="center" bgcolor="#DBEEC5">
                            <img src="{{asset('drlogo.png')}}" alt="Dr. Meditation Logo" width="180" height="180" style="display: block; margin: 20px auto;">
                            <h1 style="color: #fff; font-size: 24px;">Slot Booking Confirmation</h1>
                        </td>
                    </tr>
                    <!-- Content Section -->
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px; font-size: 16px; line-height: 1.6;">
                            <p>Hello {{$name}},</p>
                            <p>click on the link below to start your call with advisor</p>
                            <a href="{{$link}}">{{$link}}</a>
 
                            <p>Best regards,</p>
                            <p>The Dr. Meditation Team</p>
                        </td>
                    </tr>
                    <!-- Footer Section -->
                    <tr>
                        <td bgcolor="#007bff" style="padding: 20px; text-align: center; font-size: 14px; color: #fff;">
                            &copy; 2023 Dr. Meditation. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
