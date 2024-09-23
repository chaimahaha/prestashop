/**
* 2007-2024 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2024 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*
* Don't forget to prefix your containers with your own identifier
* to avoid any conflicts with others containers.
*/
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.category-slider');
    const sliderItems = document.querySelectorAll('.slider-item');
    
    let currentIndex = 0;
    const itemWidth = sliderItems[0].offsetWidth + 20; // Largeur de l'élément + marge
    
    // Fonction pour mettre à jour le déplacement du slider
    function updateSliderPosition() {
        slider.style.transform = `translateX(${-currentIndex * itemWidth}px)`;
    }

    // Défilement automatique toutes les 3 secondes
    setInterval(function() {
        if (currentIndex < sliderItems.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0; // Revenir au début du slider
        }
        updateSliderPosition();
    }, 3000); // Intervalle de 3 secondes pour chaque slide
});
