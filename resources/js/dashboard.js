// Dashboard Perpustakaan JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper
    initializeBookSwiper();
    
    // Initialize Category Swiper
    initializeCategorySwiper();
    
    // Search functionality
    setupSearch();
    
    // Book card interactions
    setupBookCards();
    
    // Category pills interaction
    setupCategoryPills();
    
    // Animation on scroll
    setupScrollAnimations();
    
    // Update greeting based on time
    updateGreeting();
});

function initializeBookSwiper() {
    const bookSwiper = new Swiper('.book-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1280: {
                slidesPerView: 5,
            },
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        loop: true,
        grabCursor: true,
    });
}

function initializeCategorySwiper() {
    new Swiper('.category-swiper', {
        slidesPerView: 'auto',
        spaceBetween: 12,
        freeMode: true,
        mousewheel: {
            forceToAxis: true,
        },
        scrollbar: {
            el: '.swiper-scrollbar',
            draggable: true,
        },
    });
}

function setupSearch() {
    const searchInput = document.querySelector('input[type="text"][placeholder*="Cari judul buku"]');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-4', 'ring-indigo-400/30');
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-4', 'ring-indigo-400/30');
        });
        
        // Debounced search
        let searchTimeout;
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(e.target.value);
            }, 500);
        });
    }
}

function performSearch(query) {
    // Simulate search - in real app, this would be an API call
    console.log('Searching for:', query);
    if (query.length > 2) {
        // Show loading state
        const searchContainer = document.querySelector('.relative.max-w-md');
        if (searchContainer) {
            const loadingIndicator = document.createElement('div');
            loadingIndicator.className = 'absolute right-4 top-4 loading-pulse';
            loadingIndicator.innerHTML = `
                <svg class="w-5 h-5 text-indigo-500 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            `;
            
            const existingLoader = searchContainer.querySelector('.loading-pulse');
            if (!existingLoader) {
                searchContainer.appendChild(loadingIndicator);
                
                // Remove loader after 1 second (simulated search time)
                setTimeout(() => {
                    loadingIndicator.remove();
                }, 1000);
            }
        }
    }
}

function setupBookCards() {
    const bookCards = document.querySelectorAll('.book-card');
    
    bookCards.forEach(card => {
        // Add click event for detail view
        card.addEventListener('click', function(e) {
            if (!e.target.closest('button')) {
                const bookId = this.dataset.bookId;
                if (bookId) {
                    viewBookDetail(bookId);
                }
            }
        });
        
        // Add hover effect for availability badge
        const availabilityBadge = card.querySelector('.availability-badge');
        if (availabilityBadge) {
            card.addEventListener('mouseenter', () => {
                availabilityBadge.classList.add('scale-110');
            });
            
            card.addEventListener('mouseleave', () => {
                availabilityBadge.classList.remove('scale-110');
            });
        }
    });
}

function viewBookDetail(bookId) {
    // In a real application, this would open a modal or navigate to detail page
    console.log('Viewing book details for ID:', bookId);
    
    // Simulate API call
    fetch(`/api/buku/${bookId}`)
        .then(response => response.json())
        .then(data => {
            // Show book details modal
            showBookModal(data);
        })
        .catch(error => {
            console.error('Error fetching book details:', error);
        });
}

function showBookModal(bookData) {
    // Create modal HTML
    const modalHTML = `
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
                </div>
                
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="absolute top-4 right-4">
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="bg-white p-6">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="md:w-1/3">
                                <div class="aspect-[2/3] bg-gray-100 rounded-xl overflow-hidden">
                                    ${bookData.cover_url ? 
                                        `<img src="${bookData.cover_url}" alt="${bookData.judul}" class="w-full h-full object-cover">` : 
                                        '<div class="w-full h-full flex items-center justify-center text-gray-400"><svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>'
                                    }
                                </div>
                            </div>
                            
                            <div class="md:w-2/3">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">${bookData.judul}</h3>
                                <p class="text-gray-600 mb-4">${bookData.penulis}</p>
                                
                                <div class="flex items-center gap-4 mb-6">
                                    <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                                        ${bookData.kategori}
                                    </span>
                                    <span class="text-gray-500 text-sm">${bookData.tahun_terbit}</span>
                                    <span class="flex items-center gap-1 ${bookData.tersedia ? 'text-green-600' : 'text-red-600'}">
                                        <span class="w-2 h-2 rounded-full ${bookData.tersedia ? 'bg-green-500' : 'bg-red-500'}"></span>
                                        ${bookData.tersedia ? 'Tersedia' : 'Tidak Tersedia'}
                                    </span>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 mb-1">Deskripsi</h4>
                                        <p class="text-gray-600 text-sm">${bookData.deskripsi || 'Tidak ada deskripsi tersedia.'}</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">ISBN</h4>
                                            <p class="text-gray-600 text-sm">${bookData.isbn || '-'}</p>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 mb-1">Penerbit</h4>
                                            <p class="text-gray-600 text-sm">${bookData.penerbit || '-'}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-8">
                                    <button onclick="pinjamBuku('${bookData.id}')" ${!bookData.tersedia ? 'disabled' : ''} class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400 text-white font-semibold rounded-xl transition duration-300">
                                        ${bookData.tersedia ? 'Pinjam Sekarang' : 'Sedang Dipinjam'}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    const modalContainer = document.createElement('div');
    modalContainer.id = 'book-modal';
    modalContainer.innerHTML = modalHTML;
    document.body.appendChild(modalContainer);
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('book-modal');
    if (modal) {
        modal.remove();
        document.body.style.overflow = 'auto';
    }
}

function pinjamBuku(bookId) {
    console.log('Meminjam buku ID:', bookId);
    // In real app, this would make API call
    alert(`Buku dengan ID ${bookId} berhasil dipinjam!`);
    closeModal();
}

function setupCategoryPills() {
    const categoryPills = document.querySelectorAll('.category-pill');
    
    categoryPills.forEach(pill => {
        pill.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all pills
            categoryPills.forEach(p => p.classList.remove('bg-indigo-600', 'text-white', 'shadow-indigo-300'));
            
            // Add active class to clicked pill
            this.classList.add('bg-indigo-600', 'text-white', 'shadow-indigo-300');
            
            const category = this.textContent.trim();
            filterBooksByCategory(category);
        });
    });
}

function filterBooksByCategory(category) {
    console.log('Filtering books by category:', category);
    
    // In real app, this would filter book cards
    const bookCards = document.querySelectorAll('.book-card');
    bookCards.forEach(card => {
        const cardCategory = card.querySelector('.category-badge')?.textContent.trim();
        if (category === 'Lihat Semua' || cardCategory === category) {
            card.style.display = 'block';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 10);
        } else {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.display = 'none';
            }, 300);
        }
    });
}

function setupScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, observerOptions);

    // Observe elements for scroll animations
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

function updateGreeting() {
    const hour = new Date().getHours();
    const greetingElement = document.querySelector('.greeting-text');
    
    if (greetingElement) {
        let greeting;
        if (hour < 12) greeting = "Selamat Pagi";
        else if (hour < 15) greeting = "Selamat Siang";
        else if (hour < 19) greeting = "Selamat Sore";
        else greeting = "Selamat Malam";
        
        greetingElement.textContent = greeting;
    }
}

// Global function for modal
window.closeModal = closeModal;
window.pinjamBuku = pinjamBuku;