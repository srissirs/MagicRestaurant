function reviewsAndDishes(){
    const restauranttoppage=document.querySelector("restauranttoppage")
    const restaurant=document.querySelector("restaurant")
    buttons=restauranttoppage.querySelectorAll("a")
    dbutton=buttons[0]
    rbutton=buttons[1]
    dbutton.classList.add("selected")
    var dishes=document.getElementById("dishes")
    var reviews=document.getElementById("reviews")
    reviews.remove()
    dbutton.addEventListener('click',function(e) {
      if(!dbutton.classList.contains("selected")){
        dbutton.classList.toggle("selected")
        rbutton.classList.toggle("selected")
        reviews.remove()
        restaurant.appendChild(dishes)
      }  
      
      })
    rbutton.addEventListener('click',function(e) {
      if(!rbutton.classList.contains("selected")){
        rbutton.classList.toggle("selected")
        dbutton.classList.toggle("selected")
        dishes.remove()
        restaurant.appendChild(reviews)
      }
        
      })
}


function addDishes(a,count){
  
  var dishes=document.getElementById("dishes")
  for (let i = 0; i < count; i++) {
    dishes.appendChild(a[i])
  }
}


function filter(){
  const allDishes=document.querySelectorAll("dish")
  m=NodeList
  count=0
  for (let i = 0; i < allDishes.length; i++) {
    m[i]=allDishes[i]
    count++
  }
  
  const restaurant=document.querySelector("restaurant")
  var dropdown=document.querySelector("select")
  dropdown.addEventListener('change',function(e) {
    var dishes=document.getElementById("dishes")
    if(dropdown.value!="Tudo"){
      dishes.remove
      addDishes(m,count)
      var dish=document.querySelectorAll("dish")
      dish.forEach( el => {
        c=el.querySelector("information")
        d=c.querySelector("category")
        e=d.querySelector("p")
        l=e.textContent
        if(l != " "+dropdown.value+" "){
          el.remove()
        }
      })

    }else{
      dishes.remove
      addDishes(m,count)
    }
      
    })
  

  ;
}

function drawStar(){
  var x=document.querySelector("h3")
  y=x.querySelectorAll("i")
  z=x.querySelector("p")
  console.log(z.textContent)
  z.textContent=Math.round(z.textContent)
  if(z.textContent>=1){
    y[0].classList.add("full")
  }
  if(z.textContent>=2){
    y[1].classList.add("full")
  }
  if(z.textContent>=3){
    y[2].classList.add("full")
  }
  if(z.textContent>=4){
    y[3].classList.add("full")
  }
  if(z.textContent==5){
    y[4].classList.add("full")
  }
}

drawStar()

reviewsAndDishes()

filter()