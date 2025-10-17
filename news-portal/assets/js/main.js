(function(){
  function ready(fn){ if(document.readyState !== 'loading'){ fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }

  ready(function(){
    var toggle = document.getElementById('navToggle');
    var nav = document.getElementById('siteNav');
    if(toggle && nav){
      toggle.addEventListener('click', function(){
        var isOpen = nav.classList.toggle('open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });
    }

    // Submenu toggles (for items with children)
    var submenuButtons = document.querySelectorAll('.primary-navigation .submenu-toggle');
    submenuButtons.forEach(function(btn){
      btn.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var li = btn.closest('li');
        var expanded = btn.getAttribute('aria-expanded') === 'true';
        // Close siblings at same level
        if(li && li.parentElement){
          Array.prototype.forEach.call(li.parentElement.children, function(sibling){
            if(sibling !== li){
              sibling.classList.remove('submenu-open');
              var b = sibling.querySelector(':scope > .submenu-toggle');
              if(b){ b.setAttribute('aria-expanded', 'false'); }
            }
          });
        }
        btn.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        if(li){ li.classList.toggle('submenu-open', !expanded); }
      });
    });

    // Click outside to close submenus
    document.addEventListener('click', function(e){
      var navEl = document.getElementById('siteNav');
      if(!navEl){ return; }
      if(!navEl.contains(e.target)){
        var openItems = navEl.querySelectorAll('li.submenu-open');
        openItems.forEach(function(li){
          li.classList.remove('submenu-open');
          var b = li.querySelector(':scope > .submenu-toggle');
          if(b){ b.setAttribute('aria-expanded', 'false'); }
        });
      }
    });

    // Close submenus with Escape
    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape'){
        var navEl = document.getElementById('siteNav');
        if(!navEl){ return; }
        var openItems = navEl.querySelectorAll('li.submenu-open');
        openItems.forEach(function(li){
          li.classList.remove('submenu-open');
          var b = li.querySelector(':scope > .submenu-toggle');
          if(b){ b.setAttribute('aria-expanded', 'false'); }
        });
      }
    });
  });
})();
