

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        #divContact a{
            padding-left: 200px;
            text-decoration: none;
            font-size: 20px;
        }
        #divContact a:hover{
            color: red;
        }
        h1{
            text-align: center;
            margin: 0px;
            padding: 0px;
        }
        .form-container{
            text-align: center;
        }
        .form-container h4{
            margin: 0px;
            padding: 0px;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container input, 
        .form-container select, 
        .form-container textarea {
            width: 500px;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container select{
            width: 520px;
        }
        .form-container .name-fields {
            display: flex;
            justify-content: space-between;
            width: 520px;
            margin-left: 40px;
        }
        .form-container .name-fields input {
            width: 48%; /* Chia đều ô First Name và Last Name */
        }
        .form-container label {
            display: block;
            margin: 10px 0 5px;
        }
        .form-container .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .form-container .checkbox-container input {
            width: auto;
            margin-right: 10px;
        }
        @media (max-width: 600px) {
            .form-container input, 
            .form-container select, 
            .form-container textarea {
                width: 100%;
            }
            .form-container .name-fields {
                flex-direction: column;
            }
            .form-container .name-fields input {
                width: 100%;
            }
        }
        #SubmitContact{
            background-color: red;
            width: 200px;
            height: 30px;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>
    <div id="divContact"><a href="http://localhost/project_aptech/PHP_Project/index.php?pages=home">Home</a>/Contact us</div>
    <h1>Clarins answers your questions on all subjects!</h1>
    <div class="form-container">
        <form action="#" method="POST">
            <h4>Can't find the answer to your question? </h4>
            <h4>Our Clarins Customer Service is at your disposal:</h4>
            <div>Please complete the form below and we will aim to respond within 48 business hours.</div>
            <div class="name-fields">
                <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
                <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
            </div>

            <input type="email" id="email" name="email" placeholder="Email" required>

            <input type="tel" id="phone" name="phone" placeholder="Phone" required>

            <input type="text" id="orderNumber" name="orderNumber" placeholder="Order Number">

            <select id="question" name="question">
                <option value="" disabled selected>Select Question</option>
                <option value="product">Product Inquiry</option>
                <option value="order">Order Status</option>
                <option value="shipping">Shipping Information</option>
                <option value="other">Other</option>
            </select>

            <textarea id="comment" name="comment" placeholder="Enter Comment" rows="4"></textarea>

            <div class="checkbox-container">
                <input type="checkbox" id="contactByPhone" name="contactByPhone">
                <label for="contactByPhone">Please contact me by phone</label>
            </div>

            <button type="submit" id="SubmitContact">Submit</button>
        </form>
    </div>

    <script>
    function validateForm() {
        const email = document.getElementById('email').value;
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address.');
            return false;
        }

        return true;
    }
</script>
</body>
</html>
