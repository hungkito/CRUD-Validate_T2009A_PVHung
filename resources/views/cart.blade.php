<table>
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
                <input type="number" name="quantity" class="w3-input w3-border w3-quarter" min="1" value="{{$cartItem->quantity}}">
            </td>
            <td>{{$cartItem->unitPrice * $cartItem->quantity}}</td>
            <td>
                <button>Update</button>
                <a href="/cart/remove?id={{$cartItem->id}}" onclick="return confirm('Bạn có chắc muốn xoá sản phẩm này khỏi giỏ hàng?')"></a>
            </td>
        </form>
    </tr>
@endforeach
</table>
<div style="margin-top: 20px">
    <strong>Total price {{$totalPrice}}</strong>
</div>
