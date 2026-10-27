/**
 * Cypher-One site script: menu, contact form, risk timeline tabs,
 * guided idea scorer and the cost-of-waiting calculator.
 * Strings and number formatting come from window.C1 (wp_localize_script).
 */
(function(){
  var C1 = window.C1 || {};
  var I = C1.i18n || {};
  var LOCALE = C1.locale || 'en-US';
  function t(k, fb){ return I[k] || fb; }
  function fmtStr(s){ var a=[].slice.call(arguments,1); return String(s).replace(/%(\d+)\$[sd]|%[sd]/g,function(m,n){ return n ? a[n-1] : a.shift(); }); }
  function escHTML(s){ return String(s).replace(/[&<>"']/g,function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]; }); }

  document.querySelectorAll('[data-year]').forEach(function(e){ e.textContent = new Date().getFullYear(); });

  /* mobile menu */
  var mt=document.querySelector('.menu-toggle'), nv=document.getElementById('site-nav');
  if(mt&&nv){
    var setM=function(o){ mt.setAttribute('aria-expanded',o); nv.classList.toggle('is-open',o); };
    mt.addEventListener('click',function(){ setM(mt.getAttribute('aria-expanded')!=='true'); });
    nv.addEventListener('click',function(e){ if(e.target.tagName==='A') setM(false); });
    document.addEventListener('keydown',function(e){ if(e.key==='Escape'&&mt.getAttribute('aria-expanded')==='true'){ setM(false); mt.focus(); } });
  }

  /* contact form: reveal the "something else" box */
  var cf=document.querySelector('.contact-form');
  if(cf){
    var syncOther=function(){ cf.querySelectorAll('.cf-opts label').forEach(function(l){ var r=l.querySelector('input[type=radio]'); var on=r&&r.checked; l.classList.toggle('is-on',!!on&&!!l.querySelector('.cf-other')); }); };
    cf.addEventListener('change',syncOther); syncOther();
    cf.addEventListener('focusin',function(e){ if(e.target.classList.contains('cf-other')){ var r=e.target.closest('label').querySelector('input[type=radio]'); if(r&&!r.checked){ r.checked=true; syncOther(); } } });
  }

  /* risk timeline tabs */
  var tabs=[].slice.call(document.querySelectorAll('.rt-tab')), panels=[].slice.call(document.querySelectorAll('.rt-panel'));
  function show(i,focus){
    tabs.forEach(function(x,k){ x.setAttribute('aria-selected',k===i); x.tabIndex=k===i?0:-1; x.classList.toggle('is-past',k<i); });
    panels.forEach(function(p,k){ p.hidden=k!==i; });
    if(focus) tabs[i].focus();
  }
  if(tabs.length){
    tabs.forEach(function(x,i){
      x.addEventListener('click',function(){ show(i); });
      x.addEventListener('keydown',function(e){ var n=null, rtl=document.documentElement.dir==='rtl';
        var nextKey=rtl?'ArrowLeft':'ArrowRight', prevKey=rtl?'ArrowRight':'ArrowLeft';
        if(e.key===nextKey) n=(i+1)%tabs.length; if(e.key===prevKey) n=(i-1+tabs.length)%tabs.length;
        if(e.key==='Home') n=0; if(e.key==='End') n=tabs.length-1;
        if(n!==null){ e.preventDefault(); show(n,true); } });
    });
    show(0);
  }

  /* guided idea scorer — weights and notes come from data attributes set in the dashboard */
  var form=document.getElementById('gaForm');
  function list(items, empty){ return items.length ? items.map(function(x){ return '<li>'+escHTML(x)+'</li>'; }).join('') : '<li>'+escHTML(empty)+'</li>'; }
  function score(){
    var base=+(form.getAttribute('data-base')||50), lo=+(form.getAttribute('data-min')||8), hi=+(form.getAttribute('data-max')||95);
    var s=base, back=[], fav=[], answered=0, sets=form.querySelectorAll('fieldset'), total=sets.length;
    sets.forEach(function(fs){
      var on=fs.querySelector('.opt[aria-pressed="true"]'); if(!on) return;
      answered++; s+= +(on.getAttribute('data-w')||0);
      var b=on.getAttribute('data-back'), f=on.getAttribute('data-for');
      if(b) back.push(b); if(f) fav.push(f);
    });
    var hint=document.getElementById('gaHint'), pct=document.getElementById('gaPct'), meter=document.getElementById('gaMeter');
    if(answered<total){
      pct.textContent=fmtStr(t('pct','%s%'),0); meter.style.width='0%';
      if(!hint.hasAttribute('data-initial')) hint.setAttribute('data-initial', hint.textContent.trim());
      hint.textContent = answered===0 ? hint.getAttribute('data-initial') : fmtStr(t('progress','%1$d of %2$d answered.'), answered, total);
      document.getElementById('gaBack').innerHTML=list(back,'—');
      document.getElementById('gaFor').innerHTML=list(fav,'—');
      return;
    }
    hint.textContent='';
    s=Math.max(lo,Math.min(hi,s));
    pct.textContent=fmtStr(t('pct','%s%'),s); meter.style.width=s+'%';
    document.getElementById('gaBack').innerHTML=list(back,t('noBack','Nothing major from these answers.'));
    document.getElementById('gaFor').innerHTML=list(fav,t('noFor','Nothing yet from these answers.'));
  }
  if(form){
    form.addEventListener('click',function(e){
      var b=e.target.closest('.opt'); if(!b) return;
      b.closest('.opts').querySelectorAll('.opt').forEach(function(o){ o.setAttribute('aria-pressed','false'); });
      b.setAttribute('aria-pressed','true'); score();
    });
    score();
  }

  /* cost-of-waiting calculator */
  var f=document.getElementById('calc'), grid=document.getElementById('fte-grid');
  function $(id){ return document.getElementById(id); }
  function fmt(n){ try{ return n.toLocaleString(LOCALE); }catch(e){ return n.toLocaleString('en-US'); } }
  function set(k,v){ document.querySelectorAll('[data-r="'+k+'"]').forEach(function(e){ e.textContent=v; }); }
  if(f){
    var CUR=f.getAttribute('data-currency')||'QAR', RECLAIM=+(f.getAttribute('data-reclaim')||0.8),
        MH=+(f.getAttribute('data-month-hours')||160), WEEKS=+(f.getAttribute('data-weeks')||4);
    var money=function(n){ return fmtStr(t('money','%1$s %2$s'),CUR,fmt(n)); };
    var update=function(){
      var tm=+$('team').value, h=+$('hours').value, r=+$('rate').value;
      $('team-out').value=fmt(tm); $('hours-out').value=fmt(h); $('rate-out').value=money(r);
      $('rate').setAttribute('aria-valuetext',fmtStr(t('rateValue','%1$s %2$s per month'),fmt(r),CUR));
      var hm=tm*h*WEEKS, lost=Math.round(hm*r/MH), save=Math.round(lost*RECLAIM), fte=hm*RECLAIM/MH;
      set('hours',fmt(hm)); set('lost',money(lost)); set('save',money(save)); set('year',money(save*12)); set('left',money(lost-save));
      set('fte',fte.toLocaleString(LOCALE,{minimumFractionDigits:1,maximumFractionDigits:1}));
      if(grid){
        var shown=Math.min(fte,150), whole=Math.floor(shown), part=shown-whole, html='';
        for(var i=0;i<whole;i++) html+='<li></li>';
        if(part>0.05) html+='<li class="part" style="--p:'+Math.round(part*100)+'%"></li>';
        grid.innerHTML=html;
      }
    };
    f.addEventListener('input',update); update();
  }
})();
