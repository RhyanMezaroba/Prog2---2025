class CustomNavbar extends HTMLElement {
    connectedCallback() {
        this.attachShadow({ mode: 'open' });
        this.shadowRoot.innerHTML = `
            <style>
                nav {
                    background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
                    padding: 1rem 2rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    position: sticky;
                    top: 0;
                    z-index: 1000;
                }
                .logo {
                    color: white;
                    font-weight: bold;
                    font-size: 1.5rem;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                .nav-links {
                    display: flex;
                    gap: 2rem;
                    list-style: none;
                    margin: 0;
                    padding: 0;
                    align-items: center;
                }
                .nav-link {
                    color: white;
                    text-decoration: none;
                    font-weight: 500;
                    padding: 0.5rem 1rem;
                    border-radius: 0.375rem;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }
                .nav-link:hover {
                    background: rgba(255, 255, 255, 0.1);
                    transform: translateY(-1px);
                }
                .nav-link.active {
                    background: rgba(255, 255, 255, 0.2);
                }
                .mobile-menu-btn {
                    display: none;
                    background: none;
                    border: none;
                    color: white;
                    cursor: pointer;
                }
                @media (max-width: 768px) {
                    nav {
                        padding: 1rem;
                    }
                    .mobile-menu-btn {
                        display: block;
                    }
                    .nav-links {
                        display: none;
                        position: absolute;
                        top: 100%;
                        left: 0;
                        right: 0;
                        background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
                        flex-direction: column;
                        padding: 1rem;
                        gap: 1rem;
                    }
                    .nav-links.open {
                        display: flex;
                    }
                }
            </style>
            <nav>
                <a href="/" class="logo">
                    <i data-feather="heart"></i>
                    DoaSys
                </a>
                
                <button class="mobile-menu-btn">
                    <i data-feather="menu"></i>
                </button>
                
                <ul class="nav-links">
                    <li><a href="/" class="nav-link"><i data-feather="home"></i>Início</a></li>
                    <li><a href="/cadastro.html" class="nav-link"><i data-feather="plus"></i>Cadastrar</a></li>
                    <li><a href="/doacoes.html" class="nav-link"><i data-feather="list"></i>Doações</a></li>
                    <li><a href="/relatorios.html" class="nav-link"><i data-feather="bar-chart"></i>Relatórios</a></li>
                    <li><a href="/sobre.html" class="nav-link"><i data-feather="info"></i>Sobre</a></li>
                </ul>
            </nav>
        `;

        this.setupMobileMenu();
        this.updateActiveLink();
    }

    setupMobileMenu() {
        const mobileBtn = this.shadowRoot.querySelector('.mobile-menu-btn');
        const navLinks = this.shadowRoot.querySelector('.nav-links');

        mobileBtn.addEventListener('click', () => {
            navLinks.classList.toggle('open');
            const icon = mobileBtn.querySelector('i');
            if (navLinks.classList.contains('open')) {
                icon.setAttribute('data-feather', 'x');
            } else {
                icon.setAttribute('data-feather', 'menu');
            }
            feather.replace();
        });

        // Close mobile menu when clicking on a link
        const links = this.shadowRoot.querySelectorAll('.nav-link');
        links.forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('open');
                mobileBtn.querySelector('i').setAttribute('data-feather', 'menu');
                feather.replace();
            });
        });
    }

    updateActiveLink() {
        const currentPath = window.location.pathname;
        const links = this.shadowRoot.querySelectorAll('.nav-link');

        links.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    }
}

customElements.define('custom-navbar', CustomNavbar);