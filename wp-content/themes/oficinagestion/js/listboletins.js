/*Filtra por mes y año el acordion*/
function filter_acordeon() {

  let year = jQuery('#year').val();
  let month = jQuery('#month').val();
  let search = `${month} ${year}`;
  jQuery('.elementor-element .elementor-accordion .elementor-accordion-item').each(function(index, value) {
    /*console.log('-->',jQuery(value).children()[0].innerText == search);*/
    if( jQuery(value).children()[0].innerText.includes(search)){
      jQuery(value).css('display','block');
    }else{
      jQuery(value).css('display','none');
    }
  });
};

/*Filtra por facultad*/
function filter_acordeon_facultad() {

  let facultad = jQuery('#facultad').val();  
  let month = jQuery('#month').val();
  let search = `${facultad} ${month}`;  
  jQuery('.elementor-element .elementor-accordion .elementor-accordion-item').each(function(index, value) {
    /*console.log('-->',jQuery(value).children()[0].innerText == search);*/
    if( jQuery(value).children()[0].innerText.includes(search) ){
      jQuery(value).css('display','block');
    }else{
      jQuery(value).css('display','none');
    }
  });
};
/*Filtra por edificio*/

function filter_by_build() {
  let year = jQuery('#year').val();  
  let search = `${year}`;
  
  jQuery('.elementor-element-102c497.elementor-element .elementor-accordion .elementor-accordion-item').each(function(index, value) {
    console.log(jQuery(value).children()[0].innerText.includes(search));
    
    if( (jQuery(value).children()[0].innerText.includes(search)) ){
      jQuery(value).css('display','block');
    }else{
      jQuery(value).css('display','none');
    }
  });
};
/*Filtra por edificio*/

function filter_by_build_two() {
  let year = jQuery('#yeartwo').val();  
  let search = `${year}`;
  
  jQuery('.elementor-element-2fc96f2.elementor-element .elementor-accordion .elementor-accordion-item').each(function(index, value) {
    console.log(jQuery(value).children()[0].innerText.includes(search));
    
    if( (jQuery(value).children()[0].innerText.includes(search)) ){
      jQuery(value).css('display','block');
    }else{
      jQuery(value).css('display','none');
    }
  });
};
/*Filtra por emergencia*/

function filter_emergency() {
  let year = jQuery('#year').val();  
  let search = `${year}`;
  
  jQuery('.elementor-element-fc80038.elementor-element .elementor-accordion .elementor-accordion-item').each(function(index, value) {
    console.log(jQuery(value).children()[0].innerText.includes(search));
    
    if( (jQuery(value).children()[0].innerText.includes(search)) ){
      jQuery(value).css('display','block');
    }else{
      jQuery(value).css('display','none');
    }
  });
};


/*Filtra por año*/
function filter_by_year() {
  let year = jQuery('#year').val();  
  let search = `${year}`;
  
  jQuery('.elementor-element .elementor-accordion .elementor-accordion-item').each(function(index, value) {
    console.log(jQuery(value).children()[0].innerText.includes(search));
    
    if( (jQuery(value).children()[0].innerText.includes(search)) ){
      jQuery(value).css('display','block');
    }else{
      jQuery(value).css('display','none');
    }
  });
};

/*Filtrar por año pasando el id(string) del acordeon objetivo como variable */
function filter_by_year_id(accordionId) {
  let year = jQuery('#year').val();  
  let search = `${year}`;
  
  jQuery('.elementor-element#'+accordionId+' .elementor-accordion .elementor-accordion-item').each(function(index, value) {
    console.log(jQuery(value).children()[0].innerText.includes(search));
    
    if( (jQuery(value).children()[0].innerText.includes(search)) ){
      jQuery(value).css('display','block');
    }else{
      jQuery(value).css('display','none');
    }
  });
};

/*Filtra los boletines*/
function filter_boletin() {  
  
  var input, filter, ul, li, a, i, txtValue;
  month = document.getElementById('month');
  year = document.getElementById('year');
  strmy = year.value+month.value;  
  filter = strmy.toLowerCase();
  console.log(filter);
  ul = document.getElementById("list-boletines");
  li = ul.getElementsByTagName('li');

  // Loop through all list items, and hide those who don't match the search query
  for (i = 0; i < li.length; i++) {
    a = li[i].getAttribute('dataid');        
    if (a.toLowerCase().indexOf(filter) > -1) {
      li[i].style.display = "block";
    } else {
      li[i].style.display = "none";
    }
  }

};