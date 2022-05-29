
const searchRestaurant = document.querySelector('#searchRestaurant')
if (searchRestaurant) {
  searchRestaurant.addEventListener('input', async function() {

    const response = await fetch('api_restaurants.php?search=' + this.value)
    const restaurants = await response.json()

    const section = document.querySelector('#restaurants')
    section.innerHTML = ''

    for (const restaurant of restaurants) {
      
      const restaurantCard = document.createElement('section')
      restaurantCard.className ='restaurantCard'
      const img = document.createElement('img')
      img.src = "../images/restaurant.jpg"
      //img.src = 'https://picsum.photos/200?' + restaurant.restaurantId
      const  mainRestaurantsInfo = document.createElement('div')
      mainRestaurantsInfo.className = 'mainRestaurantsInfo'

      const  mainRestaurantsName = document.createElement('div')
      mainRestaurantsName.className = 'mainRestaurantsName'
      const link = document.createElement('a')
      link.href = 'restaurant.php?id=' + restaurant.restaurantId 
      link.textContent = restaurant.restaurantName
      const heartIcon = document.createElement('i')
      heartIcon.className = 'fa-regular fa-heart'
      mainRestaurantsName.appendChild(link)
      mainRestaurantsName.appendChild(heartIcon)

      const  mainRestaurantsRating = document.createElement('div')
      mainRestaurantsRating.className = 'mainRestaurantsRating'
      const starIcon = document.createElement('i')
      starIcon.className = 'fa-regular fa-star'
      const  rating = document.createElement('p')
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


function reviewsAndDishes() {
  const restauranttoppage = document.querySelector(".restaurantTopPage")
  const restaurant = document.querySelector(".restaurant")
  buttons = restauranttoppage.querySelectorAll("a")
  dbutton = buttons[0]
  rbutton = buttons[1]
  dbutton.classList.add("selected")
  var dishes = document.getElementById("dishes")
  var reviews = document.getElementById("reviews")
  reviews.remove()
  dbutton.addEventListener('click', function (e) {
    if (!dbutton.classList.contains("selected")) {
      dbutton.classList.toggle("selected")
      rbutton.classList.toggle("selected")
      reviews.remove()
      restaurant.appendChild(dishes)
    }

  })
  rbutton.addEventListener('click', function (e) {
    if (!rbutton.classList.contains("selected")) {
      rbutton.classList.toggle("selected")
      dbutton.classList.toggle("selected")
      dishes.remove()
      restaurant.appendChild(reviews)
    }

  })
}

reviewsAndDishes()

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

function addToCart() {
  let name = event.target.parentElement.parentElement.children[0].children[0].textContent;
  let price = event.target.parentElement.children[0].textContent;

  if (document.getElementById('mySidebar').textContent.includes(name)) {
    return;
  }
  const cartItem = document.createElement('div');
  cartItem.className ="cartDiv";
  const nameNode = document.createElement("p");
  const Name = document.createTextNode(name);
  nameNode.appendChild(Name);
  const priceNode = document.createElement("p");
  const Price = document.createTextNode(price);
  priceNode.appendChild(Price);

  const quantityNode = document.createElement("p");
  const Quantity = document.createTextNode("1");
  quantityNode.appendChild(Quantity);
  const closeBtn = '<a href="javascript:void(0)" class="removeDish" onclick="removeDish()">&times;</a>';
  const inc = '<button onclick="increment()">+</button>';
  const dec = '<button onclick="decrement()">-</button>';
  cartItem.insertAdjacentHTML('afterbegin', closeBtn);
  cartItem.appendChild(nameNode);
  cartItem.appendChild(priceNode);
  const div = document.createElement("div");
  div.className = "quantity";
  div.insertAdjacentHTML('afterbegin', dec);
  div.appendChild(quantityNode);
  quantityNode.insertAdjacentHTML('afterend', inc);
  cartItem.appendChild(div);
  const cart = document.getElementById('mySidebar');
  const total = document.getElementById('totalSum');
  cart.insertBefore(cartItem, total);
  showTotals();
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
  //parseFloat(total,2);
  const cart = document.getElementById('totalSum');
  cart.textContent = "Total: " + total;
}
