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
        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('blur', () => {
                const cep = cepInput.value.replace(/\D/g, '');
                console.log('CEP digitado:', cep); 
                if (cep.length === 8) {
                    this.consultarCep(cep);
                } else {
                    this.showNotification('CEP inválido', 'error');
                }
            });
        }

        this.animateElements();
    }

    async consultarCep(cep) {
        console.log('Consultando CEP:', cep); 
        try {
            // Ajuste: chamar a rota do backend
            const response = await fetch(`/api/cep?cep=${cep}`);
            const data = await response.json();

            if (data.erro) {
                this.showNotification(data.erro, 'error');
                return;
            }

            document.getElementById('endereco').value = data.logradouro || '';
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.localidade || '';
            document.getElementById('estado').value = data.uf || '';
        } catch (error) {
            console.error('Erro ao consultar CEP:', error);
            this.showNotification('Não foi possível consultar o CEP', 'error');
        }
    }

    animateElements() {
        const animatedElements = document.querySelectorAll('[data-animate]');
        animatedElements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.1}s`;
            element.classList.add('fade-in');
        });
    }

    async loadInitialData() {
        // Seu código para carregar dados iniciais
    }

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

const doaSysApp = new DoaSysApp();
window.DoaSysApp = doaSysApp;
