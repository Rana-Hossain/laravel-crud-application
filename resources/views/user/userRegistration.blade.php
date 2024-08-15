<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .registration-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .registration-form h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .registration-form label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        .registration-form input[type="text"],
        .registration-form input[type="email"],
        .registration-form input[type="password"],
        .registration-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .registration-form button {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .registration-form button:hover {
            background-color: #2980b9;
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="registration-form">
    <h1>Register</h1>
    <form action="{{ route('user.userRegistration') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            @error('name')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            @error('email')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            @error('password')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>
