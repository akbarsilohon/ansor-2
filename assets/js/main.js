const ansorHeader = document.getElementById('anshor_header');
if( ansorHeader && ansorHeader.classList.contains('transparant') ){
    window.addEventListener('scroll', function(){
        if( window.scrollY >  50 ){
            ansorHeader.classList.remove('transparant');
        } else{
            ansorHeader.classList.add('transparant');
        }
    });
}

// Menu open ==============
document.addEventListener('DOMContentLoaded', function() {
    const menuOpenBtn = document.querySelector('.menu_open');
    const leftWrapper = document.querySelector('.left-wrapper');
    if (menuOpenBtn && leftWrapper) {
        menuOpenBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            leftWrapper.classList.toggle('active');
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-xmark');
            }
        });
    }

    const menuItemsWithChildren = document.querySelectorAll('.left-wrapper > ul > li.menu-item-has-children > a');
    menuItemsWithChildren.forEach(item => {
        item.addEventListener('click', function(e) {
            if (window.innerWidth <= 780) {
                e.preventDefault();
                const subMenu = this.nextElementSibling;
                const arrow = this.querySelector('.menu-arrow');
                
                if (subMenu && subMenu.classList.contains('sub-menu')) {
                    document.querySelectorAll('.sub-menu').forEach(sub => {
                        if (sub !== subMenu) {
                            sub.classList.remove('open');
                            if (sub.previousElementSibling.querySelector('.menu-arrow')) {
                                sub.previousElementSibling.querySelector('.menu-arrow').style.transform = 'rotate(0deg)';
                            }
                        }
                    });

                    subMenu.classList.toggle('open');
                    if (arrow) {
                        if (subMenu.classList.contains('open')) {
                            arrow.style.transform = 'rotate(180deg)';
                        } else {
                            arrow.style.transform = 'rotate(0deg)';
                        }
                    }
                }
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (leftWrapper && leftWrapper.classList.contains('active') && !leftWrapper.contains(e.target) && !menuOpenBtn.contains(e.target)) {
            leftWrapper.classList.remove('active');
            const icon = menuOpenBtn.querySelector('i');
            if (icon) {
                icon.classList.add('fa-bars');
                icon.classList.remove('fa-xmark');
            }
        }
    });
});