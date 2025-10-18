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

    // Simple slider implementation for .np-slider
    function initSlider(root){
      var track = root.querySelector('.np-slider-track');
      var slides = Array.prototype.slice.call(root.querySelectorAll('.np-slide'));
      if(!track || slides.length === 0){ return; }
      var index = 0;
      var prevBtn = root.querySelector('.np-slider-prev');
      var nextBtn = root.querySelector('.np-slider-next');
      var dotsWrap = root.querySelector('.np-slider-dots');
      var intervalMs = parseInt(root.getAttribute('data-interval') || '5000', 10);
      var timer = null;

      function renderDots(){
        if(!dotsWrap){ return; }
        dotsWrap.innerHTML = '';
        slides.forEach(function(_, i){
          var d = document.createElement('button');
          d.type = 'button';
          d.className = 'np-dot';
          d.setAttribute('aria-label', 'Go to slide ' + (i+1));
          d.addEventListener('click', function(){ goTo(i); restart(); });
          dotsWrap.appendChild(d);
        });
      }

      function update(){
        var offset = -index * 100;
        track.style.transform = 'translateX(' + offset + '%)';
        if(dotsWrap){
          var dots = dotsWrap.querySelectorAll('.np-dot');
          Array.prototype.forEach.call(dots, function(dot, i){
            if(i === index){ dot.classList.add('active'); }
            else { dot.classList.remove('active'); }
          });
        }
      }

      function goTo(i){
        index = (i + slides.length) % slides.length;
        update();
      }

      function next(){ goTo(index + 1); }
      function prev(){ goTo(index - 1); }

      function start(){ if(timer){ clearInterval(timer); } timer = setInterval(next, intervalMs); }
      function stop(){ if(timer){ clearInterval(timer); timer = null; } }
      function restart(){ stop(); start(); }

      if(prevBtn){ prevBtn.addEventListener('click', function(){ prev(); restart(); }); }
      if(nextBtn){ nextBtn.addEventListener('click', function(){ next(); restart(); }); }

      root.addEventListener('mouseenter', stop);
      root.addEventListener('mouseleave', start);

      renderDots();
      update();
      if(slides.length > 1){ start(); }
    }

    document.querySelectorAll('.np-slider').forEach(initSlider);
  });
})();
