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
    <p>{{$ShipName}}</p>
    <p>{{$ShipAddress}}</p>
    <p>{{$ShipPhone}}</p>
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
</div>


</body>
</html>

