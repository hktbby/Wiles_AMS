<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Show SQL Query</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    .container {
        max-width: 800px;
        margin: auto;
        background: #f9f9f9;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        white-space: pre-wrap;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .sql-query {
        background-color: #f0f0f0;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Your Account Details</h2>
    <div class="sql-query">
        <pre>
CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_price` decimal(10,2) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `room_capacity` int(11) NOT NULL,
  `room_details` text DEFAULT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
        </pre>
    </div>
</div>

</body>
</html>
