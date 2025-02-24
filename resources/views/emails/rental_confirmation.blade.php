<!DOCTYPE html>
<html>
<head>
    <title>Car Rental Confirmation</title>
</head>
<body>
    <h2>Dear {{ $rental->user->name }},</h2>
    <p>Your car rental has been confirmed!</p>
    
    <h3>Rental Details:</h3>
    <p><strong>Car:</strong> {{ $rental->car->name }}</p>
    <p><strong>Start Date:</strong> {{ $rental->start_date }}</p>
    <p><strong>End Date:</strong> {{ $rental->end_date }}</p>
    <p><strong>Total Cost:</strong> ${{ $rental->total_cost }}</p>

    <p>Thank you for renting with us!</p>
</body>
</html>
