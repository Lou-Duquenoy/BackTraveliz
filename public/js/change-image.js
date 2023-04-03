const liElements = document.querySelectorAll("li[data-image]");
const logoElement = document.querySelector("#logo");
let selectedLi = document.querySelector("li.selected");
let currentImageIndex = 0;

function selectImage(index) {
  const li = liElements[index];
  if (!li) {
    return;
  }

  const imageUrl = li.dataset.image;
  logoElement.setAttribute("src", imageUrl);

  selectedLi.classList.remove("selected");
  li.classList.add("selected");
  selectedLi = li;

  currentImageIndex = index;
}

liElements.forEach((li, index) => {
  li.addEventListener("click", () => {
    // Remove 'selected' class from previous li
    selectedLi.classList.remove("selected");

    // Add 'selected' class to clicked li
    li.classList.add("selected");
    selectedLi = li;

    // Select the image for the clicked li
    selectImage(index);
  });
});

setInterval(() => {
  const nextImageIndex = (currentImageIndex + 1) % liElements.length;
  selectImage(nextImageIndex);
}, 5000);
