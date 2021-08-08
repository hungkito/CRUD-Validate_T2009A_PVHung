<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<div class="w3-container">
    <h2>Shopping cart</h2>
    <p>Update your cart information</p>
    <table class="w3-table w3-table-all">
        <tr>
            <th>Product Id</th>
            <th>Product name</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
        <?php
        $totalPrice = 0;
        ?>
        @foreach ($shoppingCart as $cartItem)
            <?php
            if (isset($cartItem)){
                $totalPrice += $cartItem->unitPrice * $cartItem->quantity;
            }
            ?>
            <tr>
                <form action="/cart/update" method="post">
                    @csrf
                    <td>{{$cartItem->id}}</td>
                    <td>{{$cartItem->name}}</td>
                    <td>{{$cartItem->unitPrice}}</td>
                    <td>
                        <input type="hidden" name="id" value="{{$cartItem->id}}">
{{--                        <input type="text" name="name" value="{{$cartItem->name}}">--}}
                        <input type="number" name="quantity" class="w3-input w3-border w3-quarter" min="1" value="{{$cartItem->quantity}}">
                    </td>
                    <td>{{$cartItem->unitPrice * $cartItem->quantity}}</td>
                    <td>
                        <button class="w3-button w3-indigo">Update</button>
                        <a class="w3-button w3-red" href="/cart/remove?id={{$cartItem->id}}" onclick="return confirm('Bạn có chắc muốn xoá sản phẩm này khỏi giỏ hàng?')">Delete</a>
                    </td>
                </form>
            </tr>
        @endforeach
    </table>
        <div class="w3-row w3-margin-top">
            <div class="w3-col-4">
                <strong>Total price {{$totalPrice}}</strong>
            </div>
        </div>
            <div class="w3-row w3-margin-top">
                <div class="w3-threequarter">&nbsp;</div>
                <div class="w3-quarter">
                    <form class="w3-container" method="post" action="/orders">
                        @csrf
                        <p>
                            <label>Ship Name</label>
                            <input class="w3-input" type="text" name="ShipName">
                        </p>
                        <p>
                            <label>Ship Address</label>
                            <input class="w3-input" type="text" name="ShipAddress">
                        </p>
                        <p>
                            <label>Ship Phone</label>
                            <input class="w3-input" type="text" name="ShipPhone">
                        </p>
                        <div>
                            <button class="w3-button w3-indigo" type="submit">Submit order</button>
                            <a class="w3-button w3-green" href="/admin/products">Continue Shopping</a>
                            <div id="paypal-button"></div>
                        </div>
                    </form>
                </div>
            </div>
</div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    paypal.Button.render({
        // Configure environment
        env: 'sandbox',
        client: {
            sandbox: 'AVI73_CsgkHEhuI-BoHnyGKNWbxpFDTJ1W891IN90NNGPtZNrClXnPoC2wtHKtZA4NH_CY0hYT9K-S8Q',
            production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
            size: 'small',
            color: 'gold',
            shape: 'pill',
        },

        // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: '50',
                        currency: 'USD'
                    }
                }]
            });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                // Show a confirmation message to the buyer
                window.alert('Thank you for your purchase!');
            });
        }
    }, '#paypal-button');

</script>

</body>
</html>

