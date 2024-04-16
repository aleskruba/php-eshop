<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // Store the current URL in a session variable
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
} else {
    $current_user_email = $_SESSION["user_email"];
}
?>


<?php
    include 'head.php'; 
    include 'navbar.php';
    require_once 'includes/db.inc.php';
    require_once 'includes/order/order.inc.php'
    ?>

<div class="basket">
    <button class="gobackbutton" onclick="goBackFunction()">GO BACK</button>
<div class="emptybasket">    </div>

<div class="basket-container">
    <h2>Shopping Basket</h2>
    <table>
        <thead>
            <tr>
                <th>Model</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr class="tbodytr">
      
            </tr>
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="3">Total:</td>
                <td class="totalprice">  </td>
            </tr>
        </tfoot>
    </table>
    <button class="confirm-btn" onClick="submitFunction()">Confirm Order</button>
</div>
<script>

    const confirmbtn = document.querySelector('.confirm-btn')
    const basketcontainer = document.querySelector('.basket-container');
    const emptybasket = document.querySelector('.emptybasket');

    const cart = JSON.parse(localStorage.getItem('cart'));
    if (!cart.length) {basketcontainer.style.display = 'none';
                       emptybasket.innerHTML = 'Basket is empty'


                            }

    const tbody = document.querySelector('tbody');
    const totalprice = document.querySelector('.totalprice');


    let totalPrice = 0;

    if (cart && cart.length > 0) {
        cart.forEach(item => {
      
            const row = document.createElement('tr');
            row.classList.add('tbodytr');
     
            row.innerHTML = `
                <td class='tdmodel'>${item.model}</td>
                <td class='tdquantity'>${item.quantity}</td>
                <td class='tdprice'>${item.price}</td>
                <td class='tdtotalprice'>${item.quantity * item.price} Kč</td>
                <td ><div class='minusbuttonbasket' onclick='removeFromBasket(${item.productID })' >-</div></td>
                <td><div class='basketplusbutton' id=${item.productID} onclick='addToBasket(${item.productID})'>+</div></td>

            `;

            tbody.appendChild(row);
            totalPrice += item.quantity * item.price;

        });

           totalprice.textContent = `${totalPrice} Kč`;
    
    } else {
     
        console.log('Cart is empty');
     
    }

    const data = cart;

    const addToBasket = (id) => { 
    const index = cart.findIndex(item => item.productID === id);
    const getID = document.getElementById(id);


    if (index !== -1) {
      
        if (cart[index].quantity < cart[index].stock) {
            cart[index].quantity += 1;
        } else {
     
             alert('No more items.');
            return; 
        }
    } else {
        alert('Item not found in the cart.');
        return; 
    }

    localStorage.setItem('cart', JSON.stringify(cart));

    tbody.innerHTML = '';

    totalPrice = 0;

    cart.forEach(item => {

        const row = document.createElement('tr');
        row.classList.add('tbodytr');
        row.innerHTML = `
            <td class='tdmodel'>${item.model}</td>
            <td class='tdquantity'>${item.quantity}</td>
            <td class='tdprice'>${item.price}</td>
            <td class='tdtotalprice'>${item.quantity * item.price} Kč</td>
            <td ><div class='minusbuttonbasket'  onclick='removeFromBasket(${item.productID})'>-</div></td>
            <td ><div class='basketplusbutton' id=${item.productID} onclick='addToBasket(${item.productID})'>+</div></td>
        `;
        tbody.appendChild(row);
        totalPrice += item.quantity * item.price;

        const buybuttonID = document.getElementById(item.productID)
  

        if (buybuttonID && item.quantity >= item.stock  && (buybuttonID.id == item.productID)) { 
            
            buybuttonID.style.opacity = '0.5';
            buybuttonID.style.pointerEvents = 'none';  
        }
         
    });

    totalprice.textContent = `${totalPrice} Kč`;
    updateCartQuantity(); 
};


    const removeFromBasket = (id) => {

    const index = cart.findIndex(item => item.productID === id);

    if (index !== -1) {

        if (cart[index].quantity > 1) {
            cart[index].quantity -= 1;
            } else {
                cart.splice(index, 1);
        }

       
        localStorage.setItem('cart', JSON.stringify(cart));

        tbody.innerHTML = '';

         totalPrice = 0;

         cart.forEach(item => {
            
            const row = document.createElement('tr');
            row.classList.add('tbodytr');
            row.innerHTML = `
                <td class='tdmodel'>${item.model}</td>
                <td class='tdquantity'>${item.quantity}</td>
                <td class='tdprice'>${item.price}</td>
                <td class='tdtotalprice'>${item.quantity * item.price} Kč</td>
                <td ><div class='minusbuttonbasket' onclick='removeFromBasket(${item.productID})'>-</div></td>
                <td><div class='basketplusbutton' id=${item.productID} onclick='addToBasket(${item.productID})'>+</div></td>

            `;
            tbody.appendChild(row);

            totalPrice += item.quantity * item.price;
          

                const buybuttonID = document.getElementById(item.productID)
  

                if (buybuttonID && item.quantity >= item.stock  && (buybuttonID.id == item.productID)) { 
                    
                    buybuttonID.style.opacity = '0.5';
                    buybuttonID.style.pointerEvents = 'none';  
                }

        });

          totalprice.textContent = `${totalPrice} Kč`;
 
        updateCartQuantity(); 
    }
};


    const submitFunction = () => {
    console.log('data',data);

       fetch('./includes/order/order.inc.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ cart: data })
})
.then(response => {
    if (response.ok) {
        const success = document.querySelector('.success');
        success.style.height = '20px';
        success.style.width = '100%';
        success.style.backgroundColor = 'green';
        success.style.color = 'white';
        success.innerHTML = 'Order saved successfully'
        localStorage.removeItem('cart');

        confirmbtn.style.display = 'none';
        setTimeout(()=>{      confirmbtn.style.display = 'blick';     window.location.href = "/comments";},1000)
  
        return response.text();
    } else {
        const success = document.querySelector('.success');
        success.style.height = '20px';
        success.style.width = '100%';
        success.style.backgroundColor = 'red';
        success.style.color = 'white';
        success.innerHTML = 'Order was saved successfully'
        throw new Error('Network response was not ok');
    }
})
.catch(error => {
    console.error('Error:', error);
});


};

const goBackFunction = () => {
    window.history.back();
    }
</script>


</div>