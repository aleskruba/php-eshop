const burgerdiv = document.getElementById("burger-div");
    
let toggle = false

burgerdiv.addEventListener("click", function() {
    
    if (!toggle) {

       // Check if the screen width is less than or equal to 768px
    if (window.innerWidth <= 768) {
        const nav = document.getElementById("nav");
         nav.style.flexDirection = "column";
         nav.style.alignItems = 'start';
         nav.style.justifyContent = 'start';
        const navright = document.getElementById("nav-right");
        navright.style.display = "block";
        navright.style.gap = 20;
        toggle = true
    }
   
} else {
        if (window.innerWidth <= 768) {
 
        const nav = document.getElementById("nav");
         nav.style.flexDirection = "column";
        const navright = document.getElementById("nav-right");
        navright.style.display = "none";
        toggle = false
    } 
    }

});

window.addEventListener('resize', function() {
    if (window.innerWidth < 768) {
                const nav = document.getElementById("nav");
         nav.style.flexDirection = "column";
        const navright = document.getElementById("nav-right");
        navright.style.display = "none";
        toggle = false
    }
});
window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        const nav = document.getElementById("nav");
        nav.style.flexDirection = "row";
        nav.style.alignItems = 'center';
        nav.style.justifyContent = 'space-between';
        const navright = document.getElementById("nav-right");
        navright.style.display = "flex";
    }
});

document.addEventListener('click', function(event) {
    const nav = document.getElementById("nav");
    if (!nav.contains(event.target) && window.innerWidth < 768 ) {
        const navright = document.getElementById("nav-right");
        navright.style.display = "none";
    }
});


///////////////////////////////////////////////////////////////////////

const urlParams = new URLSearchParams(window.location.search);
const productURLId = urlParams.get('id');
const cartarray = JSON.parse(localStorage.getItem('cart')) || [];
const itemquantity = document.getElementById('itemquantity')
const buybutton = document.querySelector('.buy-button')




function getCart() {
    return JSON.parse(localStorage.getItem('cart')) || [];
}

function updateCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function addToCartMain(productID,stock,price,model,description,img) {
    let cart = getCart();



    let existingProduct = cart.find(item => item.productID === productID);



    if (existingProduct) {
              
        const buybuttonID = document.getElementById(existingProduct.productID)
        if (existingProduct && existingProduct.productID == buybuttonID.id && existingProduct.quantity >=  parseInt(stock)-1) { 
            buybuttonID.style.opacity = '0.5';
            buybuttonID.style.pointerEvents = 'none';  
        }
      
        if (existingProduct && existingProduct.quantity <  parseInt(stock)) {
        existingProduct.quantity++;
        }
        if (itemquantity) {
        itemquantity.textContent = existingProduct.quantity
        }
    } else {
        cart.push({ productID: productID, quantity: 1 ,stock:stock, price: price, model:model,description: description,img:img});
    }

    updateCart(cart);
    updateCartQuantity();
    

}


function addToCart(productID,stock,price,model,description,img) {
    var cart = getCart();

    var existingProduct = cart.find(item => item.productID === productID);
   
    if (existingProduct && existingProduct.quantity >= parseInt(stock)-1) { 
        plusButton.style.opacity = '0.5';
        plusButton.style.pointerEvents = 'none';  
    }

    if (existingProduct) {
        existingProduct.quantity++;
         
        minusButton.style.opacity = '';
        minusButton.style.pointerEvents = '';  
        if (itemquantity) {
        itemquantity.textContent = existingProduct.quantity
        }
    } else {
        cart.push({ productID: productID, quantity: 1, stock: stock, price: price, model:model,description: description,img:img});

        itemquantity.textContent = 1
    }

    updateCart(cart);
    updateCartQuantity();
    

}


const removeFromCart = (productID) =>{

    
    let minusButton = document.querySelector('.minus-button');
    let plusButton = document.querySelector('.plus-button');

    var cart = getCart();

    var existingProduct = cart.find(item => item.productID === productID);
    var existingProductIndex = cart.findIndex(item => item.productID === productID);

  
    if (existingProduct && existingProduct.quantity > 0) {
        existingProduct.quantity--;
        console.log(cart)
        minusButton.style.opacity = '';
        minusButton.style.pointerEvents = '';  
        plusButton.style.opacity = '';
        plusButton.style.pointerEvents = '';  
        if (itemquantity) {
        itemquantity.textContent = existingProduct.quantity
        }
  
    if (existingProduct && existingProduct.quantity < 1) {
        var existingProduct = cart[existingProductIndex];
        minusButton.style.opacity = '0.5';
        minusButton.style.pointerEvents = 'none';  
        cart.splice(existingProductIndex, 1);
 
     }

  
    } 


    updateCart(cart);
    updateCartQuantity();
    

}

// Function to update the displayed cart quantity
function updateCartQuantity() {
    var cart = getCart();
    var totalQuantity = cart.reduce((total, item) => total + item.quantity, 0);
    document.getElementById('cartQuantity').textContent = totalQuantity;
    

    const basketcontainer = document.querySelector('.basket-container');
    const emptybasket = document.querySelector('.emptybasket');

    if (totalQuantity==0 && basketcontainer && emptybasket) {
        basketcontainer.style.display = 'none';
        emptybasket.innerHTML = 'Basket is empty'}

}


updateCartQuantity(); 





cartarray.forEach( item=> {
  //  console.log(item)
    const buybuttonID = document.getElementById(item.productID)
  

    if( item.productID === parseInt(productURLId)  ) {
           itemquantity.textContent = item.quantity
    } 
    if (buybuttonID && item.quantity >= item.stock  && (buybuttonID.id == item.productID)) { 
        
        buybuttonID.style.opacity = '0.5';
        buybuttonID.style.pointerEvents = 'none';  
    }
})




