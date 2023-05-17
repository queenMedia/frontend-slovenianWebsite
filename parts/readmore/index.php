<link rel="stylesheet" href="./parts/readmore/css/style.css" type="text/css">

<script>
  
  // read more controller
  const readMore = '<?php echo $read_more; ?>'
  const readMoreButtton = `<button class="read-more-button">Preberite celoten članek<br /><img src="./parts/readmore/images/arrow-down.png"></button>`;
  let readMoreButttonCover = document.createElement('div');
  readMoreButttonCover.innerHTML = readMoreButtton;

  let hideElements = [];

  let hideBrakePointDesktop = document.querySelectorAll('.hide-desktop-content-brake-point');
  let hideBrakePointMobile = document.querySelectorAll('.hide-mobile-content-brake-point');

  if(readMore === 'true') {
      if(window.innerWidth >= 992) {
          findElements('desktop'); 
          hideBrakePointDesktop[0].appendChild(readMoreButttonCover);

      } else {
          findElements('mobile'); 
          hideBrakePointMobile[0].appendChild(readMoreButttonCover);
      }

  }

  function findElements(device) {
      let breakPoint = document.querySelector(`.hide-${device}-content-brake-point`);
      let breakPointContainer = breakPoint.parentNode.children;

      let breakpointReached = false;
      for(let i = 0; i < breakPointContainer.length; i++) {

          if(breakPointContainer[i].className === `hide-${device}-content-brake-point`) {
              breakpointReached = true;
          } else if (breakpointReached) {
              hideElements.push(breakPointContainer[i]);
          }
      }

      for(let e = 0; e < hideElements.length; e++){
          hideElements[e].style.display = 'none';
      }

  };

  const readMoreBtn = document.querySelector('.read-more-button');
  if(readMoreBtn) {
      readMoreBtn.addEventListener('click', function() {
          this.style.display = 'none' ;
          for(let i = 0; i < hideElements.length; i++) {
              hideElements[i].style.display = 'block';
          }
      });
  }
</script>