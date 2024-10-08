<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
      	body a{
      		color:#333 !important;
      	}
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
      		padding-top:20px;
      		background-color: #F8F8F8;
      		margin-bottom: 10px;
      		border-radius: 10px;
        }
        .email-header img {
            max-width: 150px;
        }
        .email-content-outer{
            border: 1px solid #DCDCDC;
      		border-radius: 10px;
        }
        .email-content {
            text-align: center;
            padding: 20px 0;
        }
        .email-content h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .email-content p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .email-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #26A4FF;
            color: #fff !important;
            text-decoration: none;
            border-radius: 30px;
            font-size: 16px;
      		width: 50%;
      		margin: 20px auto;
        }
        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding-top: 20px;
      		padding-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="https://rulerise-job-portal-frontend.vercel.app/images/logo.png" alt="Talent Beyond Borders">
        </div>
        <div class="email-content-outer">
            <div class="email-content">
                <h1>{{ $greeting ?? 'Hello' }}</h1>
                @foreach ($headings ?? [] as $heading)
                    <h1>{{ $heading }}</h1>
                @endforeach
                @foreach ($messages ?? [] as $message)
                <p>
                    {{ $message }}
                </p>
                @endforeach
                <a href="{{ $actionUrl ?? '' }}" class="email-button">{{ $actionText ?? 'Click Here' }}</a>
                @foreach ($messagesAfterAction ?? [] as $text)
                <p>
                    {{ $text }}
                </p>
                @endforeach
            </div>
            <div class="email-footer">
                © {{ config('app.name') }} 2024
            </div>
        </div>
    </div>
</body>
</html>
