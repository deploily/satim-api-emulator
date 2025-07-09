<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Options</title>
    <style>
        body {
            min-height: 100vh;
            background-color: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 400px;
            width: 100%;
            padding: 24px;
            box-sizing: border-box;
        }
        h2 {
            margin-top: 24px;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }
        p {
            margin-top: 8px;
            font-size: 0.875rem;
            color: #6b7280;
        }
        form {
            margin-top: 32px;
        }
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .button {
            width: 100%;
            padding: 12px 16px;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .button.confirm {
            background-color: #22c55e;
        }
        a{
            text-decoration: none;
            color: white;
        }
        .button.confirm:hover {
            background-color: #16a34a;
        }
        .button.fail {
            background-color: #ef4444;
        }
        .button.fail:hover {
            background-color: #dc2626;
        }
        .button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.5);
        }
        .button.fail:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.5);
        }
        .icon {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center">
            <h2>Payment Options</h2>
            <p>Please select the desired payment action</p>
        </div>
    
            <div class="button-group">
                 <a href='{{ $data['returnUrl'] }}'> <button type="submit" 
                        name="testc" 
                        value="confirm" 
                        class="button confirm">
                  <span class="icon">✓</span>
                    Confirm Payment
                </button></a>
                
                <a href='{{$data['failUrl'] }}'> <button type="submit" 
                        name="testf" 
                        value="fail" 
                        class="button fail">
                    <span class="icon">✗</span>
                    Fail Payment
                </button></a>
            </div>
      
    </div>
</body>
</html>