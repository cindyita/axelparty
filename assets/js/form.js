function homeManager() {
    return {
        form: {
            idguest: '',
            congrats: '',
            confirm: 'Si',
            extras: 0,
        },
        msg: '',
        errors: '',
        loading: false,
        
        requestModal: {
            open: false,
            name: '',
            contact: '',
            errors:'',
            show() {
                this.open = true;
            }
        },

        async submitForm() {
            this.loading = true;
            this.msg = '';
            this.errors = '';

            try {
                const res = await fetch('confirm', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form)
                });
            

                const result = await res.json();

                if (result.success) {
                    this.msg = '🎉 ¡Gracias por confirmar tu asistencia!';
                    this.form = { congrats: '', confirm: 'Si',extras:0 };
                    setTimeout(()=> this.msg = '', 8000);
                } else {
                    this.errors = 'Ocurrió un error al guardar tu confirmación.';
                    setTimeout(() => this.errors = '',8000);
                }
            } catch (e) {
                this.errors = 'Error fatal.';
                console.log(e);
            } finally {
                this.loading = false;
            }
        },

        async requestSend() {
            if (!this.requestModal.name.trim()) {
                this.requestModal.errors = "El nombre es obligatorio";
                setTimeout(() => this.requestModal.errors = '', 10000);
                return;
            }

            try {
                const res = await fetch('saveRequest', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name: this.requestModal.name, contact: this.requestModal.contact }),
                });

                const data = await res.json();

                if (data.success) {
                this.requestModal.open = false;
                this.msg = "Se ha enviado tu solicitud.";
                this.requestModal.name = '';
                this.requestModal.contact = '';
                setTimeout(() => this.msg = '', 8000);
                } else {
                    this.requestModal.errors = "Error al agregar invitado";
                    setTimeout(() => this.requestModal.errors = '', 10000);
                    console.log(data);
                }
            } catch (e) {
                this.requestModal.errors = "Error fatal";
                console.log(e);
                setTimeout(() => this.requestModal.errors = '', 10000);
            }
        },
    }
}

function countdown(targetDateStr) {
    return {
      targetDate: new Date(targetDateStr),
      days: 0,
      hours: 0,
      minutes: 0,
      seconds: 0,

      startCountdown() {
        this.updateCountdown();
        setInterval(() => this.updateCountdown(), 1000);
      },

      updateCountdown() {
        const now = new Date();
        const diff = this.targetDate - now;

        if (diff <= 0) {
          this.days = this.hours = this.minutes = this.seconds = 0;
          return;
        }

        this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
        this.hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        this.minutes = Math.floor((diff / (1000 * 60)) % 60);
        this.seconds = Math.floor((diff / 1000) % 60);
      }
    }
  }