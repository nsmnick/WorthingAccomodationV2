// https://css-tricks.com/using-css-transitions-auto-dimensions/#aa-technique-3-javascript
function collapseMenu(element) {
  const menu = element;
  const sectionHeight = menu.scrollHeight;

  // Temporarily disable all css transitions.
  const elementTransition = menu.style.transition;
  menu.style.transition = "";

  // On the next frame (as soon as the previous style change has taken effect),
  // explicitly set the element's height to its current pixel height, so we
  // aren't transitioning out of 'auto'.
  requestAnimationFrame(() => {
    menu.style.height = `${sectionHeight}px`;
    menu.style.transition = elementTransition;

    // On the next frame (as soon as the previous style change has taken effect),
    // have the element transition to height: 0.
    requestAnimationFrame(() => {
      menu.style.removeProperty("height");
    });
  });
  //menu.style.display = "none";
  menu.setAttribute("data-collapsed", "true");
}

function expandMenu(element) {
  const menu = element;
  menu.style.display = "block";
  const sectionHeight = menu.scrollHeight;
  menu.style.height = `${sectionHeight}px`;

  //menu.style.height = "auto";

  // Reset to initial height.
  menu.addEventListener("transitionend", function eventHandler() {
    menu.style.display = "block";
    menu.removeEventListener("transitionend", eventHandler);
    menu.style.height = "auto";
  });

  menu.setAttribute("data-collapsed", "false");
}

function toggleSubMenu(e) {
  const currMenu = e.currentTarget;
  //console.log("here");
  if (window.innerWidth > 1180) {
    return;
  }

  if (!currMenu.parentNode.classList.contains("menu-item-has-children--open")) {
    e.preventDefault();

    // Collapse all other menus.
    document
      .getElementById("main-menu")
      .querySelectorAll(".menu-item-has-children--open")
      .forEach((menuEl) => {
        collapseMenu(menuEl.querySelector(".sub-menu"));
        menuEl.classList.remove("menu-item-has-children--open");
      });

    expandMenu(currMenu.nextElementSibling);
    currMenu.parentNode.classList.add("menu-item-has-children--open");
  } else if (currMenu.hasAttribute("href") === false) {
    collapseMenu(currMenu.nextElementSibling);
    currMenu.parentNode.classList.remove("menu-item-has-children--open");
  }
}

export default function initMenu() {
  const pageHeader = document.getElementById("page-header");
  const mobileMenuButton = document.getElementById("mobile-menu-toggle");
  const mainMenu = document.getElementById("main-menu");
  //const navOuter = document.getElementById("main-menu-outer");

  function scrolledState() {
    if (document.documentElement.scrollTop > 40) {
      pageHeader.classList.add("page-header--scrolled");
      pageHeader.classList.remove("page-header--unscrolled");
    } else if (pageHeader.classList.contains("page-header--scrolled")) {
      pageHeader.classList.remove("page-header--scrolled");
      pageHeader.classList.add("page-header--unscrolled");
    }
  }

  // Run once in case page is already scrolled.
  scrolledState(true);

  document.addEventListener("scroll", () => {
    scrolledState();
  });

  // Toggle mobile menu.
  mobileMenuButton.addEventListener("click", (e) => {
    e.preventDefault();
    mobileMenuButton.classList.toggle("mobile-menu-toggle--open");
    mainMenu.classList.toggle("main-menu--open");
    //   navOuter.classList.toggle("main-menu-outer--open");
    pageHeader.classList.toggle("page-header--open");

    document.body.classList.toggle("fixed");
  });

  // Toggle sub-menus.
  mainMenu.querySelectorAll(".menu-item-has-children > a").forEach((el) => {
    el.addEventListener("click", toggleSubMenu);
  });
}
