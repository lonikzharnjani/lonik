(function(){
  function ready(fn){ if(document.readyState !== 'loading'){ fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }

  ready(function(){
    var toggle = document.getElementById('navToggle');
    var nav = document.getElementById('siteNav');
    if(toggle && nav){
      toggle.addEventListener('click', function(){
        if(nav.classList.contains('open')){ nav.classList.remove('open'); }
        else { nav.classList.add('open'); }
      });
    }
  });
})();
