
    const searchInput = document.getElementById("searchInput");
    const typeFilter = document.getElementById("typeFilter");
    const brandFilter = document.getElementById("brandFilter");
    const priceRange = document.getElementById("priceRange");
    const priceValue = document.getElementById("priceValue");
    const carGrid = document.getElementById("carGrid").children;

    function filterCars() {
      const searchText = searchInput.value.toLowerCase();
      const type = typeFilter.value;
      const brand = brandFilter.value;
      const maxPrice = parseInt(priceRange.value);

      for (let card of carGrid) {
        const name = card.dataset.name.toLowerCase();
        const cType = card.dataset.type;
        const cBrand = card.dataset.brand;
        const cPrice = parseInt(card.dataset.price);

        const matches =
          (name.includes(searchText)) &&
          (type === "" || cType === type) &&
          (brand === "" || cBrand === brand) &&
          (cPrice <= maxPrice);

        card.style.display = matches ? "block" : "none";
      }
    }

    searchInput.addEventListener("input", filterCars);
    typeFilter.addEventListener("change", filterCars);
    brandFilter.addEventListener("change", filterCars);
    priceRange.addEventListener("input", () => {
      priceValue.textContent = priceRange.value;
      filterCars();
    });

  // Modal elements
const carModal = document.getElementById("carModal");
const closeModalBtn = document.getElementById("closeModalBtn");
const shareBtn = document.getElementById("shareBtn");

// Open modal
function openModal(btn) {
    const card = btn.closest('.car-card');
    
    document.getElementById('modalImage').src = card.querySelector('img').src;
    document.getElementById('modalTitle').innerText = card.dataset.name;
    document.getElementById('modalPrice').innerText = card.dataset.price;
    document.getElementById('modalBrand').innerText = card.dataset.brand;
    document.getElementById('modalType').innerText = card.dataset.type;
    document.getElementById('modalSeats').innerText = card.dataset.seats;
    document.getElementById('modalStatus').innerText = card.dataset.fuel;
    document.getElementById('modalTransmission').innerText = card.dataset.transmission;

    // Pass car ID to booking page
    const bookNowBtn = document.getElementById('bookNowBtn');
    bookNowBtn.href = `../pages/book_rent.php?id=${card.dataset.id}`;

    carModal.style.display = "flex";
}

// Close modal
function closeModal() {
    carModal.style.display = "none";
}

// Attach close function
closeModalBtn.onclick = closeModal;

// Close modal when clicking outside modal content
window.onclick = function(e) {
    if (e.target === carModal) {
        closeModal();
    }
}

// Share button functionality
shareBtn.onclick = function () {
    const shareData = {
        title: document.getElementById("modalTitle").innerText,
        text: "Check out this car for rent!",
        url: window.location.href
    };

    if (navigator.share) {
        navigator.share(shareData).catch(err => console.log("Error sharing:", err));
    } else {
        alert("Sharing not supported in this browser. Copy URL: " + shareData.url);
    }
};
