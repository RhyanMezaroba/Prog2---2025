// Shared JavaScript across all pages
class DoaSysApp {
    constructor() {
        this.init();
    }

    init() {
        console.log('DoaSys App initialized');
        this.setupEventListeners();
        this.loadInitialData();
    }

    setupEventListeners() {
        // Global event listeners
        document.addEventListener('DOMContentLoaded', () => {
            this.animateElements();
        });
    }

    animateElements() {
        // Add fade-in animation to elements with data-animate attribute
        const animatedElements = document.querySelectorAll('[data-animate]');
        animatedElements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
            element.classList.add('fade-in');
        });
    }

    async loadInitialData() {
        try {
            // Load initial data if needed
            const stats = await this.fetchStats();
            this.updateStats(stats);
        } catch (error) {
            console.error('Error loading initial data:', error);
        }
    }

    async fetchStats() {
        // Simulate API call
        return new Promise(resolve => {
            setTimeout(() => {
                resolve({
                    totalDoacoes: 1247,
                    familiasAtendidas: 856,
                    cidadesAtendidas: 42
                });
            }, 1000);
        });
    }

    updateStats(stats) {
        // Update stats in the DOM if elements exist
        const statsElements = {
            'total-doacoes': stats.totalDoacoes,
            'familias-atendidas': stats.familiasAtendidas,
            'cidades-atendidas': stats.cidadesAtendidas
        };

        Object.keys(statsElements).forEach(key => {
            const element = document.getElementById(key);
            if (element) {
                element.textContent = statsElements[key].toLocaleString('pt-BR');
            }
        });
    }

    // Utility function to format currency
    formatCurrency(value) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(value);
    }

    // Utility function to format date
    formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('pt-BR');
    }

    // Show notification
    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// Initialize the app
const doaSysApp = new DoaSysApp();

// Export for use in other modules
window.DoaSysApp = doaSysApp;