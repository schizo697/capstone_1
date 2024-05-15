let listCartHTML = document.querySelector('.listCart');
let listProductHTML = document.querySelector('.listProduct');
let iconCart = document.querySelector('.icon-cart');
let iconCartSpan = document.querySelector('.icon-cart span');
let body = document.querySelector('body');
let closeCart = document.querySelector('.close');
let products = [];
let cart = [];


iconCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
})
closeCart.addEventListener('click', () => {
    body.classList.toggle('showCart');
})

const addDataToHTML = () => {
    // remove datas default from HTML

    // add new datas
    if(products.length > 0) { // if has data
        products.forEach(product => {
            let newProduct = document.createElement('div');
            newProduct.dataset.listid = product.listid;
            newProduct.classList.add('item');
            newProduct.innerHTML = 
            `<div class="col-lg-30 col-md-30">
            <div class="product-item position-relative bg-white d-flex flex-column text-center">
                <img class="img-fluid mb-4" src="../img/products/${product.imgid}" alt="">
                <h6 class="mb-3">${product.pname}</h6>
                <h5 class="text-primary mb-0">&#8369; ${product.price}.00</h5>
                <h6 class="mb-3">Quantity: <?php echo $row['quantity'];?> available</h6>
                <div class="btn-action d-flex justify-content-center">
                    <button class = "addCart"><a class="addCart btn bg-primary py-2 px-3" href=""><i class="bi bi-cart text-white"></i></a></button>
                    <a class="btn bg-secondary py-2 px-3" href=""><i class="bi bi-eye text-white"></i></a>
                </div>
            </div>`;
            listProductHTML.appendChild(newProduct);
        });
    }
}
    listProductHTML.addEventListener('click', (event) => {
        let positionClick = event.target;
        if(positionClick.classList.contains('addCart')){
            let id_product = positionClick.parentElement.dataset.listid;
            addToCart(id_product);
        }
    })
    const addToCart = (product_id) => {
        let product = products.find(product => product.id === product_id);
        if (product) {
            let cartItem = cart.find(item => item.product_id === product_id);
            if (cartItem) {
                cartItem.quantity += 1;
            } else {
                cart.push({
                    product_id: product_id,
                    quantity: 1
                });
            }
            addCartToHTML();
            addCartToMemory();
        }
    }

const addCartToMemory = () => {
    localStorage.setItem('cart', JSON.stringify(cart));
}

const addCartToHTML = () => {
    listCartHTML.innerHTML = '';
    let totalQuantity = 0;
    if (cart.length > 0) {
        cart.forEach(item => {
            let product = products.find(product => product.id === item.product_id);
            if (product) {
                totalQuantity += item.quantity;
                let newItem = document.createElement('div');
                newItem.classList.add('item');
                newItem.dataset.listProductHTMLid = item.product_id;

                listCartHTML.appendChild(newItem);
                newItem.innerHTML = `
                    <div class="image">
                        <img src="../img/products/${product.imgid}">
                    </div>
                    <div class="name">
                        ${product.pname}
                    </div>
                    <div class="totalPrice">&#8369;${product.price * item.quantity}</div>
                    <div class="quantity">
                        <span class="minus"><</span>
                        <span>${item.quantity}</span>
                        <span class="plus">></span>
                    </div>
                `;
            }
        });
    }
    iconCartSpan.innerText = totalQuantity;
}

listCartHTML.addEventListener('click', (event) => {
    let positionClick = event.target;
    if(positionClick.classList.contains('minus') || positionClick.classList.contains('plus')){
        let product_id = positionClick.parentElement.parentElement.dataset.id;
        let type = 'minus';
        if(positionClick.classList.contains('plus')){
            type = 'plus';
        }
        changeQuantityCart(product_id, type);
    }
})
const changeQuantityCart = (product_id, type) => {
    let positionItemInCart = cart.findIndex((value) => value.product_id == product_id);
    if(positionItemInCart >= 0){
        let info = cart[positionItemInCart];
        switch (type) {
            case 'plus':
                cart[positionItemInCart].quantity = cart[positionItemInCart].quantity + 1;
                break;
        
            default:
                let changeQuantity = cart[positionItemInCart].quantity - 1;
                if (changeQuantity > 0) {
                    cart[positionItemInCart].quantity = changeQuantity;
                }else{
                    cart.splice(positionItemInCart, 1);
                }
                break;
        }
    }
    addCartToHTML();
    addCartToMemory();
}

const initApp = () => {
    // get data product
    fetch('product.json')
    .then(response => response.json())
    .then(data => {
        products = data;
        addDataToHTML();

        // get data cart from memory
        if(localStorage.getItem('cart')){
            cart = JSON.parse(localStorage.getItem('cart'));
            addCartToHTML();
        }
    })
}
initApp();