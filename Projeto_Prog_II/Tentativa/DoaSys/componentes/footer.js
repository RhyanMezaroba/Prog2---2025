class CustomFooter extends HTMLElement {
    connectedCallback() {
        this.attachShadow({ mode: 'open' });
        this.shadowRoot.innerHTML = `
            <style>
                footer {
                    background: #1F2937;
                    color: white;
                    padding: 3rem 2rem;
                    text-align: center;
                    margin-top: auto;
                }
                .footer-content {
                    max-width: 1200px;
                    margin: 0 auto;
                }
                .footer-links {
                    display: flex;
                    justify-content: center;
                    gap: 2rem;
                    margin-bottom: 2rem;
                    flex-wrap: wrap;
                }
                .footer-link {
                    color: #D1D5DB;
                    text-decoration: none;
                    transition: color 0.3s ease;
                }
                .footer-link:hover {
                    color: white;
                }
                .footer-info {
                    border-top: 1px solid #374151;
                    padding-top: 2rem;
                    margin-top: 2rem;
                }
                .social-links {
                    display: flex;
                    justify-content: center;
                    gap: 1rem;
                    margin: 1rem 0;
                }
                .social-link {
                    color: #D1D5DB;
                    transition: color 0.3s ease;
                }
                .social-link:hover {
                    color: white;
                }
                @media (max-width: 768px) {
                    footer {
                        padding: 2rem 1rem;
                    }
                    .footer-links {
                        gap: 1rem;
                    }
                }
            </style>
            <footer>
                <div class="footer-content">
                    <div class="footer-links">
                        <a href="/sobre.html" class="footer-link">Sobre o DoaSys</a>
                        <a href="/privacidade.html" class="footer-link">Política de Privacidade</a>
                        <a href="/termos.html" class="footer-link">Termos de Uso</a>
                        <a href="/contato.html" class="footer-link">Contato</a>
                    </div>
                    
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i data-feather="facebook"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i data-feather="instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i data-feather="twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i data-feather="mail"></i>
                        </a>
                    </div>
                    
                    <div class="footer-info">
                        <p>&copy; 2024 DoaSys - Sistema de Gerenciamento de Doações. Todos os direitos reservados.</p>
                        <p class="text-sm text-gray-400 mt-2">
                        CNPJ: 12.345.678/0001-90</p>
                    </div>
                </div>
            </footer>
        `;
    }
}

customElements.define('custom-footer', CustomFooter);