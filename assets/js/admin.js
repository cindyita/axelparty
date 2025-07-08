function guestManager() {
  return {
    name: '',
    contact: '',
    active: 1,
    msg: '',
    errors: '',
    guests: [],
    filter: "",

    guestsFilter() {
       if (!this.filter.trim()) return this.guests;

        return this.guests.filter(g =>
            g.name.toLowerCase().includes(this.filter.toLowerCase()) ||
            g.contact.toLowerCase().includes(this.filter.toLowerCase()) || g.confirm.toLowerCase().includes(this.filter.toLowerCase())
        );
    },

    modal: {
      open: false,
      msg: '',
      name: '',
      show(msg,name) {
        this.msg = msg;
        this.name = name;
        this.open = true;
      }
    },
    confirmModal: {
      open: false,
      msg: '',
      confirmAction: () => {},

      show(msg, accion) {
        this.msg = msg;
        this.confirmAction = accion;
        this.open = true;
      }
    },
    editModal: {
      open: false,
      id: '',
      name: '',
      contact: '',
      show(id,name,contact) {
        this.id = id;
        this.name = name;
        this.contact = contact;
        this.open = true;
      }
    },
    copyLink: {
      id: '',
      msg: '',
      async copy(id) {
        this.id = id;
        const url = `${window.location.origin}/invite-${id}`;

        try {
          await navigator.clipboard.writeText(url);
          this.msg = '🔗 Enlace copiado al portapapeles: '+url;
        } catch (e) {
          console.error('Error al copiar el enlace:', e);
          this.msg = '❌ No se pudo copiar el enlace';
        }
        setTimeout(() => this.msg = '', 6000);
      }
    },
    statsModal: {
      open: false,
      msg: '',
      stats: {total_guests: 0, total_confirm: 0, total_si: 0, total_no: 0, total_talvez: 0, total_attend: 0},
      async show(msg) {
        this.msg = msg;
        const res = await fetch('admin/getstats');
        const data = await res.json();
        this.stats = data[0];
        this.open = true;
      }
    },

    sortColumn: 'id',
    sortAsc: false,
    sortBy(column) {
      if (this.sortColumn === column) {
        this.sortAsc = !this.sortAsc;
      } else {
        this.sortColumn = column;
        this.sortAsc = true;
      }

      this.guests.sort((a, b) => {
        let valA = a[column] ?? '';
        let valB = b[column] ?? '';

        if (column === 'confirm') {
          valA = valA?.split('(')[0].trim();
          valB = valB?.split('(')[0].trim();
        }

        if (!isNaN(valA) && !isNaN(valB)) {
          return this.sortAsc ? valA - valB : valB - valA;
        }

        return this.sortAsc
          ? String(valA).localeCompare(String(valB))
          : String(valB).localeCompare(String(valA));
      });
    },

    init() {
      this.fetchGuests();
    },

    async fetchGuests() {
      try {
        const res = await fetch('admin/getguests');
        const data = await res.json();
        this.guests = data;
      } catch (e) {
          this.errors = "Error cargando invitados";
          console.error("Error cargando invitados", e);
          console.log(e);
          console.log(res);
          setTimeout(() => this.errors = '', 10000);
      }
    },

    async enviar() {
      if (!this.name.trim()) {
        this.errors = "El nombre es obligatorio";
        setTimeout(() => this.errors = '', 10000);
        return;
      }

      try {
        const res = await fetch('admin/save', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name: this.name, contact: this.contact, active: this.active }),
        });

        const data = await res.json();

        if (data.success) {
          this.guests.unshift({ id: +data.id, name: this.name, contact: this.contact, confirm: '', congrats: '', active: +this.active });
          console.log(this.guests);
          
          this.msg = "Invitado agregado correctamente";
          this.name = '';
          this.contact = '';
          this.active = 1;
          setTimeout(() => this.msg = '', 8000);
        } else {
            this.errors = "Error al agregar invitado";
            setTimeout(() => this.errors = '', 10000);
            console.log(data);
        }
      } catch (e) {
          this.errors = "Error fatal";
          console.log(e);  
          console.log(res);
          setTimeout(() => this.errors = '', 10000);
      }
    },

    async deleteGuest(id) {

        try {
            const res = await fetch(`admin/delete/${id}`, {
                method: 'GET'
            });

         const data = await res.json();

            if (data.success) {
                this.guests = this.guests.filter(guest => guest.id !== id);
              this.msg = "Invitado eliminado.";
              this.confirmModal.open = false;
            } else {
                this.errors = "Error al eliminar.";
            }
        } catch (e) {
            this.errors = "Error de conexión al eliminar.";
            console.error(e);
        }
      setTimeout(() => { this.errors = ''; this.msg = '' }, 10000);
    },
    async update() {

      try {
        const res = await fetch('admin/update', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id: this.editModal.id, name: this.editModal.name, contact: this.editModal.contact }),
        });

        const data = await res.json();

        if (data.success) {
          this.msg = "Invitado actualizado correctamente";
          setTimeout(() => this.msg = '', 8000);

          const index = this.guests.findIndex(g => g.id === this.editModal.id);
          if (index !== -1) {
            this.guests[index].name = this.editModal.name;
            this.guests[index].contact = this.editModal.contact;
          }

          this.editModal.id = '';
          this.editModal.name = '';
          this.editModal.contact = '';
          this.editModal.open = false;
        } else {
            this.errors = "Error al actualizar invitado";
            console.log(data);
            setTimeout(() => this.errors = '', 10000);
        }
      } catch (e) {
          this.errors = "Error fatal";
          console.log(e);  
          console.log(res);
          setTimeout(() => this.errors = '', 10000);
      }
    },
    async invite(id) {

        try {
            const res = await fetch(`admin/invite/${id}`, {
                method: 'GET'
            });

         const data = await res.json();

            if (data.success) {
              const index = this.guests.findIndex(g => g.id === id);
              if (index !== -1) {
                this.guests[index].active= 1
              }
              this.msg = "Se ha agregado la invitación";
              this.confirmModal.open = false;
            } else {
                this.errors = "Error al invitar.";
            }
        } catch (e) {
            this.errors = "Error fatal.";
            console.error(e);
        }
      setTimeout(() => { this.errors = ''; this.msg = '' }, 10000);
    },

    exportTableToCSV(archiveName, idTable) {
      this.exporting = true;
      
      // $nextTick(() => {
          setTimeout(() => {
              const table = document.getElementById(idTable);
              let csv = [];

              for (let row of table.rows) {
                  let cols = [...row.cells].map(cell => {
                      let text = cell.innerText.replace(/"/g, '""');
                      return `"${text}"`;
                  });
                  csv.push(cols.join(","));
              }

              const blob = new Blob([csv.join("\n")], { type: "text/csv" });
              const url = URL.createObjectURL(blob);
              const link = document.createElement("a");
              link.href = url;
              link.download = archiveName;
              link.click();

              this.exporting = false;
          }, 100);
      // });
    }
    
  }
}

function modal() {
  return {
    open: false,
    msg: '',
    show(msg) {
      this.msg = msg;
      this.open = true;
    }
  }
}
