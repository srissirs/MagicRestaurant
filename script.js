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

reviewsAndDishes()