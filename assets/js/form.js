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
        }
    }
}