<!DOCTYPE html>
<html>
<head>
    <title>Registration Successful</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2>Welcome to University X!</h2>
        
        <p>Dear {{ $studentName }},</p>
        
        <p>Your registration has been successfully submitted. Here are your registration details:</p>
        
        <ul>
            <li>Student ID: {{ $studentId }}</li>
            <li>Faculty: {{ $faculty }}</li>
            <li>Major: {{ $majorStudy }}</li>
        </ul>

        <h3>You can login with credential below :</h3>

        <ul>
            <li>Email: {{ $email }}</li>
            <li>Password: {{ $password }}</li>
        </ul>
        
        <p>We will review your application and notify you of any updates.</p>
        
        <p>Best regards,<br>University X Admissions Team</p>
    </div>
</body>
</html>