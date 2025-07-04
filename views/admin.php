<script src="./assets/js/admin.js"></script>
<div class="p-7" x-data="guestManager()">
    <h1 class="text-2xl font-bold mb-4">Lista de invitados del evento: <?= $_ENV['EVENT_TITLE'] ?></h1>
    <div>
        <form @submit.prevent="enviar" class="mb-6">
            <div class="flex gap-3 flex-col md:flex-row">
                <input
                    type="text"
                    x-model="name"
                    class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition"
                    placeholder="Nombre completo"
                    required
                >
                <input
                    type="text"
                    x-model="contact"
                    class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition"
                    placeholder="Teléfono/email"
                >
                <button
                    type="submit"
                    class="button text-white rounded-full px-6 transition flex items-center gap-2 py-2">
                    Agregar
                    <svg xmlns="http://www.w3.org/2000/svg" height="14" width="12.25" viewBox="0 0 448 512"><path fill="#ffffff" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                </button>
            </div>
        </form>
    </div>

    <template x-if="msg">
        <div class="text-green-600 text-center mb-2" x-text="msg"></div>
    </template>

    <template x-if="errors">
        <div class="text-red-600 text-center mb-2" x-text="errors"></div>
    </template>

    <template x-if="copyLink.msg">
        <div class="text-green-600 text-center mb-2" x-text="copyLink.msg"></div>
    </template>
    
    <div class="p-5 bg-white rounded-lg border border-blue-300">

        <div>
            <input
                type="text"
                x-model="filter"
                class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-3 py-1 text-sm mb-3 transition"
                placeholder="Buscar.."
                required
            >
        </div>

        <div class="relative overflow-x-auto pb-2">
            <table class="w-full text-sm text-left rtl:text-right">
                <thead class="text-xs uppercase">
                    <tr>
                        <th @click="sortBy('id')" class="py-1 px-2 border border-blue-300 bg-teal-100 cursor-pointer">Id <span class="text-lg text-teal-400" x-text="sortColumn != 'id' ? '↕' :(sortAsc ? '↑' : '↓')"></span>
                        </th>
                        <th @click="sortBy('name')" class="py-1 px-2 border border-blue-300 bg-teal-100 cursor-pointer">Nombre <span class="text-lg text-teal-400" x-text="sortColumn != 'name' ? '↕' :(sortAsc ? '↑' : '↓')"></span></th>
                        <th @click="sortBy('contact')" class="py-1 px-2 border border-blue-300 bg-teal-100 cursor-pointer">Contacto <span class="text-lg text-teal-400" x-text="sortColumn != 'contact' ? '↕' :(sortAsc ? '↑' : '↓')"></span></th>
                        <th @click="sortBy('confirm')" class="py-1 px-2 border border-blue-300 bg-teal-100 cursor-pointer">Confirmación <span class="text-lg text-teal-400" x-text="sortColumn != 'confirm' ? '↕' :(sortAsc ? '↑' : '↓')"></span></th>
                        <th class="p-2 border border-blue-300 bg-teal-100">Felicitaciones</th>
                        <th class="py-1 px-2 border border-blue-300 bg-teal-100"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="guest in guestsFilter()" :key="guest.id">
                        <tr>
                            
                            <td class="p-2 md:table-cell font-medium border border-blue-300" x-text="guest.id">
                            </td>
                            <td class="p-2 md:table-cell font-medium border border-blue-300" x-text="guest.name">
                            </td>
                            <td class="p-2 md:table-cell border border-blue-300" x-text="guest.contact">
                            </td>
                            <td class="p-2 md:table-cell border border-blue-300" x-text="guest.confirm">
                            </td>
                            <td
                            class="p-2 border border-blue-300 hover:underline"
                            >   
                                <span x-show="guest.congrats" @click="modal.mostrar(guest.congrats, guest.name)" class="cursor-pointer">
                                    <span x-text="guest.congrats.length > 24 ? guest.congrats.slice(0, 24) + '…' : guest.congrats"></span>
                                    <span class="text-teal-500 ml-1">[Ver más]</span>
                                </span>

                            </td>
                            <td class="p-2 md:table-cell  font-medium border border-blue-300">
                                <div class="flex gap-2 items-center">
                                    <a class="cursor-pointer group" @click="confirmModal.mostrar('¿Eliminar a ' + guest.name + '?', () => deleteGuest(guest.id))">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 448 512">
                                            <path
                                            fill="#6d9ecb"
                                            class="group-hover:fill-red-500 transition-colors duration-200"
                                            d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"
                                            />
                                        </svg>
                                    </a>

                                    <a class="cursor-pointer group" @click="editModal.mostrar(guest.id,guest.name,guest.contact)">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" width="17.5" viewBox="0 0 512 512"><path fill="#6d9ecb" class="group-hover:fill-yellow-500 transition-colors duration-200" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                    </a>

                                    <a class="cursor-pointer group" @click="copyLink.copy(guest.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="20" width="25" viewBox="0 0 640 512"><path fill="#6d9ecb" class="group-hover:fill-teal-400 transition-colors duration-200" d="M579.8 267.7c56.5-56.5 56.5-148 0-204.5c-50-50-128.8-56.5-186.3-15.4l-1.6 1.1c-14.4 10.3-17.7 30.3-7.4 44.6s30.3 17.7 44.6 7.4l1.6-1.1c32.1-22.9 76-19.3 103.8 8.6c31.5 31.5 31.5 82.5 0 114L422.3 334.8c-31.5 31.5-82.5 31.5-114 0c-27.9-27.9-31.5-71.8-8.6-103.8l1.1-1.6c10.3-14.4 6.9-34.4-7.4-44.6s-34.4-6.9-44.6 7.4l-1.1 1.6C206.5 251.2 213 330 263 380c56.5 56.5 148 56.5 204.5 0L579.8 267.7zM60.2 244.3c-56.5 56.5-56.5 148 0 204.5c50 50 128.8 56.5 186.3 15.4l1.6-1.1c14.4-10.3 17.7-30.3 7.4-44.6s-30.3-17.7-44.6-7.4l-1.6 1.1c-32.1 22.9-76 19.3-103.8-8.6C74 372 74 321 105.5 289.5L217.7 177.2c31.5-31.5 82.5-31.5 114 0c27.9 27.9 31.5 71.8 8.6 103.9l-1.1 1.6c-10.3 14.4-6.9 34.4 7.4 44.6s34.4 6.9 44.6-7.4l1.1-1.6C433.5 260.8 427 182 377 132c-56.5-56.5-148-56.5-204.5 0L60.2 244.3z"/></svg>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        <form method="get" action="logout">
            <button
                type="submit"
                class="button-secondary text-white rounded-full px-4 transition flex items-center gap-2 py-2">
                Cerrar sesión
            </button>
        </form>
    </div>

    <!----MODALS---->
    <div
        x-show="modal.open"
        @click.away="modal.open = false"
        @keydown.escape.window="modal.open = false"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        style="display: none;"
    >
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md relative">
            <button
            @click="modal.open = false"
            class="absolute top-0 right-3 text-gray-500 hover:text-red-500 text-3xl"
            >&times;</button>
            <h2 class="text-xl mb-4">🎉 Felicitación de <span x-text="modal.name"></span></h2>
            <p class="text-gray-800 whitespace-pre-line text-regular" x-text="modal.msg"></p>
        </div>
    </div>

    <div
        x-show="confirmModal.open"
        @click.away="confirmModal.open = false"
        @keydown.escape.window="confirmModal.open = false"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        style="display: none;"
    >
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm relative">
            <button
            @click="confirmModal.open = false"
            class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-2xl"
            >&times;</button>

            <h2 class="text-lg font-semibold text-gray-800 mb-3">¿Estás segur@?</h2>
            <p class="mb-5 text-gray-700" x-text="confirmModal.msg"></p>

            <div class="flex justify-end gap-3">
            <button
                @click="confirmModal.open = false"
                class="button text-white rounded-full px-6 transition flex items-center gap-2 py-2"
            >Cancelar</button>
            
            <button
                @click="confirmModal.confirmar()"
                class="button text-white rounded-full px-6 transition flex items-center gap-2 py-2 bg-red-600 hover:bg-red-700"
            >Eliminar</button>
            </div>
        </div>
    </div>

    <div
        x-show="editModal.open"
        @click.away="editModal.open = false"
        @keydown.escape.window="editModal.open = false"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        style="display: none;"
    >
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-sm relative">
            <button
            @click="editModal.open = false"
            class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-2xl"
            >&times;</button>

            <h2 class="text-lg font-semibold text-gray-800 mb-3">Editar invitad@</h2>
            <div>
                <input
                    type="text"
                    x-model="editModal.name"
                    class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition w-full mb-2"
                    placeholder="Nombre completo"
                    required
                >
                <input
                    type="text"
                    x-model="editModal.contact"
                    class="input border border-blue-300 rounded-full focus:outline-none focus:ring-4 focus:ring-blue-300 px-4 py-2 transition w-full mb-2"
                    placeholder="Teléfono/email"
                >
            </div>

            <div class="flex justify-end gap-3">
            <button
                @click="update()"
                class="button text-white rounded-full px-6 transition flex items-center gap-2 py-2"
            >Editar</button>
            </div>
        </div>
    </div>



</div>

