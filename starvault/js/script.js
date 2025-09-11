var sideBarOpen = true;

toggleButton.addEventListener( 'click', (event) =>{
    event.preventDefault();
    if(sideBarOpen){
        dashboard_sidebar.style.width = '10%';
        dashboard_sidebar.style.transition = '0.3s all';
        dashboard_content_container.style.width = '90%';
        dashboard_logo.style.fontSize = '20px';
        userImage.style.width = '60px';

        menuIcons = document.getElementsByClassName('menuText');
        for(var i = 0; i < menuIcons.length; i++){
            menuIcons[i].style.display = 'none';
        }

        document.getElementsByClassName('dashboard_menu_list')[0].style.textAlign = 'center';
        sideBarOpen = false;
    } else{
        dashboard_sidebar.style.width = '20%';
        dashboard_content_container.style.width = '80%';
        dashboard_logo.style.fontSize = '40px';
        userImage.style.width = '60px';

        menuIcons = document.getElementsByClassName('menuText');
        for(var i = 0; i < menuIcons.length; i++){
            menuIcons[i].style.display = 'inline-block';
        }

        document.getElementsByClassName('dashboard_menu_list')[0].style.textAlign = 'left';
        sideBarOpen = true;
    }
    
    
});

//show submenu
document.addEventListener('click', function(e){
    let clickedEl = e.target;
    
    if(clickedEl.classList.contains('showHideSubmenu')){
        let subMenu = clickedEl.closest('li').querySelector('.subMenus');
        let mainMenuIcon = clickedEl.closest('li').querySelector('.mainMenuIconArrow');

        let subMenus = document.querySelectorAll('.subMenus');
        subMenus.forEach((sub) => {
            if(subMenu != sub) sub.style.display = 'none';
        });

        showHideSubMenu(subMenu,mainMenuIcon);
    }
});

function showHideSubMenu(subMenu,mainMenuIcon){
    if(subMenu != null){
        if(subMenu.style.display == 'block'){
            subMenu.style.display = 'none';
            mainMenuIcon.classList.remove('fa-angle-down');
            mainMenuIcon.classList.add('fa-angle-left');
        }
        else {
            subMenu.style.display = 'block';
            mainMenuIcon.classList.remove('fa-angle-left');
            mainMenuIcon.classList.add('fa-angle-down');
        }
    }
}

// add n hide active class to menu

let pathArray = window.location.pathname.split('/');
let curFile = pathArray[pathArray.length-1];

let curNav = document.querySelector('a[href="./' + curFile +'"]');
let mainNav = curNav.closest('li.liMainMenu');
mainNav.style.background = '#536878';

let subMenu = curNav.closest('.subMenus');
let mainMenuIcon = mainNav.querySelector('i.mainMenuIconArrow');

showHideSubMenu(subMenu,mainMenuIcon);
