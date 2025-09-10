const books = document.querySelectorAll(".book");
const searchBtn = document.getElementById("searchBtn");
const searchInput = document.getElementById("searchInput");

searchBtn.addEventListener("click", function () {
  const input = searchInput.value.toLowerCase();
  books.forEach((book) => {
    const text = book.textContent.toLowerCase();
    book.style.display = text.includes(input) ? "flex" : "none";
  });
});

books.forEach((book) => {
  const borrowBtn = book.querySelector(".borrow-btn");
  borrowBtn.addEventListener("click", function () {
    borrowBtn.innerText = "Borrowed";
    borrowBtn.classList.add("borrowed");
    borrowBtn.disabled = true;
    alert("✅ You have borrowed: " + book.querySelector(".title").innerText);
  });
});
