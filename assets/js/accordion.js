class Accordion {
  constructor(el) {
    // Store the <details> element
    this.el = el;
    // Store the <summary> element
    this.summary = el.querySelector("summary");
    // Store the <div class="content"> element
    this.content = el.querySelector(".content");

    // Store the animation object (so we can cancel it if needed)
    this.animation = null;
    // Store if the element is closing
    this.isClosing = false;
    // Store if the element is expanding
    this.isExpanding = false;
    // Detect user clicks on the summary element
    this.summary.addEventListener("click", (e) => this.onClick(e));
  }

  onClick(e) {
    // Stop default behaviour from the browser
    e.preventDefault();
    // Add an overflow on the <details> to avoid content overflowing
    this.el.style.overflow = "hidden";
    // Check if the element is being closed or is already closed
    if (this.isClosing || !this.el.open) {
      this.open();
      // Check if the element is being openned or is already open
    } else if (this.isExpanding || this.el.open) {
      this.shrink();
    }
  }

  shrink() {
    // Set the element as "being closed"
    this.isClosing = true;
    this.el.classList.add("closing-faq");
    // Store the current height of the element
    const startHeight = `${this.el.offsetHeight}px`;
    // Calculate the height of the summary - not 20px is height of bottom margin.
    const endHeight = `${this.summary.offsetHeight + 20}px`;

    // If there is already an animation running
    if (this.animation) {
      // Cancel the current animation
      this.animation.cancel();
    }

    // Start a WAAPI animation
    this.animation = this.el.animate(
      {
        // Set the keyframes from the startHeight to endHeight
        height: [startHeight, endHeight],
      },
      {
        duration: 600,
        easing: "ease-in",
      },
    );

    this.content.animate(
      [
        // keyframes
        { transform: "translateY(0px)" },
        { transform: "translateY(-10px)" },
      ],
      {
        // timing options
        duration: 600,
        easing: "ease-in",
        iterations: 1,
      },
    );

    // When the animation is complete, call onAnimationFinish()
    this.animation.onfinish = () => this.onAnimationFinish(false);
    // If the animation is cancelled, isClosing variable is set to false
    this.animation.oncancel = () => (this.isClosing = false);
  }

  open() {
    // Apply a fixed height on the element
    this.el.style.height = `${this.el.offsetHeight}px`;
    // Force the [open] attribute on the details element
    this.el.open = true;
    //this.el.classList.add("show-highlight");
    // Wait for the next frame to call the expand function
    window.requestAnimationFrame(() => this.expand());
  }

  expand() {
    // Set the element as "being expanding"
    this.isExpanding = true;
    //this.el.classList.remove("show-highlight");
    // Get the current fixed height of the element
    const startHeight = `${this.el.offsetHeight}px`;
    // Calculate the open height of the element (summary height + content height)
    const endHeight = `${this.summary.offsetHeight + this.content.offsetHeight}px`;

    // If there is already an animation running
    if (this.animation) {
      // Cancel the current animation
      this.animation.cancel();
    }

    // Start a WAAPI animation
    this.animation = this.el.animate(
      {
        // Set the keyframes from the startHeight to endHeight
        height: [startHeight, endHeight],
        //        transform: "translateY(12px)",
      },
      {
        duration: 600,
        easing: "ease-in",
      },
    );

    this.content.animate(
      [
        // keyframes
        { transform: "translateY(-10px)" },
        { transform: "translateY(0px)" },
      ],
      {
        // timing options
        duration: 600,
        easing: "ease-in",
        iterations: 1,
      },
    );
    // When the animation is complete, call onAnimationFinish()
    this.animation.onfinish = () => this.onAnimationFinish(true);
    // If the animation is cancelled, isExpanding variable is set to false
    this.animation.oncancel = () => (this.isExpanding = false);
  }

  onAnimationFinish(open) {
    // Set the open attribute based on the parameter
    this.el.classList.remove("closing-faq");
    this.el.open = open;
    // Clear the stored animation
    this.animation = null;
    // Reset isClosing & isExpanding
    this.isClosing = false;
    this.isExpanding = false;
    // Remove the overflow hidden and the fixed height
    this.el.style.height = this.el.style.overflow = "";

    // This is used if show animation is showed when the animation was finished.
    // if (open) this.el.classList.add("show-highlight");
  }
}

export default function initAccordions() {
  document.querySelectorAll(".accordion details").forEach((el) => {
    new Accordion(el);
  });
}
