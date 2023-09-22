console.log('TIMELINE');

$(".showGallery").on("click", showGallery);
$("#filterButton").on("click", ajaxFilter);

$("img[alt=portraet-carlos]").css('border-radius', '200px');

$(".filter-option.search").on("click", function(){
  $(".filter-option.year").val('Alle');
});

// Set the Height of the After Element on the Bootstrap Timeline
if ($("div").hasClass("timeline")) {

  $( "div.timeline" ).each(function() {
    var widthFirst = $(this).children().first().height();
    var topH = widthFirst / 2;
    var widthLast = $( "div .timeline-item:last-child" ).height();
    var lastH = widthLast / 2;
    $('head').append('<style>div.timeline:before{top: '+topH+'px; bottom: '+lastH+'px;}</style>')

  });
}


function showGallery(){
    var uid = $(this).attr("name");
    var isVideo = $(this).children().is("video");
    if (isVideo || $(this).is("video")) {

      return;
    }
    //console.log(controllerpath);
    var controllerpath = $("#uri_hidden"+uid).val();
  jQuery.ajax({
      type: 'POST',
      url: controllerpath,
      data: {
        uid: uid,
      },
      success: function(data) {
          $('#modal').html(data);
          console.log('SUCESS');
          $("#modal").css("display", "block");
          $(".modal-close").on("click", closeModal);
          showSlides(2);
          console.log(controllerpath);
          console.log(data);
      },
      error: function() {

          console.log('ERROR');
      }
  });

}

function ajaxFilter(){
  var controllerpath = $("#filter_hidden").val();
  getCheckedboxes();
  console.log(filterdata);
  console.log(controllerpath);
  jQuery.ajax({
      type: 'POST',
      url: controllerpath,
      data: {
        data: filterdata,
      },
      success: function(data) {
          $('#timeline').html(data);
          $(".showGallery").on("click", showGallery);
          $(".modal-close").on("click", closeModal);
          getCheckedboxes();
          console.log('SUCESS');
          console.log(data);
          //$("#filterButton").on("click", ajaxFilter);
          showSlides(slideIndex);
          //$( "mySlides" ).css('display: block');
      },
      error: function() {

          console.log('ERROR');
      }
  });

}

function getCheckedboxes(){
  filterdata = [];
  i = 0;

  $('.filter-option').each(function () {
    i++;

    var tag = $(this);
    if (this.checked) {
         filterdata[i] = tag.val();
    }else{
      if (tag.is("select")) {
        //console.log(tag.children("option:selected").text());
        filterdata[i] = tag.children("option:selected").text();
      }
      if (tag.attr("type") == 'checkbox') {
        filterdata[i] ='unchecked';
      }
      if (tag.attr("type") == 'text') {
        filterdata[i] = tag.val();
      }
    }
  });


}

// SLIDES

var slideIndex = 1;
if ($( "div" ).hasClass( "mySlides" )) {
  showSlides(slideIndex);
  $( "mySlides" ).css('display: block');
}

function closeModal(){
  slideIndex = 1;
    $("#modal").css("display", "none");
}

// Next/previous controls
function plusSlides(n) {

  showSlides(slideIndex += n);
}

function setCount(c){
  var count = c;
  function getCount(){
    return count;
  }

}
// Thumbnail image controls
function currentSlide(n) {

  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  //console.log(slides);
  //console.log(n);
  //console.log('Index: '+slideIndex);
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
      //console.log(slides[i]);
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  //console.log(slides);
  //console.log(slides[slideIndex-1]);
  if (typeof slides[slideIndex-1] != 'undefined') {
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
  }


}
