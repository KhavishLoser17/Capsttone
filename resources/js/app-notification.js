document.addEventListener('DOMContentLoaded', function () {

    //Notification Badge
  
    const badges = document.querySelectorAll('#notificationBadge');
    
    badges.forEach(badge => {
      const count = parseInt(badge.textContent.trim(), 10); 
  
      if (count <= 0) {
        badge.classList.add('hidden'); 
      } else {
        badge.classList.remove('hidden'); 
      }
    });
  
    
  });
  