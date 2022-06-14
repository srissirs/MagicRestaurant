


const searchDishMain = document.querySelector('#searchDish')

if (searchDishMain) {
  searchDishMain.addEventListener('input', async function () {
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);
    const id = urlParams.get('id')

    const response = await fetch('../api/api_dishes.php?search=' + this.value + '&id=' + id)
    const dishes = await response.json()

    const section = document.querySelector('#dishes')
    section.innerHTML = ''

    for (const dish of dishes) {

      const dishCard = document.createElement('div')

      const dishInfo = document.createElement('div')
      dishInfo.className = 'information'

      dishCard.className = 'dish'
      const img = document.createElement('img')
      img.src = "../images/restaurant.jpg"
      const dishTitle = document.createElement('div')
      dishTitle.className = 'name'
      const starIconDish = document.createElement('button')
      starIconDish.className = 'fa-regular fa-star'

      const name = document.createElement('p')
      name.id = 'name'
      name.textContent = dish.dishName
      dishTitle.appendChild(name)
      dishTitle.appendChild(starIconDish)


      const category = document.createElement('p')
      category.id = 'category'
      category.textContent = dish.dishCategory

      const price = document.createElement('div')
      price.className = 'price'

      const dishPrice = document.createElement('p')
      dishPrice.id = 'price'
      dishPrice.textContent = dish.dishPrice
      price.appendChild(dishPrice)


      const addToCart = '<button class="fa-solid fa-cart-shopping button" onclick="addToCart()"></button>';
      price.insertAdjacentHTML('beforeend', addToCart);


      dishInfo.append(dishTitle)
      dishInfo.append(category)
      dishInfo.append(price)


      dishCard.appendChild(img)
      dishCard.appendChild(dishInfo)
      section.appendChild(dishCard)
    }
  })
}





const searchRestaurantMain = document.querySelector('#searchRestaurant')

if (searchRestaurantMain) {
  searchRestaurantMain.addEventListener('input', async function () {

    const response = await fetch('../api/api_restaurants.php?search=' + this.value)

    const restaurants = await response.json()

    const section = document.querySelector('#restaurants')
    section.innerHTML = ''

    for (const restaurant of restaurants) {

      const restaurantCard = document.createElement('section')
      restaurantCard.className = 'restaurantCard'
      const img = document.createElement('img')
      img.src = "../images/restaurant.jpg"
      //img.src = 'https://picsum.photos/200?' + restaurant.restaurantId
      const mainRestaurantsInfo = document.createElement('div')
      mainRestaurantsInfo.className = 'mainRestaurantsInfo'

      const mainRestaurantsName = document.createElement('div')
      mainRestaurantsName.className = 'mainRestaurantsName'
      const link = document.createElement('a')
      link.href = 'restaurant.php?id=' + restaurant.restaurantId
      link.textContent = restaurant.restaurantName
      const heartIcon = document.createElement('i')
      heartIcon.className = 'fa-regular fa-heart'
      mainRestaurantsName.appendChild(link)
      mainRestaurantsName.appendChild(heartIcon)

      const mainRestaurantsRating = document.createElement('div')
      mainRestaurantsRating.className = 'mainRestaurantsRating'
      const starIcon = document.createElement('i')
      starIcon.className = 'fa-regular fa-star'
      const rating = document.createElement('p')
      rating.textContent = restaurant.rating
      mainRestaurantsRating.appendChild(starIcon)
      mainRestaurantsRating.appendChild(rating)

      mainRestaurantsInfo.appendChild(mainRestaurantsName)
      mainRestaurantsInfo.appendChild(mainRestaurantsRating)

      restaurantCard.appendChild(img)
      restaurantCard.appendChild(mainRestaurantsInfo)
      section.appendChild(restaurantCard)
    }
  })
}

starReview()
restaurantsAndDishes()
drawStar()
filter()
restaurantButtons()
showTotalPrice()


function starReview() {
  reviews = document.querySelectorAll("div.reviewBox")

  reviews.forEach(el => {
    info = el.querySelector("div.info")

    var x = info.querySelector("h3")

    yy = x.querySelectorAll("i")

    zz = x.querySelector("p")
    zz.textContent = Math.round(zz.textContent)
    if (zz.textContent >= 1) {
      yy[0].className= "fa fa-star checked full"
    }
    if (zz.textContent >= 2) {
      yy[1].className= "fa fa-star checked full"
    }
    if (zz.textContent >= 3) {
      yy[2].className= "fa fa-star checked full"
    }
    if (zz.textContent >= 4) {
      yy[3].className= "fa fa-star checked full"
    }
    if (zz.textContent == 5) {
      yy[4].className= "fa fa-star checked full"
    }
  })
}

function restaurantsAndDishes() {
  const favoritedTopPage = document.querySelector(".favoritedTopPage")
  if (favoritedTopPage == null) {
    return
  }
  const favorited = document.querySelector(".favorited")
  buttons = favoritedTopPage.querySelectorAll("a")
  dbutton = buttons[0]
  rbutton = buttons[1]
  dbutton.classList.add("selected")
  var dishes = document.getElementById("dishes")
  var restaurants = document.getElementById("restaurants")
  restaurants.remove()
  dbutton.addEventListener('click', function (e) {
    if (!dbutton.classList.contains("selected")) {
      dbutton.classList.toggle("selected")
      rbutton.classList.toggle("selected")
      restaurants.remove()
      favorited.appendChild(dishes)
    }

  })
  rbutton.addEventListener('click', function (e) {
    if (!rbutton.classList.contains("selected")) {
      rbutton.classList.toggle("selected")
      dbutton.classList.toggle("selected")
      dishes.remove()
      favorited.appendChild(restaurants)
    }

  })
}


function restaurantButtons() {

  const restauranttoppage = document.querySelector(".buttons")
  if (restauranttoppage == null) {
    return
  }
  var dishes = document.getElementById("dishes")
  var reviews = document.getElementById("reviews")

  const restaurant = document.querySelector(".restaurant")
  buttons = restauranttoppage.querySelectorAll("a")
  dbutton = buttons[0]
  rbutton = buttons[1]

  var orders = document.getElementById("orders")
  newDishButton = buttons[2]
  obutton = buttons[3]
  orders.remove()

  dbutton.classList.add("selected")
  reviews.remove()

  dbutton.addEventListener('click', function (e) {
    if (!dbutton.classList.contains("selected")) {
      dbutton.classList.add("selected")
      rbutton.classList.remove("selected")
      orders.remove()
      reviews.remove()
      restaurant.appendChild(dishes)
    }
  })

  rbutton.addEventListener('click', function (e) {
    if (!rbutton.classList.contains("selected")) {
      rbutton.classList.add("selected")
      dbutton.classList.remove("selected")
      orders.remove()
      dishes.remove()
      restaurant.appendChild(reviews)
    }
  })

  obutton.addEventListener('click', function (e) {
    if (!obutton.classList.contains("selected")) {
      obutton.classList.add("selected")
      dbutton.classList.remove("selected")
      rbutton.classList.remove("selected")
      dishes.remove()
      reviews.remove()
      restaurant.appendChild(orders)
    }
  })

  newDishButton.addEventListener('click', function (e) {
    if (!newDishButton.classList.contains("selected")) {
      dbutton.classList.add("selected")
      rbutton.classList.remove("selected")
      obutton.classList.remove("selected")
      orders.remove()
      reviews.remove()
      restaurant.appendChild(dishes)
    }
    addADish()
  })
}

function openNav() {
  document.getElementById("mySidebar").style.width = "300px";
  document.getElementById("main").style.marginRight = "-250px";
}

/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginRight = "0";
}

function removeDish() {
  let dish = event.target.parentElement;
  dish.remove();
  showTotals();
}


function addToCart(id, price) {
  let name = event.target.parentElement.parentElement.children[0].children[0].textContent

  if (document.getElementById('mySidebar').textContent.includes(name)) {
    return;
  }
  const cartItem = document.createElement('div')
  cartItem.className = "cartDiv"
  cartItem.id = id
  const nameNode = document.createElement("p")
  const Name = document.createTextNode(name)
  nameNode.appendChild(Name)
  const priceNode = document.createElement("p")
  const Price = document.createTextNode(price)
  priceNode.appendChild(Price)

  const quantityNode = document.createElement("p")
  const Quantity = document.createTextNode("1")
  quantityNode.appendChild(Quantity)
  const closeBtn = '<a href="javascript:void(0)" class="removeDish" onclick="removeDish()">&times;</a>'
  const inc = '<button onclick="increment()">+</button>'
  const dec = '<button onclick="decrement()">-</button>'
  cartItem.insertAdjacentHTML('afterbegin', closeBtn)
  cartItem.appendChild(nameNode)
  cartItem.appendChild(priceNode)
  const div = document.createElement("div")
  div.className = "quantity"
  div.insertAdjacentHTML('afterbegin', dec)
  div.appendChild(quantityNode)
  quantityNode.insertAdjacentHTML('afterend', inc)
  cartItem.appendChild(div)
  const cart = document.getElementById('mySidebar')
  const total = document.getElementById('totalSum')
  cart.insertBefore(cartItem, total)
  showTotals()
}

function increment() {
  let quantity = event.target.parentElement.children[1].textContent;
  quantity++;
  if (quantity > 20) return;
  else {
    event.target.parentElement.children[1].textContent = quantity
    showTotals();
  };
}
function decrement() {
  let quantity = event.target.parentElement.children[1].textContent;
  quantity--;
  if (quantity == 0) {
    let dish = event.target.parentElement.parentElement;
    dish.remove();
  }
  else event.target.parentElement.children[1].textContent = quantity;
  showTotals();
}
function showTotals() {
  let total = 0;
  let quantity, price;
  const divs = document.querySelectorAll(".cartDiv");
  for (d of divs) {
    quantity = parseInt(d.children[3].children[1].textContent);
    price = parseFloat(d.children[2].textContent);
    total += quantity * price;
  }
  const cart = document.getElementById('totalSum');
  cart.textContent = "Total: " + total;
}

function addDishes(a, count) {

  var dishes = document.getElementById("dishes")

  for (let i = 0; i < count; i++) {
    dishes.appendChild(a[i])
  }
}

function filter() {
  const allDishes = document.querySelectorAll("div.dish")
  m = NodeList
  count = 0


  for (let i = 0; i < allDishes.length; i++) {

    m[i] = allDishes[i]

    count++
  }
  const restaurant = document.querySelector("restaurant")
  var dropdown = document.querySelector("select")
  if (dropdown == null) return
  dropdown.addEventListener('change', function (e) {
    var dishes = document.querySelectorAll("div.dish")
    if (dropdown.value != "Tudo") {
      dishes.forEach(di => {
        di.remove()
      })
      addDishes(m, count)
      var dish = document.querySelectorAll("div.dish")
      dish.forEach(el => {
        inf = el.querySelector("div.information")
        category = inf.querySelector("category")

        catText = category.querySelector("p").textContent

        if (catText != " " + dropdown.value + " ") {
          el.remove()
        }
      })
    } else {
      dishes.forEach(di => {
        di.remove()
      })
      addDishes(m, count)
    }
  })
}

function drawStar() {

  var x = document.querySelector("h3")
  var header = document.querySelector(".pastOrders")
  if (header != null) return
  console.log(header)
  if (x == null) return
  y = x.querySelectorAll("i")
  z = x.querySelector("p")

  z.textContent = Math.round(z.textContent)
  if (zz.textContent >= 1) {
    y[0].className= "fa fa-star checked full"
  }
  if (zz.textContent >= 2) {
    y[1].className= "fa fa-star checked full"
  }
  if (zz.textContent >= 3) {
    y[2].className= "fa fa-star checked full"
  }
  if (zz.textContent >= 4) {
    y[3].className= "fa fa-star checked full"
  }
  if (zz.textContent == 5) {
    y[4].className= "fa fa-star checked full"
  }
}

function favorite() {
  const allNames = document.querySelectorAll("div.name")
  listStars = NodeList
  conta = 0
  allNames.forEach(di => {
    star = di.querySelector("i")
    listStars[conta] = star
    conta++
  })
  for (let ss = 0; ss < conta; ss++) {
    estrela = listStars[ss]
    estrela.addEventListener('click', function () {
      newname = listStars[ss].querySelector("div.name")
      novastar = newname.querySelector("i")
      novastar.classList.toggle("full")
    })
  }
}


function toggle() {
  var d = document.querySelectorAll(".unedited");
  for (x of d) {
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
  var f = document.querySelectorAll(".editing");
  for (y of f) {
    if (y.style.display === "none") {
      y.style.display = "block";
    } else {
      y.style.display = "none";
    }
  }
  var r = document.querySelector(".customerInfoBtn");
  if (r.style.display === "none") {
    r.style.display = "block";
  } else {
    r.style.display = "none";
  }
}

function toggleEditRestaurant() {
  var editFieldName = event.target.parentElement.children[0].children[1].children[0];
  var uneditedName = event.target.parentElement.children[0].children[1].children[1];
  var editFieldAddress = event.target.parentElement.children[0].children[2].children[0];
  var uneditedAddress = event.target.parentElement.children[0].children[2].children[1];
  var saveBtn = event.target.parentElement.children[0].children[3];
  if (editFieldName.style.display === "none") {
    editFieldName.style.display = "block";
  }
  else {
    editFieldName.style.display = "none";
  }

  if (uneditedName.style.display === "none") {
    uneditedName.style.display = "block";
  }
  else {
    uneditedName.style.display = "none";
  }
  if (editFieldAddress.style.display === "none") {
    editFieldAddress.style.display = "block";
  }
  else {
    editFieldAddress.style.display = "none";
  }
  if (uneditedAddress.style.display === "none") {
    uneditedAddress.style.display = "block";
  }
  else {
    uneditedAddress.style.display = "none";
  }
  if (saveBtn.style.display === "none") {
    saveBtn.style.display = "block";
  }
  else {
    saveBtn.style.display = "none";
  }
}

function openForm() {
  var reviewBox = event.target.parentElement.parentElement.parentElement.children[1];
  if (reviewBox.style.display === "none") {
    reviewBox.style.display = "block";
  }
  else {
    reviewBox.style.display = "none";
  }
}

function addRestaurant() {
  var addRestaurant = document.getElementById("addRestaurant");
  if (addRestaurant.style.display === "none") {
    addRestaurant.style.display = "block";
  }
  else {
    addRestaurant.style.display = "none";
  }
}

function addADish() {
  var newDish = document.getElementById("newDish");
  if (newDish.style.display === "none") {
    newDish.style.display = "block";
  }
  else {
    newDish.style.display = "none";
  }
}

function addOrderDish() {
  var cartDishes = document.querySelectorAll(".cartDiv")
  let cartId
  const queryString = window.location.search;

  const urlParams = new URLSearchParams(queryString);
  const id = urlParams.get('id')
  fetch('../api/api_order.php?id=' + id)
    .then((response) => {
      return response.json();
    }).then((data) => {
      cartId = data
      for (const cartDish of cartDishes) {
        quant = cartDish.querySelector(".quantity").children[1].textContent
        fetch('../api/api_cart.php', {
          method: 'POST',
          body: JSON.stringify({
            dishId: cartDish.id,
            quantity: quant,
            cartId: cartId
          }), headers: {
            "Content-type": "application/json; charset=UTF-8"
          }
        })
          .then(response => response.json())
          .then(json => console.log(json));
      }
    })
}

function alterState() {
  orderId = document.querySelector("#orderId").value
  state = document.querySelector("#orderState").value
  fetch('../api/api_state.php', {
    method: 'POST',
    body: JSON.stringify({
      state: state,
      orderId: orderId,
    }), headers: {
      "Content-type": "application/json; charset=UTF-8"
    }
  })
    .then(response => response.json())
    .then(json => console.log(json));
}

function showTotalPrice() {
  header = document.querySelectorAll("div.information")
  header.forEach(box => {
    totalPrice = 0
    dishes = box.querySelectorAll("div.pastDish")
    dishes.forEach(dish => {
      quantity = dish.querySelector("#quantity").textContent
      price = dish.querySelector("#price").textContent
      totalPrice = totalPrice + quantity * price
    })
    inse = box.querySelector("#total")
    inse.textContent += totalPrice + "$"
  })
}

function toggleFavorite(id, dish) {
  console.log(id)
  favorite = event.target
  let unfavorite
  if (favorite.className === "fa fa-star checked full") {
    unfavorite = 1
    favorite.className = "fa-regular fa-star"
  } else {
    unfavorite = 0
    favorite.className = "fa fa-star checked full"
  }
  fetch('../api/api_favorites.php', {
    method: 'POST',
    body: JSON.stringify({
      id: id,
      unfavorite: unfavorite,
      dish: dish
    }), headers: {
      "Content-type": "application/json; charset=UTF-8"
    }
  })
    .then(response => response.json())
    .then(json => console.log(json));

}
