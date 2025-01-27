<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service - Seller Panel</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #00796b;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 28px;
        }

        /* Main Section */
        main {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .success-message {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        input[type="number"] {
            width: auto;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            background-color: #00796b;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 12px;
            font-size: 18px;
        }

        button:hover {
            background-color: #004d40;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            main {
                padding: 15px;
                width: 90%;
            }

            button {
                font-size: 16px;
                padding: 10px;
            }
        }

    </style>
</head>
<body>
    <header>
        <h1>Add Service</h1>
    </header>

    <main>
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('store.service') }}" enctype="multipart/form-data">
            @csrf

            <label for="seller_name">Seller Name</label>
            <input type="text" id="seller_name" value="{{ $seller->name }}" readonly>

            <label for="service_name">Service Name</label>
            <input type="text" id="service_name" name="service_name" required>

            <label for="service_description">Service Description</label>
            <textarea id="service_description" name="service_description" rows="4" required></textarea>

            <label for="seller_city">City</label>
            <input type="text" id="seller_city" name="seller_city" required>

            <label for="seller_area">Area</label>
            <input type="text" id="seller_area" name="seller_area" required>

            <label for="availability">Availability</label>
            <input type="text" id="availability" name="availability" required>

            <label for="service_delivery_time">Service Delivery Time</label>
            <input type="text" id="service_delivery_time" name="service_delivery_time" required>

            <label for="seller_contact_no">Contact Number</label>
            <input type="text" id="seller_contact_no" name="seller_contact_no" required>

            <label for="service_price">Service Price</label>
            <input type="number" id="service_price" name="service_price" required>

            <label for="image">Upload Image</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit">Add Service</button>
        </form>
    </main>
</body>
</html>
