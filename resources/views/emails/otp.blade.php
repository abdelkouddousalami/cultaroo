<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Culturoo Verification Code</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #D2691E, #8B4513);
            color: white;
            border-radius: 10px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .otp-code {
            background: #fff;
            border: 2px solid #D2691E;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #D2691E;
            letter-spacing: 8px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
        }
        
        .footer {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 30px;
        }
        
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Culturoo</div>
        <p>Welcome to Authentic Moroccan Experiences</p>
    </div>
    
    <div class="content">
        <h2>Email Verification Required</h2>
        <p>Thank you for joining Culturoo! To complete your registration and start discovering authentic Moroccan experiences, please verify your email address.</p>
        
        <p>Enter this verification code in the app:</p>
        
        <div class="otp-code">{{ $otpCode }}</div>
        
        <div class="warning">
            <strong>Important:</strong> This code will expire in 10 minutes. Do not share this code with anyone.
        </div>
        
        <p>If you didn't create an account with Culturoo, please ignore this email.</p>
    </div>
    
    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
        <p>© {{ date('Y') }} Culturoo. All rights reserved.</p>
    </div>
</body>
</html>
