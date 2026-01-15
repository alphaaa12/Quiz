class Quiz {
    constructor() {
        this.questions = [];
        this.currentQuestionIndex = 0;
        this.score = 0;
        this.selectedLevel = '';
        this.isAnswerSelected = false;

        document.addEventListener('DOMContentLoaded', () => {
            this.initEventListeners();
            console.log('Quiz initialisé');
        });
    }

    initEventListeners() {
        // Bouton de niveau
        document.querySelector('.level-buttons').addEventListener('click', (e) => {
            if (e.target.classList.contains('level-btn')) {
                this.selectedLevel = e.target.dataset.level;
                console.log(`Niveau sélectionné : ${this.selectedLevel}`);
                this.startQuiz();
            }
        });

        // Bouton suivante
        document.querySelector('.next-btn').addEventListener('click', () => {
            if (this.isAnswerSelected) {
                this.nextQuestion();
            } else {
                this.showMessage('Veuillez sélectionner une réponse', 'warning');
            }
        });
    }

    async startQuiz() {
        try {
            const response = await fetch(`api/questions.php?level=${this.selectedLevel}`);
            
            if (!response.ok) {
                throw new Error(`Erreur HTTP ${response.status}`);
            }

            const data = await response.json();
            console.log('Données reçues:', data);

            if (!Array.isArray(data)) {
                throw new Error('Format de données invalide');
            }

            if (data.length === 0) {
                throw new Error('Aucune question disponible pour ce niveau');
            }

            this.questions = data;
            this.currentQuestionIndex = 0;
            this.score = 0;
            this.showQuizInterface();
            this.showQuestion();

        } catch (error) {
            console.error('Erreur critique:', error);
            this.showMessage(error.message, 'error');
            this.questions = [];
        }
    }

    showQuizInterface() {
        document.querySelector('.level-selector').style.display = 'none';
        document.querySelector('.quiz-area').style.display = 'block';
        this.updateProgress();
    }

    showQuestion() {
        if (!this.questions.length) {
            this.showMessage('Aucune question chargée', 'error');
            return;
        }

        if (this.currentQuestionIndex >= this.questions.length) {
            this.endQuiz();
            return;
        }

        const question = this.questions[this.currentQuestionIndex];
        
        if (!question?.question) {
            console.warn('Question invalide, passage à la suivante');
            this.nextQuestion();
            return;
        }

        // Afficher la question
        document.querySelector('.question-container').innerHTML = `
            <h3>Question ${this.currentQuestionIndex + 1}</h3>
            <p>${question.question}</p>
        `;

        // Afficher les options
        const optionsContainer = document.querySelector('.options-container');
        optionsContainer.innerHTML = '';
        
        for (let i = 1; i <= 4; i++) {
            const option = document.createElement('div');
            option.className = 'option';
            option.innerHTML = question[`option${i}`];
            option.dataset.value = i;
            
            option.addEventListener('click', (e) => {
                if (!this.isAnswerSelected) {
                    this.handleAnswerSelection(e.target, question.correct);
                }
            });
            
            optionsContainer.appendChild(option);
        }

        this.updateProgress();
        this.isAnswerSelected = false;
    }

    handleAnswerSelection(selectedOption, correctAnswer) {
        this.isAnswerSelected = true;
        const options = document.querySelectorAll('.option');

        options.forEach(opt => {
            opt.style.pointerEvents = 'none';
            opt.classList.remove('selected', 'correct', 'wrong');
        });

        selectedOption.classList.add('selected');
        
        // Vérifier la réponse
        if (parseInt(selectedOption.dataset.value) === correctAnswer) {
            selectedOption.classList.add('correct');
            this.score++;
        } else {
            selectedOption.classList.add('wrong');
            options[correctAnswer - 1].classList.add('correct');
        }
    }

    nextQuestion() {
        if (this.currentQuestionIndex < this.questions.length - 1) {
            this.currentQuestionIndex++;
            this.resetOptions();
            this.showQuestion();
        } else {
            this.endQuiz();
        }
    }

    resetOptions() {
        document.querySelectorAll('.option').forEach(opt => {
            opt.style.pointerEvents = 'auto';
            opt.classList.remove('selected', 'correct', 'wrong');
        });
    }

    updateProgress() {
        const progress = ((this.currentQuestionIndex + 1) / this.questions.length) * 100;
        document.querySelector('.progress-bar').style.width = `${progress}%`;
    }

    async endQuiz() {
        try {
            // Validation d user
            if (typeof USER_ID === 'undefined' || !USER_ID) {
                throw new Error('Utilisateur non identifié');
            }
    
            const formData = new URLSearchParams();
            formData.append('user_id', USER_ID);
            formData.append('score', this.score);
            formData.append('level', this.selectedLevel);
    
            const response = await fetch('api/save_score.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData
            });
    
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Échec de la sauvegarde');
            }
    
            window.location.href = `history.php?score=${this.score}&level=${this.selectedLevel}`;
    
        } catch (error) {
            console.error('Erreur:', error);
            this.showMessage(error.message, 'error');
        
            setTimeout(() => window.location.href = 'history.php', 2000);
        }
    }

    showMessage(message, type = 'info') {
        const colors = {
            info: '#4CAF50',
            warning: '#FFC107',
            error: '#F44336'
        };

        const alertDiv = document.createElement('div');
        alertDiv.className = 'quiz-alert';
        alertDiv.textContent = message;
        alertDiv.style.backgroundColor = colors[type];
        
        document.querySelector('.quiz-area').prepend(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }
}

// Init
const quiz = new Quiz();